<?php

/**
 * limit_exceed actions.
 *
 * @package    legos2
 * @subpackage limit_exceed
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class limit_exceedActions extends sfActions {
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request
	 *        	A request object
	 */
	public function executeIndex(sfWebRequest $request) {
		$this->route = $this->getController ()->genUrl ( 'limit_exceed/show' );
		// $user = $this->getUser();//->getAttributeHolder("default");
		// var_dump($user);//['attributeHolder'];//['parameters']['benutzer'];
		// var_dump( $user->getAttributeHolder()->getDefaultNamespace() );
		// die;
	}
	public function executeShow(sfWebRequest $request) {
		$this->route = $this->getController ()->genUrl ( 'limit_exceed/show' );
		// query for exceed events for given criteria
		$exists = false;
		
		$this->missions = TaxibotMissionPeer::doSelect ( $this->getCriteria ( $request ) );
		
		$this->missionExceeds = array ();
		
		foreach ( $this->missions as $mission ) { 
			/* $criteria1 = new Criteria ();
			$missionId = $mission->getMissionId ();
			$criteria1->add ( TaxibotExceedEventPeer::MISSION_ID, $missionId ); 
			$exceeds = TaxibotExceedEventPeer::doSelect ( $criteria1 );*/
			
			$exceeds = $mission->getTaxibotExceedEvents();
			
			if ($exceeds != null) {
				$exists = true;
			}
			
			$tractorName = TaxibotTractorPeer::GetTractorName ( $mission->getTractorId () );
			
			$this->missionExceeds [$mission->getId()] = array (				
					"flightnumber" => $mission->getFlightNumber (),
					"tailNumber" => $mission->getAircraft()->getTailNumber(),
					"CG" => $mission->getAircraftCg (),
					"aircraftWeight" => $mission->getAircraftWeight (),
					"exceeds" => $exceeds,
					"tractor" => $tractorName,
					"AcType" => $mission->getAircraft()->getAircraftType()->getName()
			);
		}
		
		$this->our_string == $exists ? "Limit Exceeds " : "There are no limit exceeds for the given criteria.";
		
		$this->exportFilename = $this->saveToXml ();
	}
	public function executeOnline(sfWebRequest $request) {		
		$data = $request->getParameter ( "data" );
		$cs = $request->getParameter ( "cs" );
		
		$handle = fopen (sfConfig::get ( 'app_import_taxibot_logfile' ), 'a' );
		if ($handle) {
		
			fwrite ( $handle, "[" . date ( 'Y-m-d H:i:s' ) . "] data=" . $data . "\n\r" );
			fwrite ( $handle, "[" . date ( 'Y-m-d H:i:s' ) . "] cs=" . $cs . "\n\r" );
			fclose ( $handle );
		}		
		
		if(!$this->checkCancelMessage($data, $cs)){
			$handle = fopen (sfConfig::get ( 'app_import_taxibot_logfile' ), 'a' );
			if ($handle) {
				fwrite ( $handle, "[" . date ( 'Y-m-d H:i:s' ) . "] checkCancelMessage=" . 0 . "\n\r" );
				fclose ( $handle );
			}
			return $this->renderText('0');
		}
		
		$cancel = new TaxibotCancel ();
		$cancel->setAlert ( $data );
		$cancel->setTime ( time () );
		$cancel->save ();

		$handle = fopen (sfConfig::get ( 'app_import_taxibot_logfile' ), 'a' );
		if ($handle) {
			fwrite ( $handle, "[" . date ( 'Y-m-d H:i:s' ) . "] checkCancelMessage=" . 1 . "\n\r" );
			fclose ( $handle );
		}
	 
		return $this->renderText('1');
	}
	
	private function checkCancelMessage($message, $checkSumRequest){
		$checkSumServerSide = $this->string_to_ascii($message);
		
		//HACK TO TEST!!!!!
		/* $r = rand ( 0 ,  100 );		
		if($r == 9){
			return true;
		}
		else{
			return false;
		} */
		//END HACK TO TEST!!!!!
		
		
		if($checkSumServerSide == $checkSumRequest){
			return true;
		}
		return false;
	}
	
	private function string_to_ascii($string)
	{
	    $ascii = NULL;
		$strlen =  strlen($string);
	 
	    for ($i = 0; $i < $strlen; $i++) 
	    { 
	    	$ascii += ord($string[$i]); 
	    }
	 
	    return($ascii);
	}
		
	public function executeAlert(sfWebRequest $request) {
		
		if($this->getUser()->getUserGroup() != USER_GROUP::ADMIN && $this->getUser()->getUserGroup() != USER_GROUP::EDITOR){
			return;
		}
		
		$this->forward404Unless ( $request->isMethod ( sfRequest::POST ) || $request->isMethod ( sfRequest::PUT ) );
		
		$lastId = $request->getParameter ( "lastid" );
		
		$this->lastCancel = TaxibotCancelPeer::GetLastCancel ( );
		
		if($lastId == -1 && $this->lastCancel != null){
			$lastId = $this->lastCancel->getId();
		}
		
		if ($this->lastCancel != null && $this->lastCancel->getId() > $lastId) {
			$data = $this->lastCancel->getAlert();
			$jsonData = json_decode('{' . $data . '}',true);
			echo '{"isError": true,"dataCancel":{';			 
			echo '"date":"'.$jsonData['date'].'"' ; 
			echo ',"time":"'.$jsonData['time'].'"' ;
			echo ',"airline":"'.$jsonData['airline'].'"' ;
			echo ',"ac_type":"'.$jsonData['ac_type'].'"' ;
			echo ',"tail_number":"'.$jsonData['tail_number'].'"' ;
			echo ',"taxibot_id":"'.$jsonData['taxibot_id'].'"' ;
			echo ',"driver_id":"'.$jsonData['driver_id'].'"' ;
			echo ',"position_lat":"'.$jsonData['position_lat'].'"' ;			
			echo ',"position_lon":"'.$jsonData['position_lon'].'"' ;
			echo ',"additional_information":"'.$jsonData['additional_information'].'"' ;
			echo '}, "lastIdMessage": ' . $this->lastCancel->getId().' }';			
		} else {
			echo '{"isError": false, "lastIdMessage": ' . $lastId . '}';
		}
	}
	public function executeLastcancels(sfWebRequest $request) {
		$c = new Criteria();
		$c->addDescendingOrderByColumn(TaxibotCancelPeer::ID);
		$this->cancels = TaxibotCancelPeer::doSelect($c);
		$this->cancels = array_slice($this->cancels, 0, 20);
	}
	
	private function getCriteria(sfWebRequest $request) {
		$criteria = new Criteria ();
		$missionId = $request->getParameter ( 'missionId' );
		
		if ($missionId != null) {
			$criteria->add ( TaxibotMissionPeer::ID, $missionId ); 
		} else {			
			$this->from = date ( "Y-m-d", $request->getParameter ( 'auswahl[von]' ) );
			$this->to = date ( "Y-m-d", $request->getParameter ( 'auswahl[bis]' ) );
			
			$startTimeInterval = strtotime ( $this->from . " 00:00:00" );
			$endTimeIntarval = strtotime ( $this->to . " 23:59:00" );
			
			$criteria->add ( TaxibotMissionPeer::START_TIME, $startTimeInterval, Criteria::GREATER_EQUAL );
			$criteria->addAnd ( TaxibotMissionPeer::END_TIME, $endTimeIntarval, Criteria::LESS_EQUAL );
		}
		
		return $criteria;
	}
	private function saveToXml() {
		
		// XML-Object
		$xml = new LegosXmlWriter ();
		
		// Create styles
		$xml->createStyle ( 'headings', 'Font', 'ss:Bold', '1' );
		
		// Name Worksheet
		$xml->setWorksheetName ( 'Limit Exceeds' );
		
		// Define headings
		$headings = array (
				'Limit',
				'Tail Number',
				'Taxibot Number',
				'Flight Number',
				'AC Type',
				'Start Time',
				'Duration',
				'AC Weight',
				'CG',
				'Position Lon/Lat' 
		);
		
		// Write first row of excel-document (ueberschrift = heading)
		for($i = 0; $i < count ( $headings ); $i ++) {
			$xml->writeData ( $headings [$i], 1, $i + 1, '', '', 'headings', 'String' );
		}
		
		$i = 2;
		
		// Write data
		foreach ( $this->missionExceeds as $missionExceedEvents ) {
			foreach ( $missionExceedEvents ['exceeds'] as $exceed ) {
				
				$j = 0;
				
				$xml->writeData ( $exceed->getExceedType (), $i, ++ $j );
				
				$xml->writeData ( $missionExceedEvents ['tailNumber'], $i, ++ $j );
				
				$xml->writeData ( $missionExceedEvents ['tractor'], $i, ++ $j );
				
				$xml->writeData ( $missionExceedEvents ['flightnumber'], $i, ++ $j );
				
				$xml->writeData ( $missionExceedEvents ['AcType'], $i, ++ $j );
				
				$xml->writeData ( $exceed->getStartTime (), $i, ++ $j );
				
				$xml->writeData ( $exceed->getDuration (), $i, ++ $j );
				
				$xml->writeData ( $missionExceedEvents ['aircraftWeight'], $i, ++ $j );
				
				$xml->writeData ( $missionExceedEvents ['CG'], $i, ++ $j );
				
				$xml->writeData ( $exceed->getLatitude () . " \  " . $exceed->getLongitude (), $i, ++ $j );
				
				++ $i;
			}
		}
		
		$exportFilename = 'Export_Limit_Exceeds ' . date ( 'Y-m-d h:i:s' ) . '.xls';
		
		file_put_contents ( sfConfig::get ( 'app_export_path' ) . "/" . $exportFilename, $xml->getFile () );
		
		return $exportFilename;
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


/* 
http://taxibot.lht-portal.de/taxibot.php/limit_exceed/online/data/%22date%22:%222014-10-14%22,%22time%22:%2207:18%22,%22airline%22:%22LUFTHANSA%22,%22ac_type%22:%22asas%22,%22tail_number%22:%22asdasd%22,%22taxibot_id%22:%22PR80%22,%22driver_id%22:%22asdasdasd%22,%22position_lat%22:%2250.0333%22,%22position_lon%22:%228.57057%22,%22event_type%22:%221%22,%22additional_information%22:%22%22/cs/18564


function string_to_ascii($string)
{
	$ascii = NULL;
	$strlen =  strlen($string);

	for ($i = 0; $i < $strlen; $i++)
	{
	$ascii += ord($string[$i]);
	}

	return($ascii);
}


$data = '"date":"2014-10-14","time":"07:18","airline":"LUFTHANSA","ac_type":"asas","tail_number":"asdasd","taxibot_id":"PR80","driver_id":"asdasdasd","position_lat":"50.0333","position_lon":"8.57057","event_type":"1","additional_information":""';
echo string_to_ascii($data); */
