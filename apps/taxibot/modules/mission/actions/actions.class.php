<?php

/**
 * mission actions.
 *
 * @package    legos2
 * @subpackage mission
 * @author     Moshe Beutel
 */
class missionActions extends sfActions {
	public $missionPage;
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request
	 *        	A request object
	 */
	public function executeIndex(sfWebRequest $request) {
		// $this->forward('default', 'module');
		$this->route = $this->getController ()->genUrl ( 'mission/show' );
	}
	
	/**
	 * Save tables to a worksheet in using xml writer
	 *
	 * @return string - export filename
	 */
	private function saveToXml() {
		$rowTitle = 1;
		$rowContent = 2;
		$columnIndex = 1;
		
		// XML-Object
		$xml = new LegosXmlWriter ();
		
		// Name Worksheet
		$xml->setWorksheetName ( "Mission $this->missionId" );
		
		// Write data
		$xml->writeData ( "Mission No", $rowTitle, $columnIndex );
		$xml->writeData ( $this->missionId, $rowContent, $columnIndex ++ );
		
		$xml->writeData ( "Flight Number", $rowTitle, $columnIndex );
		$xml->writeData ( $this->mission_page->FlightNumber, $rowContent, $columnIndex ++ );
		
		$xml->writeData ( "Taxibot Number", $rowTitle, $columnIndex );
		$xml->writeData ( $this->mission_page->TaxibotNumber, $rowContent, $columnIndex ++ );
		
		$pcmStart = '';
		$pcmEnd = '';
		$pcmTotal = '';
		foreach ( $this->mission_page->PcmTimes as $pcmItem ) {
			$pcmStart .= $pcmItem ['start'] . ", ";
			$pcmEnd .= $pcmItem ['end'] . ", ";
			$pcmTotal .= $pcmItem ['total'] . ", ";
		}
		$pcmStart = rtrim ( $pcmStart, ', ' );
		$pcmEnd = rtrim ( $pcmEnd, ', ' );
		$pcmTotal = rtrim ( $pcmTotal, ', ' );
		
		$xml->writeData ( "PCM Start", $rowTitle, $columnIndex );
		$xml->writeData ( $pcmStart, $rowContent, $columnIndex ++ );
		
		$xml->writeData ( "PCM End", $rowTitle, $columnIndex );
		$xml->writeData ( $pcmEnd, $rowContent, $columnIndex ++ );
		
		$xml->writeData ( "PCM TIME", $rowTitle, $columnIndex );
		$xml->writeData ( $pcmTotal, $rowContent, $columnIndex ++ );
		
		$xml->writeData ( "PCM Total Time", $rowTitle, $columnIndex );
		$xml->writeData ( $this->mission_page->PcmTotalTime, $rowContent, $columnIndex ++ );
		
		$xml->writeData ( "DCM Time + loading, unloading", $rowTitle, $columnIndex );
		$xml->writeData ( $this->mission_page->DcmTotalTime, $rowContent, $columnIndex ++ );
		
		$xml->writeData ( "Total Mission Time ", $rowTitle, $columnIndex );
		$xml->writeData ( $this->mission_page->TotalMissionTime, $rowContent, $columnIndex ++ );
		
		$pushbackStart = '';
		$pushbackEnd = '';
		$pushbackTotal = '';
		foreach ( $this->mission_page->PushbackTimes as $pushbackItem ) {
			$pushbackStart .= $pushbackItem ['start'] . ", ";
			$pushbackEnd .= $pushbackItem ['end'] . ", ";
			$pushbackTotal .= $pushbackItem ['total'] . ", ";
		}
		$pushbackStart = rtrim ( $pushbackStart, ', ' );
		$pushbackEnd = rtrim ( $pushbackEnd, ', ' );
		$pushbackTotal = rtrim ( $pushbackTotal, ', ' );
		
		$xml->writeData ( "Pushback Start", $rowTitle, $columnIndex );
		$xml->writeData ( $pushbackStart, $rowContent, $columnIndex ++ );
		
		$xml->writeData ( "Pushback End", $rowTitle, $columnIndex );
		$xml->writeData ( $pushbackEnd, $rowContent, $columnIndex ++ );
		
		$xml->writeData ( "Pushback TIME", $rowTitle, $columnIndex );
		$xml->writeData ( $pushbackTotal, $rowContent, $columnIndex ++ );
		
		$xml->writeData ( "PCM - Left Engine", $rowTitle, $columnIndex );
		$xml->writeData ( $this->mission_page->LeftPcmFuel, $rowContent, $columnIndex ++ );
		
		$xml->writeData ( "PCM - Right Engine", $rowTitle, $columnIndex );
		$xml->writeData ( $this->mission_page->RightPcmFuel, $rowContent, $columnIndex ++ );
		
		$xml->writeData ( "DCM - Left Engine", $rowTitle, $columnIndex );
		$xml->writeData ( $this->mission_page->LeftDcmFuel, $rowContent, $columnIndex ++ );
		
		$xml->writeData ( "DCM - Right Engine", $rowTitle, $columnIndex );
		$xml->writeData ( $this->mission_page->RightDcmFuel, $rowContent, $columnIndex ++ );
		
		$xml->writeData ( "Total Left Engine", $rowTitle, $columnIndex );
		$xml->writeData ( $this->mission_page->LeftDcmFuel + $this->mission_page->LeftPcmFuel, $rowContent, $columnIndex ++ );
		
		$xml->writeData ( "Total Right Engine", $rowTitle, $columnIndex );
		$xml->writeData ( $this->mission_page->RightDcmFuel + $this->mission_page->RightPcmFuel, $rowContent, $columnIndex ++ );
		
		$xml->writeData ( "Mission Both", $rowTitle, $columnIndex );
		$xml->writeData ( $this->mission_page->LeftDcmFuel + $this->mission_page->LeftPcmFuel + $this->mission_page->RightDcmFuel + $this->mission_page->RightPcmFuel, $rowContent, $columnIndex ++ );
		
		$xml->writeData ( "Pushback - Left Engine", $rowTitle, $columnIndex );
		$xml->writeData ( $this->mission_page->LeftPushbackFuel, $rowContent, $columnIndex ++ );
		
		$xml->writeData ( "Pushback - Right Engine", $rowTitle, $columnIndex );
		$xml->writeData ( $this->mission_page->RightPushbackFuel, $rowContent, $columnIndex ++ );
		
		$xml->writeData ( "Total Pushback Both", $rowTitle, $columnIndex );
		$xml->writeData ( $this->mission_page->RightPushbackFuel + $this->mission_page->LeftPushbackFuel, $rowContent, $columnIndex ++ );
		
		$xml->writeData ( "Blf Name", $rowTitle, $columnIndex );
		$xml->writeData ( $this->mission_page->BlfName, $rowContent, $columnIndex );
		
		$exportFilename = "Export_Mission_$this->missionId " . date ( 'Y-m-d h:i:s' ) . '.xls';
		
		file_put_contents ( sfConfig::get ( 'app_export_path' ) . "/" . $exportFilename, $xml->getFile () );
		
		return $exportFilename;
	}
	
