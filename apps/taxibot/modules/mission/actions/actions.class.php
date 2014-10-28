<?php

/**
 * mission actions.
 *
 * @package    legos2
 * @subpackage mission
 * @author     Moshe Beutel
 */
class missionActions extends sfActions {
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
	 * @return string - export filename
	 */
	private function saveToXml(){
	
		//XML-Object
		$xml = new LegosXmlWriter();	
	
		// Name Worksheet
		$xml->setWorksheetName( "Mission $this->missionId" );
	
		// Write data
		$xml->writeData ( "Mission No. $this->missionId", 1, 1 );
		
		$xml->writeData ( "DCM TIME + unloading, loading", 2, 1 );
		$xml->writeData ( $this->dcmTime, 2, 2 );
		
		$xml->writeData ( "PCM Start", 3, 1 );
		$xml->writeData ( $this->pcmStart, 3, 2 );
		
		$xml->writeData ( "PCM End", 4, 1 );
		$xml->writeData ( $this->pcmEnd, 4, 2 );
		
		$xml->writeData ( "PCM TIME", 5, 1 );
		$xml->writeData ( $this->pcmTime, 5, 2 );
		
		$xml->writeData ( "Total Mission Time ", 6, 1 );
		$xml->writeData ( $this->totalTime, 6, 2 );
		
		$xml->writeData ( "Pushback Start", 7, 1 );
		$xml->writeData ( $this->pushbackStart, 7, 2 );
		
		$xml->writeData ( "Pushback End", 8, 1 );
		$xml->writeData ( $this->pushbackEnd, 8, 2 );
		
		$xml->writeData ( "Pushback TIME", 9, 1 );
		$xml->writeData ( $this->pushbackTime, 9, 2 );
	
		$exportFilename = "Export_Mission_$this->missionId " . date ( 'Y-m-d h:i:s' ) . '.xls';
	
		file_put_contents( sfConfig::get( 'app_export_path' ). "/". $exportFilename, $xml->getFile());
	
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
		require_once sfConfig::get( 'app_lib_helper' ). "/TimeHelper.php";
		
		$missionId = $request->getParameter("missionid");
		
		if($missionId != null){
			$criteria = new Criteria ();				
			$criteria->add ( TaxibotMissionPeer::ID, $missionId, Criteria::EQUAL );
			$this->mission = TaxibotMissionPeer::doSelectOne ( $criteria );
			$this->Selected_flight_number = $this->mission->getFlightNumber();
		}
		else {
			
			$this->from_str = date ('Y-m-d',$request->getParameter ( 'auswahl[bis]' ) );
			//echo " ".$this->from;//DEBUG
			
			$this->Selected_flight_number = $request->getParameter ( 'auswahl[FlightNumber]' ); 
			
			if($this->Selected_flight_number ==''){
				$this->Selected_flight_number = -1;
			}
		
			$startTimeInterval = new DateTime ( $this->from_str . " 00:00:00 +00" );
			$endTimeInterval = new DateTime ( $this->from_str . " 23:59:59 +00" );
			
			/* 	print "<pre>";
				print_r($startTimeInterval);
				print "</pre>";	
				
				print "<pre>";
				print_r($endTimeInterval);
				print "</pre>"; */ 
			
			$criteria = new Criteria ();			
			$criteria->add ( TaxibotMissionPeer::START_TIME, $startTimeInterval, Criteria::GREATER_THAN );
			$criteria->add ( TaxibotMissionPeer::START_TIME, $endTimeInterval, Criteria::LESS_THAN );
		 	$criteria->add ( TaxibotMissionPeer::FLIGHT_NUMBER, $this->Selected_flight_number, Criteria::EQUAL );
			
			$this->mission = TaxibotMissionPeer::doSelectOne ( $criteria );			
		}
			
		if ($this->mission == null) {
			$this->missionId = -1;
			$this->tractorId = -1;
		}else{	
			$this->startTime =  $this->mission->getStartTime();
			$criteria = new Criteria ();			
			$criteria->add ( TaxibotTractorPeer::TRACTOR_ID, $this->mission->getTractorId(), Criteria::EQUAL );
			$this->tractor = TaxibotTractorPeer::doSelectOne ( $criteria );
			$this->tractorName = $this->tractor->getName();
			$this->missionId = $this->mission->getId();
			$this->dcmStart = $this->mission->getDcmStart();
			$this->dcmEnd = $this->mission->getDcmEnd();	
			$this->pcmStart = $this->mission->getPcmStart();
			$this->pcmEnd = $this->mission->getPcmEnd();
			$this->pushbackStart = $this->mission->getPushbackStart();
			$this->pushbackEnd = $this->mission->getPushbackEnd();
			$this->blfName = $this->mission->getBlfName()  == null ? "no blf file": $this->mission->getBlfName();
			
			$pcmStart = new DateTime($this->pcmStart);
			$pcmEnd = new DateTime( $this->pcmEnd);
			$dcmStart = new DateTime($this->dcmStart);
			$dcmEnd = new DateTime( $this->dcmEnd);
			$pushbackStart = new DateTime($this->pushbackStart);
			$pushbackEnd = new DateTime($this->pushbackEnd);	
			$pushbackTime = $pushbackEnd->diff($pushbackStart);
			
			$pcmTime = $pcmEnd->diff($pcmStart);
			$dcmTime1 = $pcmStart->diff($dcmStart);
			$dcmTime1Sec = DateIntervalToSec($dcmTime1);
			$dcmTime2 = $dcmEnd->diff($pcmEnd);
			$dcmTime2Sec = DateIntervalToSec($dcmTime2);
			$totalDcmSec = $dcmTime1Sec + $dcmTime2Sec;
			$totalPcmSec = DateIntervalToSec($pcmTime);
			$totalTimeSec = $totalDcmSec + $totalPcmSec;
			$totalTime = $dcmEnd->diff($dcmStart);
			//$dcmTime = SecToDateInterval($dcmTime1Sec + $dcmTime2Sec);
			$dcmTime = $dcmEnd->diff($dcmStart);
			
			$this->pcmTime = $pcmTime->format("%H:%I:%S");
			$this->dcmTime = $dcmTime->format("%H:%I:%S");
		
			$this->pushbackTime = $pushbackTime->format("%H:%I:%S");
			$this->totalTime =  $totalTime->format("%H:%I:%S");			
			
			$this->fuelLeftDcm = $this->mission->getLeftEngineFuelDcm();
			$this->fuelRightDcm = $this->mission->getRightEngineFuelDcm();
			$this->fuelLeftPcm = $this->mission->getLeftEngineFuelPcm();
			$this->fuelRightPcm = $this->mission->getRightEngineFuelPcm();
			$this->fuelLeftTotal = $this->fuelLeftDcm + $this->fuelLeftPcm;
			$this->fuelRightTotal = $this->fuelRightDcm + $this->fuelRightPcm;;
			$this->fuelMissionBoth = $this->fuelLeftTotal + $this->fuelRightTotal;
			
			$this->fuelLeftPushback = $this->mission->getLeftEngineFuelPushback();
			$this->fuelRightPushback = $this->mission->getRightEngineFuelPushback();
			$this->fuelBothPushback = $this->mission->getLeftEngineFuelPushback() + $this->mission->getRightEngineFuelPushback();		
		}	
		
		$this->exportFilename =  $this->saveToXml();
	
	}

	/**
	 * Controller for the Export action
	 * @param sfWebRequest $request
	 * @return sfView::NONE - Don't return any layout or template
	 */
	public function executeExport(sfWebRequest $request) {
	
		$this->setLayout(false);
			
		//Data
		$filename = $request->getParameter('file');
	
	
		// Set content type to XLS although it is an xml-file
		$this->getResponse ()->setContentType ( 'application/msexcel' );
		$this->getResponse ()->setHttpHeader ( 'Content-Disposition', sprintf ( 'attachment; filename="%s"', $filename ) );
		$this->getResponse ()->sendHttpHeaders ();
		$this->getResponse ()->setContent ( file_get_contents(sfConfig::get( 'app_export_path' ). "/". $filename));
	
		// Don't return any layout or template
		return sfView::NONE;
	}

}
