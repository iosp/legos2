<?php

/**
 * modulverwaltung actions.
 *
 * @package    legos2
 * @subpackage modulverwaltung
 * @author     jan
 * @version    SVN: $Id: actions.class.php,v 1.2 2008-03-14 10:33:05 jgoebel Exp $
 */
class modulverwaltungActions extends sfActions {
	public function executeIndex() {
		return $this->forward ( 'modulverwaltung', 'list' );
	}
	public function executeList() {
		$criteria = new Criteria ();
		$criteria->addAscendingOrderByColumn ( ModulPeer::NAME );
		$this->module = ModulPeer::doSelect ( $criteria );
	}
	public function executeEdit($request) {
		// Prüfung, ob ID vorhanden (=edit) oder nicht (=create)
		if ($this->getRequestParameter ( 'id' )) {
			$this->modul = ModulPeer::retrieveByPk ( $this->getRequestParameter ( 'id' ) );
			$this->forward404Unless ( $this->modul );
		} else {
			// Neu erstellen
			$this->modul = new Modul ();
		}
		
		// Formular erstellen und bei Bedarf mit Default füllen
		$this->form = new ModulverwaltungForm ();
		if ($this->getRequestParameter ( 'id' )) {
			$this->form->setDefaults ( array (
					'name' => $this->modul->getName () 
			) );
		}
		
		// Wenn Daten über das Formular gesendet wurden, diese entsprechend speichern
		if ($request->isMethod ( 'post' ) || $request->isMethod ( 'put' )) {
			$this->form->bind ( $request->getParameter ( $this->form->getName () ) );
			if ($this->form->isValid ()) {
				$this->modul->setName ( $this->form ['name']->getValue () );
				$this->modul->save ();
				
				return $this->redirect ( 'modulverwaltung/list' );
			}
		}
	}
	public function executeDelete() {
		$modul = ModulPeer::retrieveByPk ( $this->getRequestParameter ( 'id' ) );
		
		$this->forward404Unless ( $modul );
		
		$modul->delete ();
		
		return $this->redirect ( 'modulverwaltung/list' );
	}
}