	/**
	 * Executes show action - show imported file's content
	 *
	 * @param sfWebRequest $request
	 *        	A request object
	 */
	public function executeShow(sfWebRequest $request) {
		$this->route = $this->getController ()->genUrl ( 'mission/show' );
		require_once sfConfig::get ( 'app_lib_helper' ) . "/TimeHelper.php";
		
		$missionId = $request->getParameter ( "missionid" );
		
		if ($missionId != null) {
			$criteria = new Criteria ();
			$criteria->add ( TaxibotMissionPeer::ID, $missionId, Criteria::EQUAL );
			$mission = TaxibotMissionPeer::doSelectOne ( $criteria );
			$this->Selected_flight_number = $mission->getFlightNumber ();
		} else {
			
			$from_date = date ( 'Y-m-d', $request->getParameter ( 'auswahl[bis]' ) );
			// echo " ".$request->getParameter ( 'auswahl[bis]' );//DEBUG
			
			$this->Selected_flight_number = $request->getParameter ( 'auswahl[FlightNumber]' );
			
			if ($this->Selected_flight_number == '') {
				$this->Selected_flight_number = - 1;
			}
			
			$startTimeInterval = new DateTime ( $from_date . " 00:00:00 +00" );
			$endTimeInterval = new DateTime ( $from_date . " 23:59:59 +00" );
			
			/*
			 * print "<pre>"; print_r($startTimeInterval); print "</pre>"; print "<pre>"; print_r($endTimeInterval); print "</pre>";
			 */
			
			$criteria = new Criteria ();
			$criteria->add ( TaxibotMissionPeer::START_TIME, $startTimeInterval, Criteria::GREATER_THAN );
			$criteria->add ( TaxibotMissionPeer::START_TIME, $endTimeInterval, Criteria::LESS_THAN );
			$criteria->add ( TaxibotMissionPeer::FLIGHT_NUMBER, $this->Selected_flight_number, Criteria::EQUAL );
			
			$mission = TaxibotMissionPeer::doSelectOne ( $criteria );
		}
		
		if ($mission == null) {
			$this->missionId = - 1;
			return;
		} else {
			$this->missionId = $mission->getId();
			$this->mission_page = new MissionPageViewModel ( $mission );
			// $this->forward404Unless($this->missionPage);
		}
		
		$this->exportFilename = $this->saveToXml ();
		//dd($this->mission_page);

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
