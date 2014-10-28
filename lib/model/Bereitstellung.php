<?php

/**
 * Diese Klasse enthält sämtliche Funktionen, die für Bereitstellungen relevant sind. Funktionen, die auf alle
 * Schleppvorgangsarten anwendbar sind, sind in der Mutterklasse 'Schleppvorgang' definiert.
 */
class Bereitstellung extends Schleppvorgang {
	
	/**
	 * Wenn neuer Bereitstellung angelegt wird, dann die Vorgangsart für die Nachbearbeitung auch zunächst auf Bereitstellung setzen.
	 * Sie wird evtl. später in der Schleppernachbearbeitung geändert.
	 */
	public function __construct() {
		parent::__construct ();
		
		$this->setSchleppvorgangVorgangsartId ( SchleppvorgangPeer::CLASSKEY_2 );
	}
	
	/**
	 * Diese Funktion prüüft, ob während einer Bereitstellung eine Verspätung aufgetreten ist
	 * und gibt anschließend true zurück.
	 * Wenn keine Verspätung vorliegt wird false zurückgegeben.
	 *
	 * @author Michael
	 * @return true, wenn Bereitstellung eine Verspätung hat
	 * @return false, wenn keine Verspätung auftrat
	 */
	function isVerspaetet() {
		$sollzeit = $this->getSollzeit ();
		if ($this->getWatr ( 'U' ) > $sollzeit ['watr'] || $this->getSchlepperAmAc ( 'U' ) > $sollzeit ['schlepper_am_ac'] || $this->getAcRollt ( 'U' ) > $sollzeit ['ac_rollt'] || $this->getAcAufPos ( 'U' ) > $sollzeit ['ac_auf_pos']) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Diese Funktionen berechnet die Sollzeiten für eine Bereitstellung.
	 * Die Zeiten werden
	 * als assoziatives Array mit Timestamps zurückgegeben.
	 *
	 * @author Michael
	 * @return assoziatives Array mit den Sollzeiten der jeweiligen Zeitstempel
	 */
	function getSollzeit() {
		// In diesem Array werden die Sollzeiten als Timestamp zurückgegeben.
		$sollzeit = array ();
		
		// Verspätungsbedingungen für die Flugart holen
		$verspaetungsbedingung = SchleppvorgangVerspaetungsbedingungPeer::retrieveByPk ( $this->getFlugzeugtyp ()->getInterkontinental () );
		if (! $verspaetungsbedingung) {
			/*
			 * Wenn kont/interkont nicht gesetzt ist, Meldung machen und das Skript weiterlaufen lassen, damit das Menü weiterhin erscheint.
			 */
			echo ("'kontinental/interkontinental' bei Flugzeugtyp " . $this->getFlugzeugtyp () . " nachtragen.<br />");
			return;
		}
		
		// Sollzeiten als Timestamps berechnen. Siehe doc/schlepper/verspaetungsuebersicht.
		$sollzeit ['ac_auf_pos'] = $this->getStd ( 'U' ) - $verspaetungsbedingung->getBereitstellungAcAufPos ( 'G' ) * 3600 - $verspaetungsbedingung->getBereitstellungAcAufPos ( 'i' ) * 60;
		$sollzeit ['ac_rollt'] = $sollzeit ['ac_auf_pos'] - $verspaetungsbedingung->getBereitstellungAcRollt ( 'G' ) * 3600 - $verspaetungsbedingung->getBereitstellungAcRollt ( 'i' ) * 60;
		$sollzeit ['schlepper_am_ac'] = $sollzeit ['ac_auf_pos'] - $verspaetungsbedingung->getBereitstellungSchlepperAmAc ( 'G' ) * 3600 - $verspaetungsbedingung->getBereitstellungSchlepperAmAc ( 'i' ) * 60;
		$sollzeit ['watr'] = $sollzeit ['ac_auf_pos'] - $verspaetungsbedingung->getBereitstellungWatr ( 'G' ) * 3600 - $verspaetungsbedingung->getBereitstellungWatr ( 'i' ) * 60;
		
		return $sollzeit;
	}
	
	/**
	 * Diese Funktionen berechnet die Toleranzzeiten für eine Bereitstellung.
	 * Die Zeiten
	 * werden als assoziatives Array mit Timestamps zurückgegeben.
	 *
	 * @author Michael
	 * @return assoziatives Array mit den Toleranzzeiten der jeweiligen Zeitstempel
	 */
	function getToleranzzeit() {
		$sollzeit = $this->getSollzeit ();
		$toleranz = array ();
		
		// Verspätungsbedingungen für die Flugart holen
		$verspaetungsbedingung = SchleppvorgangVerspaetungsbedingungPeer::retrieveByPk ( $this->getFlugzeugtyp ()->getInterkontinental () );
		
		// Toleranzzeiten als Timestamps berechnen. Ausgehend von den Sollzeiten wird immer
		// die Toleranz abgezogen
		$toleranz ['watr'] = $sollzeit ['watr'] + $verspaetungsbedingung->getBereitstellungWatrToleranz ( 'G' ) * 3600 + $verspaetungsbedingung->getBereitstellungWatrToleranz ( 'i' ) * 60;
		$toleranz ['schlepper_am_ac'] = $sollzeit ['schlepper_am_ac'] + $verspaetungsbedingung->getBereitstellungSchlepperAmAcToleranz ( 'G' ) * 3600 + $verspaetungsbedingung->getBereitstellungSchlepperAmAcToleranz ( 'i' ) * 60;
		$toleranz ['ac_rollt'] = $sollzeit ['ac_rollt'] + $verspaetungsbedingung->getBereitstellungAcRolltToleranz ( 'G' ) * 3600 + $verspaetungsbedingung->getBereitstellungAcRolltToleranz ( 'i' ) * 60;
		$toleranz ['ac_auf_pos'] = $sollzeit ['ac_auf_pos'] + $verspaetungsbedingung->getBereitstellungAcAufPosToleranz ( 'G' ) * 3600 + $verspaetungsbedingung->getBereitstellungAcAufPosToleranz ( 'i' ) * 60;
		
		return $toleranz;
	}
} // Bereitstellung
