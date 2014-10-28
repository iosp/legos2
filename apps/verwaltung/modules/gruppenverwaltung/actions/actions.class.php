<?php

/**
 * gruppenverwaltung actions.
 *
 * @package    legos2
 * @subpackage gruppenverwaltung
 * @author     jan
 */
class gruppenverwaltungActions extends sfActions {
	/**
	 * Diese Action lädt die Übersichtsseite der Gruppenverwaltung mit einer Liste aller Gruppen.
	 */
	public function executeIndex(sfWebRequest $request) {
		$this->gruppen = GruppePeer::doSelect ( new Criteria () );
		
		// Formular, mit dem neue Gruppen hinzugefügt werden können.
		$this->form = new GruppenverwaltungForm ();
		
		/*
		 * Wenn eine neue Gruppe angelegt wird, landen wir hier.
		 */
		if ($request->isMethod ( 'post' )) {
			$this->form->bind ( $request->getParameter ( $this->form->getName () ) );
			
			if ($this->form->isValid ()) {
				// Neue Gruppe anlegen
				$gruppe = new Gruppe ();
				$gruppe->setName ( $this->form ['name']->getValue () );
				$gruppe->setBeschreibung ( $this->form ['beschreibung']->getValue () );
				$gruppe->save ();
				
				// Und zurück zum Index-Template
				$this->redirect ( 'gruppenverwaltung/index' );
			} else {
				// Flag-Variable setzen, dass das Formular offen bleibt, um den Fehler zusehen
				$this->show_form = true;
			}
		}
	}
	
	/**
	 * Diese Funktion ändert die Berechtigung einer Gruppe zu einem Modul.
	 */
	public function executeToggleZuordnung(sfWebRequest $request) {
		$gruppe = GruppePeer::retrieveByPk ( $this->getRequestParameter ( 'gruppe' ) );
		$div = $this->getRequestParameter ( 'div' );
		$mod_name = $this->getRequestParameter ( 'mod_name' );
		$credential = $this->getRequestParameter ( 'credential' );
		
		$criteria = new Criteria ();
		$criteria->add ( ModulPeer::NAME, $credential );
		$modul = ModulPeer::doSelectOne ( $criteria );
		
		/*
		 * Die Berechtigung für die Gruppe und das Modul ändern. Dazu prüfen, ob eine entsprechende Zuordnung bereits existiert. Wenn ja, wird diese gelöscht. Wenn nein, wird eine neue angelegt.
		 */
		$this->forward404Unless ( $gruppe && $modul );
		
		$criteria = new Criteria ();
		$criteria->add ( Gruppe_ModulPeer::GRUPPE_ID, $gruppe->getID () );
		$criteria->add ( Gruppe_ModulPeer::MODUL_ID, $modul->getID () );
		$zuordnung = Gruppe_ModulPeer::doSelectOne ( $criteria );
		if ($zuordnung) {
			// Zuordnung besteht bereits. Diese soll nicht mehr gültig sein.
			$zuordnung->delete ();
			$erlaubt = false;
		} else {
			// Zuordnung besteht noch nicht. Diese soll also neu erstellt werden.
			$zuordnung = new Gruppe_Modul ();
			$zuordnung->setGruppe ( $gruppe );
			$zuordnung->setModul ( $modul );
			$zuordnung->save ();
			$erlaubt = true;
		}
		
		// Nach der Aktualisierung der Berechtigung die Tabellenzeile mit dem Modul neu laden.
		return $this->renderPartial ( 'menu_eintrag', array (
				'mod_name' => $mod_name,
				'credential' => $credential,
				'erlaubt' => $erlaubt,
				'divname' => $div,
				'gruppe' => $gruppe->getId () 
		) );
	}
	
