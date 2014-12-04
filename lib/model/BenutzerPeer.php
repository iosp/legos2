<?php

/**
 * Subclass for performing query and update operations on the 'benutzer' table.
 *
 * Hier sind alle Benutzer des Systems gespeichert
 *
 * @package lib.model
 */
class BenutzerPeer extends BaseBenutzerPeer {
	
	static public function GetGroupByUserId($userId){		 
		$criteria = new Criteria();
		$criteria->add(Benutzer_GruppePeer::BENUTZER_ID, strval($userId));
		$userGroup = Benutzer_GruppePeer::doSelectone($criteria);
		$group = $userGroup->getGruppe();		
		return $group;
	}
}
