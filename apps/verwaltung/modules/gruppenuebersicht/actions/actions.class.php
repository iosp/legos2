<?php

/**
 * gruppenuebersicht actions.
 *
 * @package    legos2
 * @subpackage gruppenuebersicht
 * @author     kspiekermann
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class gruppenuebersichtActions extends sfActions {
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request
	 *        	A request object
	 */
	public function executeIndex(sfWebRequest $request) {
		// Gruppen auslesen
		$c = new Criteria ();
		$c->addAscendingOrderByColumn ( GruppePeer::NAME );
		$groups = GruppePeer::doSelect ( $c );
		$this->group_select_array = array ();
		$this->group_select_array [0] = "Alle";
		foreach ( $groups as $group ) {
			$this->group_select_array [$group->getid ()] = $group->getName ();
		}
		
		// Namen auslesen
		$e = new Criteria ();
		$e->addAscendingOrderByColumn ( BenutzerPeer::NAME );
		$names = BenutzerPeer::doSelect ( $e );
		$this->name_select_array = array ();
		$this->name_select_array [0] = "Alle";
		foreach ( $names as $name ) {
			$this->name_select_array [$name->getid ()] = $name->getName ();
		}
		
		$this->form = new UebersichtForm ( array (
				'group' => $this->group_select_array,
				'user' => $this->name_select_array 
		) );
		$this->form->bind ( $request->getParameter ( 'uebersicht' ) );
		
		// Folgend Fallunterscheidung ob nach Gruppe oder Benutzer spezifiziert wird:
		// 0 = Alle -> keine Spezifizierung
		
		$d = new Criteria ();
		if ($this->form->getValue ( 'group' ) != 0) {
			$d->add ( Benutzer_GruppePeer::GRUPPE_ID, $this->form->getValue ( 'group' ) );
		} else if ($this->form->getValue ( 'user' ) != 0) {
			$d->add ( Benutzer_GruppePeer::BENUTZER_ID, $this->form->getValue ( 'user' ) );
		}
		$this->benutzer_gruppe = Benutzer_GruppePeer::doSelect ( $d );
	}
}
