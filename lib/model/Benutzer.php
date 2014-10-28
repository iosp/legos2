<?php

/**
 * Subclass for representing a row from the 'benutzer' table.
 *
 * Hier sind alle Benutzer des Systems gespeichert
 *
 * @package lib.model
 */
class Benutzer extends BaseBenutzer {
	public function __toString() {
		return $this->getName ();
	}
	
	/**
	 * Für einen neuen User einen Salt-String erzeugen und ein gesalzenes und gehashtes Passwort anlegen.
	 * Diese Funktion
	 * überschreibt BaseBenutzer::setPasswort, damit versehentliches Setzen eines unsicheren Passworts verhindert wird.
	 *
	 * Übersicht über die Technik des Salzen und Hashens von Passwörtern: http://crackstation.net/hashing-security.htm
	 *
	 * @param $passwort String        	
	 */
	public function setPasswort($passwort) {
		/*
		 * Salt-String als Cryptographically Secure Pseudo-Random Number erzeugen. Wir können es uns leisten 200 einen 200 Byte langen Salt-String zu nehmen. Damit es ein String wird, wandeln wir den binären Crypto-vector in einen base64-kodierten String um (Dieser ist dann 275 Byte lang, siehe http://stackoverflow.com/questions/1533113/calculate-the-size-to-a-base-64-encoded-message).
		 */
		$salt = base64_encode ( mcrypt_create_iv ( 200 ) );
		$this->setSaltString ( $salt );
		
		/*
		 * Das Passwort wird and den Salt-String angehängt und SHA256 gehasht. Wir müssen die depricated Funktion mhash() nutzen, weil auf dem Server das php5-hash Modul nicht verfügbar ist, welches Nachfolger von mhash ist. mhash() gibt binäre Daten zurück, diese müssen wir wieder zu einem String machen - mittels base64_encode().
		 */
		$this->setPasswortSalted ( base64_encode ( mhash ( MHASH_SHA256, ( string ) $salt . $passwort ) ) );
	}
	
	/**
	 * Diese Funktion prüft die Korrektheit des Benutzer-Passworts.
	 *
	 * @param $passwort String        	
	 */
	public function pruefePasswort($passwort) {
		/*
		 * Besitzt der Nutzer nur ein altes md5-gehashtes Passwort? Oder schon ein gesalzenes SHA256-gehashtes?
		 */
		if ($this->getPasswort () != "" || $this->getPasswort () != null) {
			/*
			 * Es ist ein altes, md5-gehashtes Passwort gespeichert. Dieses in ein gesalzenes SHA256 gehashtes Passwort überführen, den unsicheren md5-Hash löschen und den Login erfolgreich abschließen.
			 */
			if ($this->getPasswort () == md5 ( $passwort )) {
				// Gesalzenes Passwort anlegen
				$this->setPasswort ( $passwort );
				
				// setPasswort() von BaseBenutzer nehmen, damit nicht die geerbte Funktion in dieser Klasse
				// verwendet wird.
				parent::setPasswort ( null );
				$this->save ();
				
				return true;
			} else {
				// Falsches Passwort eingegeben
				return false;
			}
		} elseif ($this->getPasswortSalted ()) {
			/*
			 * Wir haben ein neues gesalzenes SHA256 gehashtes Passwort. Dieses Passwort prüfen.
			 */
			return (base64_encode ( mhash ( MHASH_SHA256, ( string ) $this->getSaltString () . $passwort ) ) == $this->getPasswortSalted ());
		}
	}
}
