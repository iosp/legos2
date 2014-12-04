<?php

/**
 * maintenance_tow actions.
 *
 * @package    legos2
 * @subpackage maintenance_tow
 * @author     Moshe Beutel
 */
class maintenance_towActions extends sfActions {
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request
	 *        	A request object
	 */
	public function executeIndex(sfWebRequest $request) {
		// $this->forward('default', 'module');
		$this->route = $this->getController ()->genUrl ( 'maintenance_tow/show' );
	}
	
	/**
	 * Controller for show action - show imported file's content
	 *
	 * @param sfWebRequest $request
	 *        	A request object
	 */
	public function executeShow(sfWebRequest $request) {
		$this->route = $this->getController ()->genUrl ( 'maintenance_tow/show' );
		require_once sfConfig::get ( 'app_lib_helper' ) . "/TimeHelper.php";
		
		// get the 'from' date of time interval string format
		$this->from_str = $request->getParameter ( 'auswahl[tag_einzeln]' );
		
		$tail_number = $request->getParameter ( 'auswahl[TailNumber]' );
		
		if ($tail_number == '') {
			$tail_number = - 1;
			$this->tailNumber = "No selected";
			return;
		} else {
			$this->tailNumber = $tail_number;
		}
		
		$this->selected_taxibot_name = $request->getParameter ( 'auswahl[TaxibotNumber]' );
		if ($this->selected_taxibot_name == '') {
			$tractorId = -1;
			$this->selected_taxibot_name = "No selected";
			return ;
		} else {
			$tractor = TaxibotTractorPeer::GetTractorByName ( $this->selected_taxibot_name );
			$tractorId = $tractor->getId ();
		}
		// echo $this->taxibot_name ; die();
		
		$this->mainTows = TaxibotMissionPeer::getMaintenanceByTailNumber ( $this->from_str, $this->tailNumber, $tractorId );
		
		//print "<pre>"; print_r ( $this->mainTows ); print "</pre>"; die();
	/* 	
		
		
		$this->mainTows = array ();
		
		foreach ( $missionMaints as $maint ) {
			
			$duration = SecToDateInterval ( $maint->getMaintTime () );
			
			$this->tractorId = $maint->getTractorId ();
			
			$this->mainTows [] = array (
					'Start' => $maint->getStartTime (),
					'End' => $maint->getEndTime (),
					'Time' => $duration->format ( "%H:%I:%S" ),
					'LeftEngineFuel' => $maint->getLeftEngineFuelMaint (),
					'RightEngineFuel' => $maint->getRightEngineFuelMaint () 
			);
		} */
		
		$this->exportFilename = $this->saveToXml ();
	}
	
	/**
	 * Save tables to a worksheet in using xml writer
	 * 
	 * @return string - export filename
	 */
	private function saveToXml() {
		
		// XML-Object
		$xml = new LegosXmlWriter ();
		
		// Name Worksheet
		$xml->setWorksheetName ( "Maintenance Tows $this->from_str" );
		
		$i = 0;
		foreach ( $this->mainTows as $maint ) {
			
			++ $i;
			$xml->writeData ( "Maint-Tow Start", $i, 1 );
			$xml->writeData ( $maint->maintStartDate, $i, 2 );
			
			++ $i;
			$xml->writeData ( "Maint-Tow End", $i, 1 );
			$xml->writeData ( $maint->maintEndDate, $i, 2 );
			
			++ $i;
			$xml->writeData ( "Maint TIME", $i, 1 );
			$xml->writeData ($maint->maintTotalTime, $i, 2 );
			
			++ $i;
			$xml->writeData ( "Left Engine Fuel", $i, 1 );
			$xml->writeData ( $maint->leftEngineFuel, $i, 2 );
			
			++ $i;
			$xml->writeData ( "Right Engine Fuel", $i, 1 );
			$xml->writeData ( $maint->rightEngineFuel, $i, 2 );
			
			++ $i;
		}
		
		$exportFilename = "Export_Mission_$this->missionId " . date ( 'Y-m-d h:i:s' ) . '.xls';
		
		file_put_contents ( sfConfig::get ( 'app_export_path' ) . "/" . $exportFilename, $xml->getFile () );
		
		return $exportFilename;
	}
	
	/**
	 * Controller for the Export action
	 * 
	 * @param sfWebRequest $request        	
	 * @return sfView::NONE - Don't return any layout or template
	 */
	public function executeExport(sfWebRequest $request) {
		$this->setLayout ( false );
		
		// Data
		$filename = $request->getParameter ( 'file' );
		
		// Set content type to XLS although it is an xml-file
		$this->getResponse ()->setContentType ( 'application/msexcel' );
		$this->getResponse ()->setHttpHeader ( 'Content-Disposition', sprintf ( 'attachment; filename="%s"', $filename ) );
		$this->getResponse ()->sendHttpHeaders ();
		$this->getResponse ()->setContent ( file_get_contents ( sfConfig::get ( 'app_export_path' ) . "/" . $filename ) );
		
		// Don't return any layout or template
		return sfView::NONE;
	}
}
