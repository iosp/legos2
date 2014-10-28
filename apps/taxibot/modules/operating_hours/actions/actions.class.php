<?php

/**
 * operating_hours actions.
 *
 * @package    legos2
 * @subpackage operating_hours
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class operating_hoursActions extends sfActions {
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request
	 *        	A request object
	 */
	public function executeIndex(sfWebRequest $request) {
		// $this->forward('default', 'module');
		$this->our_string = "Operating Hours";
		
		$this->route = $this->getController ()->genUrl ( 'operating_hours/show' );
	}
	

	
	private function saveToXml($times){
		
		//XML-Object
		$xml = new LegosXmlWriter();
		
		// Create styles
		$xml->createStyle( 'headings', 'Font', 'ss:Bold', '1' );
		
		// Name Worksheet
		$xml->setWorksheetName( 'Operating Hours' );
		
		// Define headings
		$headings = array( 'Taxibot Number', 'Operating Hours', 'PCM Hours', 'DCM Hours', 'Maint-Tow Hours');
			
		
		// Write first row of excel-document (ueberschrift = heading)
		for($i = 0; $i < count ( $headings ); $i ++) {
			$xml->writeData ( $headings [$i], 1, $i + 1, '', '', 'headings', 'String' );
		}
		$i = 2;
		
		// Write data
		foreach ( $times as $id => $t ) {
			$xml->writeData ( $id, $i, 1 );
			$xml->writeData ( $t['total']->format("%H:%I:%S"), $i, 2 );
			$xml->writeData ( $t['pcm']->format("%H:%I:%S"), $i, 3 );
			$xml->writeData ( $t['dcm']->format("%H:%I:%S"), $i, 4 );
			$xml->writeData ( $t['maint']->format("%H:%I:%S"), $i, 5 );
			$i ++;
		}
		
		$filenameOperatingHours = 'Export_Operating_Hours ' . date ( 'Y-m-d h:i:s' ) . '.xls';
		
		file_put_contents( sfConfig::get( 'app_export_path' ). "/". $filenameOperatingHours, $xml->getFile());
		
		unset($xml);
		unset($headings);
		
		//XML-Object
		$xml = new LegosXmlWriter();
		
		// Create styles
		$xml->createStyle( 'headings', 'Font', 'ss:Bold', '1' );
		
		// Name Worksheet
		$xml->setWorksheetName( 'Engines Operating Hours' );
		
		// Define headings
		$headings = array( 'Taxibot Number', 'Left Engine Total Hours', 'Right Engine Total Hours');
			
		
		// Write first row of excel-document (ueberschrift = heading)
		for($i = 0; $i < count ( $headings ); $i ++) {
			$xml->writeData ( $headings [$i], 1, $i + 1, '', '', 'headings', 'String' );
		}
		$i = 2;
		
		// Write data
		foreach ( $times as $id => $t ) {
			$xml->writeData ( $id, $i, 1 );
			$xml->writeData ( $t['Left Hours'], $i, 2 );
			$xml->writeData ( $t['Right Hours'], $i, 3 );
			$i ++;
		}
		
		$filenameEngines = 'Export_Engines_Operating_Hours ' . date ( 'Y-m-d h:i:s' ) . '.xls';
		
		file_put_contents( sfConfig::get( 'app_export_path' ). "/". $filenameEngines, $xml->getFile());
		
		return array ( $filenameOperatingHours, $filenameEngines );
		
	}
	
	/**
	 * Executes show action - show imported file's content
	 *
	 * @param sfWebRequest $request
	 *        	A request object
	 */
	public function executeShow(sfWebRequest $request) {
		$this->route = $this->getController ()->genUrl ( 'operating_hours/show' );
		require_once sfConfig::get( 'app_lib_helper' ). "/TimeHelper.php";
		
		// get the 'from' date of time interval string format
		$this->from_str = $request->getParameter ( 'auswahl[tag_von]' );		
		//echo " ".$this->from_str;//DEBUG
		
		// get the 'to' date of time interval string format
		$this->to_str = $request->getParameter ( 'auswahl[tag_bis]' );
		//echo " ".$this->to_str;//DEBUG
		
		// get the 'from' date of time interval
		$this->from = date ( "Y-m-d", $request->getParameter ( 'auswahl[von]' ) );	
		//echo " ".$this->from;//DEBUG
		
		// get the 'to' date of time interval
		$this->to = date ( "Y-m-d", $request->getParameter ( 'auswahl[bis]' ) );		
		//echo " ".$this->to;//DEBUG
		
		$startTimeInterval = new DateTime ( $this->from . " 00:00:00 +00" );		
		$endTimeIntarval = new DateTime( $this->to . " 23:59:59 +00" );
		
		//die();//DEBUG
		
		$criteria = new Criteria ();
		
		$criteria->add ( TaxibotMissionPeer::START_TIME, $startTimeInterval, Criteria::GREATER_EQUAL );
		$criteria->addAnd ( TaxibotMissionPeer::END_TIME, $endTimeIntarval, Criteria::LESS_EQUAL );
				
		$this->missions = TaxibotMissionPeer::doSelect( $criteria );
		
		
		
		$this->tractors = array();
		foreach ($this->missions as  $mission){			
			$id = $mission->getTractorId();
			$tractorName = TaxibotTractorPeer::GetTractorName($id);
						
			$dcmStart = new DateTime($mission->getDcmStart());
			$dcmEnd = new DateTime( $mission->getDcmEnd());
			
			if ($mission->getMissionType() == 1){		
				// regular mission				
				$pcmStart = new DateTime($mission->getPcmStart());
				
				$pcmEnd = new DateTime( $mission->getPcmEnd());
				
				$pcmTime = $pcmEnd->diff($pcmStart);
				$dcmTime1 = $pcmStart->diff($dcmStart);
					
				$dcmTime1Sec = DateIntervalToSec($dcmTime1);
				$dcmTime2 = $dcmEnd->diff($pcmEnd);
				
				$dcmTime2Sec = DateIntervalToSec($dcmTime2);
				$totalDcmSec = $dcmTime1Sec + $dcmTime2Sec;
				$totalPcmSec = DateIntervalToSec($pcmTime);
				$totalTimeSec = $totalDcmSec + $totalPcmSec;
				$maintTime = 0;
				$totalTime = $dcmEnd->diff($dcmStart);	
			}else {
				// maintanance mission

				$totalPcmSec = 0;
				$totalDcmSec = 0;
				$totalTimeSec = $mission->getMaintTime();
				$maintTime = $mission->getMaintTime();
			}
						
			if (isset($this->tractors[$id])) {
				
				$this->tractors[$id]["Left Hours"] += $mission->getLeftEngineHoursPcm() + $mission->getLeftEngineHoursDcm() + $mission->getLeftEngineHoursMaint();
				$this->tractors[$id]["Right Hours"] += $mission->getRightEngineHoursPcm() + $mission->getRightEngineHoursDcm() + $mission->getRightEngineHoursMaint();
				$this->tractors[$id]["maint"] += $maintTime;
				$this->tractors[$id]["pcm"] += $totalPcmSec;
				$this->tractors[$id]["dcm"] += $totalDcmSec;
				$this->tractors[$id]["total"] += $totalTimeSec;
			}
			else{				
				$this->tractors[$id] = array
				(
						"Left Hours" => $mission->getLeftEngineHoursPcm() + $mission->getLeftEngineHoursDcm() + $mission->getLeftEngineHoursMaint(),
						"Right Hours" => $mission->getRightEngineHoursPcm() + $mission->getRightEngineHoursDcm() + $mission->getRightEngineHoursMaint(),
						"maint"=> $maintTime,
						"dcm"=> $totalDcmSec,
						"pcm"=> $totalPcmSec ,
						"total" =>  $totalTimeSec,
						"Tractor Name" => $tractorName
				);								
			}    
		}

		
		if(count($this->tractors) == 0) return;			
		
		$this->tractorTimes = array();
		
		/* print '<pre>';
		print_r($this->tractors);
		print '</pre>';die();
		 */
		
		foreach($this->tractors as $idd => $tractor){
						
			$this->tractorTimes[$idd] = array(
					"Left Hours" =>$tractor["Left Hours"],
					"Right Hours" =>$tractor["Right Hours"],				
					"maint"=> SecToDateInterval($tractor["maint"]),				
					"dcm"=> SecToDateInterval($tractor["dcm"]),			
					"pcm"=> SecToDateInterval($tractor["pcm"]),		
					"total" =>  SecToDateInterval($tractor["total"]),
					"Tractor Name" => $tractor["Tractor Name"]
			);
		}
		
		$ExportFilenames =  $this->saveToXml($this->tractorTimes);
		
		$this->filenameOperatingHours = $ExportFilenames[0];
		$this->filenameEngines = $ExportFilenames[1];
		
	}
	
	
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
