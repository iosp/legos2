<?php

/**
 * benutzerverwaltung actions.
 *
 * @package    legos2
 * @subpackage benutzerverwaltung
 * @author     jan
 */
class benutzerverwaltungActions extends sfActions {
	/**
	 * Executes index action
	 */
	public function executeIndex() {
		$this->forward ( 'benutzerverwaltung', 'list' );
	}
	
	/**
	 * Executes list action
	 */
	public function executeList() {
		$this->benutzers = BenutzerPeer::doSelect ( new Criteria () );
	}
	
	/**
	 * Sowohl Edit als auch Create werden über diese Methode ausgeführt.
	 * Letzteres wird dadurch erkannt, dass keine ID übergeben wird.
	 */
	public function executeEdit($request) {
		// Wenn eine ID übergeben wurde (=edit), Benutzer holen
		if ($this->getRequestParameter ( 'id' )) {
			$this->benutzer = BenutzerPeer::retrieveByPk ( $this->getRequestParameter ( 'id' ) );
			$this->forward404Unless ( $this->benutzer );
		} 		// Wenn keine ID übergeben wurde (=create), neuen Benutzer erstellen
		else {
			$this->benutzer = new Benutzer ();
		}
		
		// Formular erstellen
		$this->form = new BenutzerverwaltungForm ();
		
		// Wenn eine ID übergeben wurde (=edit), DefaultValues setzen
		if ($this->getRequestParameter ( 'id' )) {
			$this->form->setDefaults ( array (
					'edit_new' => 'edit',
					'name' => $this->benutzer->getName (),
					'login' => $this->benutzer->getLogin (),
					'beschreibung' => $this->benutzer->getBeschreibung () 
			) );
		}
		
		// Wenn Daten über das Formular gesendet wurden ("zweite Runde)
		if ($request->isMethod ( 'post' ) || $request->isMethod ( 'put' )) {
			$this->form->bind ( $request->getParameter ( $this->form->getName () ) );
			if ($this->form->isValid ()) {
				
				// Daten setzen und speichern
				$this->benutzer->setName ( $this->form ['name']->getValue () );
				$this->benutzer->setPasswort ( $this->form ['passwort']->getValue () );
				$this->benutzer->setLogin ( $this->form ['login']->getValue () );
				$this->benutzer->setBeschreibung ( $this->form ['beschreibung']->getValue () );
				$this->benutzer->save ();
				
				// Zurück zur Auflistung
				return $this->redirect ( 'benutzerverwaltung/list' );
			}
		}
	}
	public function executeDelete() {
		$benutzer = BenutzerPeer::retrieveByPk ( $this->getRequestParameter ( 'benutzer_id' ) );
		$this->forward404Unless ( $benutzer );
		
		$c = new Criteria ();
		$c->add ( Benutzer_GruppePeer::BENUTZER_ID, $benutzer->getID () );
		Benutzer_GruppePeer::doDelete ( $c );
		
		$benutzer->delete ();
		
		return $this->redirect ( 'benutzerverwaltung/list' );
	}
	public function executeGruppe() {
		$benutzer = BenutzerPeer::retrieveByPk ( $this->getRequestParameter ( 'benutzer_id' ) );
		$this->benutzer = $benutzer;
		$this->forward404Unless ( $benutzer );
		
		$zuordnungen_gruppe = $benutzer->getBenutzer_GruppesJoinGruppe ();
		$zuordnungen_modul = $benutzer->getBenutzer_ModulsJoinModul ();
		$crit_a = new Criteria ();
		$crit_b = new Criteria ();
		$crit_c = new Criteria ();
		$crit_d = new Criteria ();
		$erster_durchlauf = true;
		
		foreach ( $zuordnungen_gruppe as $zuordnung ) {
			if ($erster_durchlauf) {
				$erster_durchlauf = false;
				$criterion_a = $crit_a->getNewCriterion ( GruppePeer::ID, $zuordnung->getGruppeID (), Criteria::NOT_EQUAL );
				$criterion_b = $crit_b->getNewCriterion ( GruppePeer::ID, $zuordnung->getGruppeID () );
			} else {
				$criterion_a->addAnd ( $crit_a->getNewCriterion ( GruppePeer::ID, $zuordnung->getGruppeID (), Criteria::NOT_EQUAL ) );
				$criterion_b->addOr ( $crit_b->getNewCriterion ( GruppePeer::ID, $zuordnung->getGruppeID () ) );
			}
		}
		
		$erster_durchlauf = true;
		foreach ( $zuordnungen_modul as $zuordnung ) {
			if ($erster_durchlauf) {
				$erster_durchlauf = false;
				$criterion_c = $crit_c->getNewCriterion ( ModulPeer::ID, $zuordnung->getModulID (), Criteria::NOT_EQUAL );
				$criterion_d = $crit_d->getNewCriterion ( ModulPeer::ID, $zuordnung->getModulID () );
			} else {
				$criterion_c->addAnd ( $crit_c->getNewCriterion ( ModulPeer::ID, $zuordnung->getModulID (), Criteria::NOT_EQUAL ) );
				$criterion_d->addOr ( $crit_d->getNewCriterion ( ModulPeer::ID, $zuordnung->getModulID () ) );
			}
		}
		// Gruppen werden zusammengestellt
		
		if (isset ( $criterion_a )) {
			$crit_a->add ( $criterion_a );
			$crit_a->addAscendingOrderByColumn ( GruppePeer::NAME );
			$this->nicht_zugeordnete_gruppen = GruppePeer::doSelect ( $crit_a );
		}
		if (isset ( $criterion_b )) {
			$crit_b->add ( $criterion_b );
			$crit_b->addAscendingOrderByColumn ( GruppePeer::NAME );
			$this->zugeordnete_gruppen = GruppePeer::doSelect ( $crit_b );
		}
		if (! isset ( $criterion_a ) && ! isset ( $criterion_b )) {
			$criteria = new Criteria ();
			$criteria->addAscendingOrderByColumn ( GruppePeer::NAME );
			$this->nicht_zugeordnete_gruppen = GruppePeer::doSelect ( $criteria );
		}
		// Module werden zusammengestellt
		
		$modul_exclude = array ();
		if ($this->zugeordnete_gruppen) {
			foreach ( $this->zugeordnete_gruppen as $gruppen ) {
				$c = new Criteria ();
				$c->add ( Gruppe_ModulPeer::GRUPPE_ID, $gruppen->getID () );
				$modul_exclude [] = Gruppe_ModulPeer::doSelect ( $c );
			}
		}
		
		$ids = array ();
		foreach ( $modul_exclude as $module ) {
			foreach ( $module as $modul ) {
				$ids [] = $modul->getmodulID (); // Die IDs der durch Gruppenzugehörigkeit freigeschalteten Module werden in diesem Array gesammelt
			}
		}
		
		$crit_c->addAND ( ModulPeer::ID, $ids, Criteria::NOT_IN ); // Nur Module, die nicht schon durch Gruppen zugewiesen sind
		$crit_c->addAscendingOrderByColumn ( ModulPeer::NAME );
		$this->nicht_zugeordnete_module = ModulPeer::doSelect ( $crit_c );
		
		if (isset ( $criterion_d )) {
			$crit_d->add ( $criterion_d );
			$crit_d->addAscendingOrderByColumn ( ModulPeer::NAME );
			$this->zugeordnete_module = ModulPeer::doSelect ( $crit_d );
		}
		
		$this->benutzer = $benutzer;
	}
	public function executeAddGruppe() {
		$gruppe = GruppePeer::retrieveByPk ( $this->getRequestParameter ( 'gruppe_id' ) );
		$benutzer = BenutzerPeer::retrieveByPk ( $this->getRequestParameter ( 'benutzer_id' ) );
		$this->forward404Unless ( $gruppe && $benutzer );
		
		$zuordnung = new Benutzer_Gruppe ();
		$zuordnung->setGruppe ( $gruppe );
		$zuordnung->setBenutzer ( $benutzer );
		
		$zuordnung->save ();
		
		return $this->redirect ( 'benutzerverwaltung/gruppe?benutzer_id=' . $benutzer->getID () );
	}
	public function executeAddModul() {
		$modul = ModulPeer::retrieveByPk ( $this->getRequestParameter ( 'modul_id' ) );
		$benutzer = BenutzerPeer::retrieveByPk ( $this->getRequestParameter ( 'benutzer_id' ) );
		$this->forward404Unless ( $modul && $benutzer );
		
		$zuordnung = new Benutzer_Modul ();
		$zuordnung->setModul ( $modul );
		$zuordnung->setBenutzer ( $benutzer );
		
		$zuordnung->save ();
		
		return $this->redirect ( 'benutzerverwaltung/gruppe?benutzer_id=' . $benutzer->getID () );
	}
	public function executeDeleteGruppe() {
		$gruppe = GruppePeer::retrieveByPk ( $this->getRequestParameter ( 'gruppe_id' ) );
		$benutzer = BenutzerPeer::retrieveByPk ( $this->getRequestParameter ( 'benutzer_id' ) );
		$this->forward404Unless ( $gruppe && $benutzer );
		
		$c = new Criteria ();
		$c->add ( Benutzer_GruppePeer::GRUPPE_ID, $gruppe->getID () );
		$c->add ( Benutzer_GruppePeer::BENUTZER_ID, $benutzer->getID () );
		$zuordnung = Benutzer_GruppePeer::doSelectOne ( $c );
		$zuordnung->delete ();
		
		return $this->redirect ( 'benutzerverwaltung/gruppe?benutzer_id=' . $benutzer->getID () );
	}
	public function executeDeleteModul() {
		$modul = ModulPeer::retrieveByPk ( $this->getRequestParameter ( 'modul_id' ) );
		$benutzer = BenutzerPeer::retrieveByPk ( $this->getRequestParameter ( 'benutzer_id' ) );
		$this->forward404Unless ( $modul && $benutzer );
		
		$c = new Criteria ();
		$c->add ( Benutzer_ModulPeer::MODUL_ID, $modul->getID () );
		$c->add ( Benutzer_ModulPeer::BENUTZER_ID, $benutzer->getID () );
		$zuordnung = Benutzer_ModulPeer::doSelectOne ( $c );
		$zuordnung->delete ();
		
		return $this->redirect ( 'benutzerverwaltung/gruppe?benutzer_id=' . $benutzer->getID () );
	}
}
