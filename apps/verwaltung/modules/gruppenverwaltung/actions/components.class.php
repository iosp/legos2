<?php
class GruppenverwaltungComponents extends sfComponents {
	/**
	 * Diese Component regelt die Zuordnung der Werkstattkunden zu Benutzergruppen.
	 * Da die Gruppenverwaltung relativ komplex ist, wurde die Funktionalität in diese
	 * Component ausgelagert.
	 */
	public function executeWerkstattkundenZuordnung() {
		$gruppe = GruppePeer::retrieveByPk ( $this->gruppe_id );
		
		/*
		 * Alle der Gruppe zugeordneten Kunden
		 */
		$crit_gruppe_kunden = new Criteria ();
		$crit_gruppe_kunden->add ( GruppePeer::ID, $gruppe->getId () );
		$crit_gruppe_kunden->addAscendingOrderByColumn ( WerkstattKundePeer::NAME );
		$this->gruppe_kunden = Gruppe_WerkstattKundePeer::doSelectJoinAll ( $crit_gruppe_kunden );
		
		/*
		 * Alle nicht zugeordneten Kunden
		 */
		$kunden_ids = array ();
		foreach ( $this->gruppe_kunden as $kunde ) {
			$kunden_ids [] = $kunde->getWerkstattKundeId ();
		}
		$crit_nicht_zugeordnet = new Criteria ();
		$crit_nicht_zugeordnet->addAscendingOrderByColumn ( WerkstattKundePeer::NAME );
		$crit_nicht_zugeordnet->add ( WerkstattKundePeer::ID, $kunden_ids, Criteria::NOT_IN );
		$this->nicht_zugeordnet = WerkstattKundePeer::doSelect ( $crit_nicht_zugeordnet );
	}
}
?>
