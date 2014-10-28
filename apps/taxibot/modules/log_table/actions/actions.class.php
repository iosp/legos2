 <?php
	
	/**
 * log_table actions.
 *
 * @package    legos2
 * @subpackage log_table
 * @author     Moshe Beutel
 */
	class log_tableActions extends sfActions {
		public function executeExport() {
			$xml = new LegosXmlWriter ();
			$xml->createStyle ( 'heading', 'Font', 'ss:Bold', '1' );
			
			// first line contains column headers
			$heading = array (
					'NLG Longitudal Force',
					'Exceeding Amount',
					'Aircraft Number',
					'Tractor Id',
					'Flight Number',
					'Aircraft Type',
					'Time',
					'Driver Name',
					'Aircraft Weight',
					'Aircraft C.G.',
					'Longitude',
					'Latitude' 
			);
			
			for($i = 0; $i < count ( $heading ); $i ++) {
				$xml->writeData ( $heading [$i], 1, $i + 1, '', '', 'heading', 'String' );
			}
			
			// $records = $this->getUser()->getFlash('records');
			
			// write all records to for xml export
			$i = 2;
			// foreach ($records as $rec)
			// {
			// $xml->writeData($rec->getNlgLogitudalForce(), $i, 1);
			// $xml->writeData($rec->getExceedingAmount(), $i, 2);
			// $xml->writeData($rec->getAircraftTailNumber(), $i, 2);
			/*
			 * $xml->writeData($rec->getTractorId(), $i, 4); $xml->writeData($rec->getFlightNumber(), $i, 5);
			 */
			// $xml->writeData($rec->getAircraftType(), $i, 3);
			// $xml->writeData($rec->getUtcTime(), $i, 4);
			/*
			 * $xml->writeData($rec->getDriverName(), $i, 8); $xml->writeData($rec->getAircraftWeight(), $i, 9); $xml->writeData($rec->getAircraftCenterGravity(), $i, 10);
			 */
			// $xml->writeData($rec->getLatitude(), $i, 3);
			
			// $xml->writeData($rec->getLongitude(), $i, 4);
			
			// $i++;
			// }
			
			// Set content type to XLS although it is an xml-file
			$this->getResponse ()->setContentType ( 'application/msexcel' );
			$this->getResponse ()->setHttpHeader ( 'Content-Disposition', sprintf ( 'attachment; filename="%s"', 'Export_Taxibot_Tables' . date ( 'Y-m-d' ) . '.xls' ) );
			$this->getResponse ()->sendHttpHeaders ();
			$this->getResponse ()->setContent ( $xml->getFile () );
			
			// Don't return any layout or template
			return sfView::NONE;
		}
		
		/**
		 * Executes index action
		 *
		 * @param sfRequest $request
		 *        	A request object
		 */
		public function executeIndex(sfWebRequest $request) {
			$this->route = $this->getController ()->genUrl ( 'log_table/content' );
		}
		
		/**
		 * Executes content action
		 *
		 * @param sfRequest $request
		 *        	A request object
		 */
		public function executeContent(sfWebRequest $request) {
			$criteria = new Criteria ();
			
			$this->from = $request->getParameter ( 'auswahl[von]' );
			
			$this->datum = date ( "Y-m-d", $this->from );
			
			$startTimeInterval = strtotime ( $this->datum . " 00:00:00" );
			$endTimeIntarval = strtotime ( $this->datum . " 23:59:00" );
			
			$criteria->add ( TaxibotStackPeer::UTC_TIME, $startTimeInterval, Criteria::GREATER_EQUAL );
			$criteria->addAnd ( TaxibotStackPeer::UTC_TIME, $endTimeIntarval, Criteria::LESS_EQUAL );
			
			$this->records = TaxibotStackPeer::doSelect ( $criteria );
			
			$this->maxFatigue = 400;
			$this->minFatigue = - 50;
			
			$data = array ();
			foreach ( $this->records as $rec ) {
				$data [] = $rec->getNlgLogitudalForce ();
			}
			
			$this->data = json_encode ( $data );
			
			$this->getUser ()->setFlash ( 'records', $this->records );
		}
		
		/**
		 * Zeigt ein Gantt-Chart an
		 */
		public function executeContent1(sfWebRequest $request) {
			$this->datum = date ( "Y-m-d", $request->getParameter ( 'auswahl[von]' ) );
			
			$this->generateChartData ( $this->datum );
			$this->datenVorhanden = (sizeof ( $this->chartData ) > 0 ? true : false);
			
			// Vorgangsarten für die Erstellung der Legende
			$criteria = new Criteria ();
			$criteria->addAscendingOrderByColumn ( SchleppvorgangVorgangsartPeer::NAME );
			$this->vorgangsarten = SchleppvorgangVorgangsartPeer::doSelect ( $criteria );
		}
		
		/**
		 * Diese Funktion holt alle Daten des ausgewählten Zeitraums aus dem DataWarehouse und lässt diese
		 * durch die Funktion statusAenderungenEintragen() so aufbereiten, dass das Gantt-Chart gezeichnet
		 * werden kann.
		 *
		 * @param
		 *        	String Datum im Format yyyy-mm-dd
		 */
		private function generateChartData($datum) {
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
