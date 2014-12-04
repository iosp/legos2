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
	private function saveToXml($times) {
		// XML-Object
		$xml = new LegosXmlWriter ();
		
		// Create styles
		$xml->createStyle ( 'headings', 'Font', 'ss:Bold', '1' );
		
		// Name Worksheet
		$xml->setWorksheetName ( 'Operating Hours' );
		
		// Define headings
		$headings = array (
				'Taxibot Number',
				'Operating Hours',
				'PCM Hours',
				'DCM Hours',
				'Maint-Tow Hours' 
		);
		
		// Write first row of excel-document (ueberschrift = heading)
		for($i = 0; $i < count ( $headings ); $i ++) {
			$xml->writeData ( $headings [$i], 1, $i + 1, '', '', 'headings', 'String' );
		}
		$i = 2;
		
		// Write data
		foreach ( $times as $id => $t ) {
			$xml->writeData ( $id, $i, 1 );
			$xml->writeData ( $t ['total'] , $i, 2 );
			$xml->writeData ( $t ['pcm'] , $i, 3 );
			$xml->writeData ( $t ['dcm'] , $i, 4 );
			$xml->writeData ( $t ['maint'], $i, 5 );
			$i ++;
		}
		
		$filenameOperatingHours = 'Export_Operating_Hours ' . date ( 'Y-m-d h:i:s' ) . '.xls';
		
		file_put_contents ( sfConfig::get ( 'app_export_path' ) . "/" . $filenameOperatingHours, $xml->getFile () );
		
		unset ( $xml );
		unset ( $headings );
		
		// XML-Object
		$xml = new LegosXmlWriter ();
		
		// Create styles
		$xml->createStyle ( 'headings', 'Font', 'ss:Bold', '1' );
		
		// Name Worksheet
		$xml->setWorksheetName ( 'Engines Operating Hours' );
		
		// Define headings
		$headings = array (
				'Taxibot Number',
				'Left Engine Total Hours',
				'Right Engine Total Hours' 
		);
		
		// Write first row of excel-document (ueberschrift = heading)
		for($i = 0; $i < count ( $headings ); $i ++) {
			$xml->writeData ( $headings [$i], 1, $i + 1, '', '', 'headings', 'String' );
		}
		$i = 2;
		
		// Write data
		foreach ( $times as $id => $t ) {
			$xml->writeData ( $id, $i, 1 );
			$xml->writeData ( $t ['Left Hours'], $i, 2 );
			$xml->writeData ( $t ['Right Hours'], $i, 3 );
			$i ++;
		}
		
		$filenameEngines = 'Export_Engines_Operating_Hours ' . date ( 'Y-m-d h:i:s' ) . '.xls';
		
		file_put_contents ( sfConfig::get ( 'app_export_path' ) . "/" . $filenameEngines, $xml->getFile () );
		
		return array (
				$filenameOperatingHours,
				$filenameEngines 
		);
	}
	
	/**
	 * Executes show action - show imported file's content
	 *
	 * @param sfWebRequest $request
	 *        	A request object
	 */
	public function executeShow(sfWebRequest $request) {
		$this->route = $this->getController ()->genUrl ( 'operating_hours/show' );
		require_once sfConfig::get ( 'app_lib_helper' ) . "/TimeHelper.php";
		
		// get the 'from' date of time interval string format
		$this->from_str = $request->getParameter ( 'auswahl[tag_von]' );
		// echo " ".$this->from_str;//DEBUG
		
		// get the 'to' date of time interval string format
		$this->to_str = $request->getParameter ( 'auswahl[tag_bis]' );
		// echo " ".$this->to_str;//DEBUG
		
		// get the 'from' date of time interval
		$this->from = date ( "Y-m-d", $request->getParameter ( 'auswahl[von]' ) );
		// echo " ".$this->from;//DEBUG
		
		// get the 'to' date of time interval
		$this->to = date ( "Y-m-d", $request->getParameter ( 'auswahl[bis]' ) );
		// echo " ".$this->to;//DEBUG
		
		$startTimeInterval = new DateTime ( $this->from . " 00:00:00 +00" );
		$endTimeIntarval = new DateTime ( $this->to . " 23:59:59 +00" );
		
		// die();//DEBUG
		
		$criteria = new Criteria ();
		$criteria->add ( TaxibotMissionPeer::START_TIME, $startTimeInterval, Criteria::GREATER_EQUAL );
		$criteria->addAnd ( TaxibotMissionPeer::END_TIME, $endTimeIntarval, Criteria::LESS_EQUAL );
		$this->missions = TaxibotMissionPeer::doSelect ( $criteria );
		
		$this->tractors = array ();
		foreach ( $this->missions as $mission ) {
			$id = $mission->getTractorId ();
			$tractorName = TaxibotTractorPeer::GetTractorName ( $id );
			
			$loadingTotalTime = TaxibotPartsMissionPeer::GetPartMissionSeconds ( PART_MISSION::LOADING, $mission->getTaxibotPartsMissions () );
			$unloadingTotalTime = TaxibotPartsMissionPeer::GetPartMissionSeconds ( PART_MISSION::UNLOADING, $mission->getTaxibotPartsMissions () );
			$missionStartDate = new DateTime($mission->getStartTime());
			$missionEndDate = new DateTime($mission->getEndTime());
			$totalTime = $missionEndDate->getTimestamp() - $missionStartDate->getTimestamp();
			
			if ($mission->getMissionType () == 1) {
				$dcmTotalTime = $loadingTotalTime + $unloadingTotalTime;
				$dcmTotalTime += TaxibotPartsMissionPeer::GetPartMissionSeconds ( PART_MISSION::DCM, $mission->getTaxibotPartsMissions () );				
				$pcmTotalTime = TaxibotPartsMissionPeer::GetPartMissionSeconds ( PART_MISSION::PCM, $mission->getTaxibotPartsMissions () );
				$maintTime = 0;
				
			} else {
				// maintanance mission
				$pcmTotalTime = 0;
				$dcmTotalTime = 0;
				$maintTime = $totalTime;
			}
			
			$leftEngineHours = TaxibotPartsMissionPeer::GetSumHours($mission->getTaxibotPartsMissions (), ENGINE_SIDE::LEFT);
			$rightEngineHours = TaxibotPartsMissionPeer::GetSumHours($mission->getTaxibotPartsMissions (), ENGINE_SIDE::RIGHT);			
			
			if (isset ( $this->tractors [$id] )) {				
				$this->tractors [$id] ["Left Hours"] += $leftEngineHours;
				$this->tractors [$id] ["Right Hours"] += $rightEngineHours;
				$this->tractors [$id] ["maint"] += $maintTime;
				$this->tractors [$id] ["pcm"] += $pcmTotalTime;
				$this->tractors [$id] ["dcm"] += $dcmTotalTime;
				$this->tractors [$id] ["total"] += $totalTime;
			} else {
				$this->tractors [$id] = array (
						"Left Hours" => $leftEngineHours,
						"Right Hours" => $rightEngineHours,
						"maint" => $maintTime,
						"dcm" => $dcmTotalTime,
						"pcm" => $pcmTotalTime,
						"total" => $totalTime,
						"tractorName" => $tractorName 
				);
			}
		}
		/* print '<pre>';
		print_r ( $this->tractors );
		print '</pre>'; */
		//die ();
		
		if (count ( $this->tractors ) == 0) {
			die ( "No tractor found, please refilter tractors." );
		}
		
		$this->tractorTimes = array ();
		foreach ( $this->tractors as $idd => $tractor ) {
			
			$this->tractorTimes [$idd] = array (
					"Left Hours" => $tractor ["Left Hours"],
					"Right Hours" => $tractor ["Right Hours"],
					"maint" => gmdate ( "H:i:s", $tractor ["maint"] ),
					"dcm" =>  gmdate ( "H:i:s", $tractor ["dcm"] ),
					"pcm" =>  gmdate ( "H:i:s", $tractor ["pcm"] ),
					"total" =>  gmdate ( "H:i:s", $tractor ["total"] ),
					"TtractorName" => $tractor ["tractorName"] 
			);
		}
		
		/* print '<pre>';
		print_r ( $this->tractorTimes );
		print '</pre>';
		die (); */
		
		$ExportFilenames = $this->saveToXml ( $this->tractorTimes );
		$this->filenameOperatingHours = $ExportFilenames [0];
		$this->filenameEngines = $ExportFilenames [1];
	}
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