	/**
	 * Action der Edit-Ansicht.
	 * Hier werden die benötigten Daten geholt, um die Übersicht über alle Module
	 * und die Berechtigungen der ausgewählten Gruppen erstelen zu können.
	 */
	public function executeEdit($request) {
		$this->gruppe = GruppePeer::retrieveByPk ( $this->getRequestParameter ( 'id' ) );
		$this->forward404Unless ( $this->gruppe );
		
		$this->zugeordnete_modulename = array ();
		$zuordnungen = $this->gruppe->getGruppe_ModulsJoinModul ();
		
		if (! $zuordnungen) {
			/*
			 * Wenn diese Gruppe bisher über keine Berechtigungen verfügt, können wir direkt alle Module als nicht erlaubt nehmen.
			 */
			$criteria = new Criteria ();
			$criteria->addAscendingOrderByColumn ( ModulPeer::NAME );
			$this->nicht_zugeordnete_module = ModulPeer::doSelect ( $criteria );
		} else {
			/*
			 * Alle bestehenden Modulberechtigungen dieser Gruppe durchgehen und eine Liste mit erlaubten und nicht erlaubten Modulen erstellen.
			 */
			$crit_a = new Criteria ();
			$crit_b = new Criteria ();
			$erster_durchlauf = true;
			foreach ( $zuordnungen as $zuordnung ) {
				if ($erster_durchlauf) {
					$erster_durchlauf = false;
					$criterion_a = $crit_a->getNewCriterion ( ModulPeer::ID, $zuordnung->getModulID (), Criteria::NOT_EQUAL );
					$criterion_b = $crit_b->getNewCriterion ( ModulPeer::ID, $zuordnung->getModulID () );
				} else {
					$criterion_a->addAnd ( $crit_a->getNewCriterion ( ModulPeer::ID, $zuordnung->getModulID (), Criteria::NOT_EQUAL ) );
					$criterion_b->addOr ( $crit_b->getNewCriterion ( ModulPeer::ID, $zuordnung->getModulID () ) );
				}
			}
			
			// Nicht erlaubte Module sammeln
			$crit_a->add ( $criterion_a );
			$crit_a->addAscendingOrderByColumn ( ModulPeer::NAME );
			$this->nicht_zugeordnete_module = ModulPeer::doSelect ( $crit_a );
			
			// Erlaubte Module sammeln
			$crit_b->add ( $criterion_b );
			$crit_b->addAscendingOrderByColumn ( ModulPeer::NAME );
			$this->zugeordnete_module = ModulPeer::doSelect ( $crit_b );
			
			foreach ( $this->zugeordnete_module as $zugeordnetes_modul ) {
				$name = strtolower ( $zugeordnetes_modul->getName () );
				$this->zugeordnete_modulename [$name] = $name;
			}
		} // Ende vom Sammeln erlaubter/nicht erlaubter Module
		
		/*
		 * Sämtliche Module nun nach Applikation sortiert in einem Array verschachteln.
		 */
		// YAML-Datei mit Menüstruktur laden
		$menu = sfYaml::load ( sfConfig::get ( 'sf_root_dir' ) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'menu.yml' );
		
		$this->erlaubteModule = array ();
		foreach ( $menu as $topmenu_entry ) {
			// Es gibt keine Submenüs, wir haben also direkt die Applikation
			if (array_key_exists ( "modules", $topmenu_entry )) {
				$app = $topmenu_entry ['top'];
				
				// Applikationsname und -link holen
				$this->erlaubteModule [$app] = array ();
				$this->erlaubteModule [$app] ['applikation'] = $app;
				$this->erlaubteModule [$app] ['applikation_link'] = $topmenu_entry ['applikation'];
				// Es folgen die Module
				$this->erlaubteModule [$app] ['module'] = array ();
				foreach ( $topmenu_entry ['modules'] as $modul => $name ) {
					$this->erlaubteModule [$app] ['module'] [] = array (
							$modul => $name 
					);
				}
			} 			// Es gibt Submenüs. Diese gehen wir durch und behandeln sie jeweils als eigene Applikation
			else {
				// Die Bezeichnung des Top-Menüs rauswerfen, weil es hier nicht benötigt wird.
				unset ( $topmenu_entry ['top'] );
				
				foreach ( $topmenu_entry as $submenu_entry ) {
					$app = $submenu_entry ['sub'];
					
					// Applikationsname und -link holen
					$this->erlaubteModule [$app] = array ();
					$this->erlaubteModule [$app] ['applikation'] = $app;
					$this->erlaubteModule [$app] ['applikation_link'] = $submenu_entry ['applikation'];
					// Es folgen die Module
					$this->erlaubteModule [$app] ['module'] = array ();
					foreach ( $submenu_entry ['modules'] as $modul => $name ) {
						$this->erlaubteModule [$app] ['module'] [] = array (
								$modul => $name 
						);
					}
				}
			}
		}
		
		// Für das Template noch Gruppenname und Gruppen-ID bereit stellen.
		$this->gruppeId = $this->gruppe->getId ();
		$this->gruppenname = $this->gruppe->getName ();
	}
	
	/**
	 * Diese Action löscht eine Gruppe.
	 * Dabei werden auch alle Verknüpfungen zu Benutzern und
	 * Modulberechtigungen dieser Gruppe gelöscht.
	 */
	public function executeDelete() {
		$gruppe = GruppePeer::retrieveByPk ( $this->getRequestParameter ( 'id' ) );
		$this->forward404Unless ( $gruppe );
		
		/*
		 * Alle Verknüpfungen zu Nutzern löschen.
		 */
		$criteria = new Criteria ();
		$criteria->add ( Benutzer_GruppePeer::GRUPPE_ID, $gruppe->getId () );
		Benutzer_GruppePeer::doDelete ( $criteria );
		
		/*
		 * Alle Berechtigungen der Gruppe löschen.
		 */
		$criteria = new Criteria ();
		$criteria->add ( Gruppe_ModulPeer::GRUPPE_ID, $gruppe->getId () );
		Gruppe_ModulPeer::doDelete ( $criteria );
		
		/*
		 * Alle Berechtigungen der Gruppe für Werkstatt-Kunden löschen.
		 */
		$criteria = new Criteria ();
		$criteria->add ( Gruppe_WerkstattkundePeer::GRUPPE_ID, $gruppe->getId () );
		Gruppe_WerkstattkundePeer::doDelete ( $criteria );
		
		/*
		 * Und jetzt die Gruppe löschen.
		 */
		$gruppe->delete ();
		
		return $this->redirect ( 'gruppenverwaltung/index' );
	}
}