<?php
class Login {
	/**
	 * Diese Funktion führt die nach dem eigentlichen Login nötigen Sachen durch.
	 * Es werden die Credentials gesetzt, die Module entsprechend der Berechtigungen
	 * in die Session geschrieben.
	 */
	public static function doLogin($benutzer) {
		/*
		 * Credentials für die Module entsprechend der Berechtigungen des Nutzers anlegen.
		 */
		$erlaubteModule = array ();
		
		// Erlaubte Module durch Gruppenzugehörigkeit holen
		$criteria = new Criteria ();
		$criteria->addJoin ( Benutzer_GruppePeer::GRUPPE_ID, Gruppe_ModulPeer::GRUPPE_ID, Criteria::LEFT_JOIN );
		$criteria->addJoin ( Gruppe_ModulPeer::MODUL_ID, ModulPeer::ID, Criteria::LEFT_JOIN );
		$criteria->add ( Benutzer_GruppePeer::BENUTZER_ID, $benutzer->getId () );
		$module = ModulPeer::doSelect ( $criteria );
		foreach ( $module as $modul ) {
			sfContext::getInstance ()->getUser ()->addCredential ( $modul->getName () );
			$credential = explode ( '-', $modul->getName () );
			$erlaubteModule [] = $credential [0];
		}
		
		// Individuell erlaubte Module des Nutzers holen
		$criteria = new Criteria ();
		$criteria->addJoin ( Benutzer_ModulPeer::MODUL_ID, ModulPeer::ID, Criteria::LEFT_JOIN );
		$criteria->add ( Benutzer_ModulPeer::BENUTZER_ID, $benutzer->getID () );
		$module = ModulPeer::doSelect ( $criteria );
		foreach ( $module as $modul ) {
			sfContext::getInstance ()->getUser ()->addCredential ( $modul->getName () );
			$credential = explode ( '-', $modul->getName () );
			$erlaubteModule [] = $credential [0];
		}
		
		// Evtl. doppelte Einträge entfernen (entstanden aus Gruppenzuordnung und Einzelberechtigung)
		$erlaubteModule = array_unique ( $erlaubteModule );
		
		// Credentials setzen
		sfContext::getInstance ()->getUser ()->setAttribute ( 'name', $benutzer->getName (), 'benutzer' );
		sfContext::getInstance ()->getUser ()->setAttribute ( 'id', $benutzer->getID (), 'benutzer' );
		sfContext::getInstance ()->getUser ()->setAttribute ( 'applikationen', $erlaubteModule, 'benutzer' );
	}
}
