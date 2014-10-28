<?php

/**
 * log_history actions.
 *
 * @package    legos2
 * @subpackage log_history
 * @author     Your name here
 *
 */
class log_historyActions extends sfActions {
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request
	 *        	A request object
	 */
	public function executeIndex(sfWebRequest $request) {
		$this->route = $this->getController ()->genUrl ( 'log_history/content' );
	}
	
	/**
	 * Zeigt ein Gantt-Chart an
	 */
	public function executeContent(sfWebRequest $request) {
		$this->from = date ( "Y-m-d", $request->getParameter ( 'auswahl[von]' ) );
		$this->to = date ( "Y-m-d", $request->getParameter ( 'auswahl[bis]' ) );
		$this->AcTypes = $request->getParameter ( 'auswahl[AircrftTypes]' );
		$this->ExceedFilter = $request->getParameter ( 'auswahl[exceedFilterButton]' );
		
		$startTimeInterval = strtotime ( $this->from . " 00:00:00" );
		$endTimeIntarval = strtotime ( $this->to . " 23:59:00" );
		
		// For large file imports this may take a while
		ini_set ( "memory_limit", "2048M" );
		set_time_limit ( 1000 );
		
		$criteria = new Criteria ();
		
		$criteria->add ( TaxibotStackPeer::UTC_TIME, $startTimeInterval, Criteria::GREATER_EQUAL );
		$criteria->addAnd ( TaxibotStackPeer::UTC_TIME, $endTimeIntarval, Criteria::LESS_EQUAL );
		
		if (strstr ( $this->AcTypes, 'ALL TYPES' ) == '') {
			$criteria->add ( TaxibotStackPeer::AIRCRAFT_TYPE, explode ( ',', trim ( $this->AcTypes ) ), CRITERIA::IN );
		}
		
		if (strstr ( $this->ExceedFilter, 'fatigue' ) != '') {
			$criteria->add ( TaxibotStackPeer::IS_EXCEEDING, true );
		}
		
		$this->records = TaxibotStackPeer::doSelect ( $criteria );
	}
	
	/**
	 * Diese Funktion holt alle Daten des ausgewählten Zeitraums aus dem DataWarehouse und lässt diese
	 * durch die Funktion statusAenderungenEintragen() so aufbereiten, dass das Gantt-Chart gezeichnet
	 * werden kann.
	 *
	 * @param
	 *        	String Datum im Format yyyy-mm-dd
	 */
	private function erzeugeChartData($datum) {
		$this->startzeitpunkt = 0;
		$this->endzeitpunkt = DatumZeit::getMinutenProTag ( strtotime ( $datum ) );
		
		$zeitstempel_von = strtotime ( $datum . " 00:00:00" );
		$zeitstempel_bis = strtotime ( $datum . " 23:59:00" );
		
		// $gesamtdauer gibt die gesamte Zeit in Minuten an
		$gesamtdauer = (($zeitstempel_bis - $zeitstempel_von) / 60) + 1;
		
		// Array, in dem später alle Daten fürs Gantt-Chart drin landen
		$this->chartData = array ();
		
		// Alle Schlepper alphabetisch holen, um diese anschließend einzeln durchzugehen.
		$criteria = new Criteria ();
		
		// Vorbereitung für Gelöscht-Criteria.
		$crit0 = $criteria->getNewCriterion ( SchlepperPeer::GELOESCHT, false );
		$crit1 = $criteria->getNewCriterion ( SchlepperPeer::GELOESCHT, null, Criteria::ISNULL );
		$crit2 = $criteria->getNewCriterion ( SchlepperPeer::LOESCHDATUM, $datum, Criteria::GREATER_THAN );
		// Perform OR at level 0 ($crit0 $crit1 $crit2 )
		$crit0->addOr ( $crit1 );
		$crit0->addOr ( $crit2 );
		
		$criteria->add ( $crit0 );
		$criteria->addAscendingOrderByColumn ( SchlepperPeer::NAME );
		$alle_schlepper = SchlepperPeer::doSelect ( $criteria );
		
		// Alle Schlepper durchgehen
		foreach ( $alle_schlepper as $aktueller_schlepper ) {
			/*
			 * Schlepper-Daten aus dem DWH holen. Hierbei nur den ausgewählten Zeitraum berücksichtigen (Join auf Zeitstempel-Tabelle).
			 */
			$criteria = new Criteria ();
			$criteria->add ( DWHSchlepperstatusPeer::SCHLEPPER_ID, $aktueller_schlepper->getId () );
			$criteria->add ( DWHSchlepperstatusPeer::ZEITSTEMPEL, $zeitstempel_von, Criteria::GREATER_EQUAL );
			$criteria->addAnd ( DWHSchlepperstatusPeer::ZEITSTEMPEL, $zeitstempel_bis, Criteria::LESS_EQUAL );
			$criteria->addAscendingOrderByColumn ( DWHSchlepperstatusPeer::ZEITSTEMPEL );
			
			$dwh_schlepper_statuss = DWHSchlepperstatusPeer::doSelect ( $criteria );
			
			/*
			 * In die Variable chartData nur die Statusänderungen übernehmen. Dazu macht die Funktion statusAenderungenEintragen() aus den minütlichen DWH-Daten jeweils nur einen Datensatz pro Statusänderung.
			 */
			$this->chartData [$aktueller_schlepper->getID ()] = $this->statusAenderungenEintragen ( $dwh_schlepper_statuss, $gesamtdauer, $aktueller_schlepper->getId (), $zeitstempel_von, $zeitstempel_bis );
		}
	}
}
