<?php

/**
 * mission_list actions.
 *
 * @package    legos2
 * @subpackage mission_list
 * @author     Yakov Luria
 */
class mission_listActions extends sfActions {
	public function executeAllmissions(sfWebRequest $request) {
		$this->TaxibotMissions = TaxibotMissionPeer::doSelect ( new Criteria () );
	}
	public function executeIndex(sfWebRequest $request) {
		$this->from_date = $request->getParameter ( 'auswahl[tag_von]' );
		
		
		if($this->from_date == null){
			$taxibotMissions = TaxibotMissionPeer::doSelect ( new Criteria () );
		}
		else{
			$this->to_date = $request->getParameter ( 'auswahl[tag_bis]' );
			$this->fromTime = $request->getParameter ( 'from-time-selection' );
			$this->toTime = $request->getParameter ( 'to-time-selection' );
			$this->flightNumber = $request->getParameter ( 'auswahl[FlightNumber]' );
			$this->tailNumber = $request->getParameter ( 'auswahl[TailNumber]' );
			$this->taxibotNumber = $request->getParameter ( 'auswahl[TaxibotNumber]' );
			$this->acType = $request->getParameter ( 'ac-type-select' );
			$this->operational = $request->getParameter ( 'operational-select' );
			$this->onlyFatigue = $request->getParameter ( 'only-faitgue-select' ); 
			$this->IsUnapproved = $request->getParameter ( 'unapproved-select' );
			
			if($this->fromTime == ''){
				$this->fromTime = "00:00";
			} 
			if($this->toTime == ''){
				$this->toTime = "23:59";
			}
			
			//dd($this->toTime);
						
			$startTimeInterval = new DateTime ( $this->from_date . " ". $this->fromTime . ":00 +00" );
			$endTimeIntarval = new DateTime( $this->to_date . " ". $this->toTime . ":59 +00" );
			
			$criteria = new Criteria ();			
			$criteria->add ( TaxibotMissionPeer::START_TIME, $startTimeInterval, Criteria::GREATER_EQUAL );
			$criteria->addAnd ( TaxibotMissionPeer::END_TIME, $endTimeIntarval, Criteria::LESS_EQUAL );	
			if( $this->flightNumber != ''){
				$criteria->addAnd(TaxibotMissionPeer::FLIGHT_NUMBER, $this->flightNumber);
			}
			
			if( $this->tailNumber != ''){
				$aircraft = AircraftPeer::getAircraftByTailNumber($this->tailNumber);
				$criteria->addAnd(TaxibotMissionPeer::AIRCRAFT_ID, $aircraft->getId());
			}
			
			if( $this->taxibotNumber != ''){
				$tractor = TaxibotTractorPeer::GetTractorByName($this->taxibotNumber);
				$criteria->addAnd(TaxibotMissionPeer::TRACTOR_ID, $tractor->getId());
			}
						 
			if( $this->acType != ''){
				$criteria->addJoin(TaxibotMissionPeer::AIRCRAFT_ID, AircraftPeer::ID, Criteria::INNER_JOIN);
				$criteria->addJoin(AircraftPeer::TYPE_ID, AircraftTypePeer::ID, Criteria::INNER_JOIN);				 
				$criteria->addAnd(AircraftTypePeer::NAME, $this->acType);
			}
			
			if( $this->operational != '' &&  $this->operational != 0){
				$criteria->addAnd(TaxibotMissionPeer::OPERATIONAL_SCENARIO, $this->operational);
			}
			
			if($this->IsUnapproved != null){
				$criteria->addAnd(TaxibotMissionPeer::IS_COMMITED, 0);				
			}
			
			$missions = TaxibotMissionPeer::doSelect( $criteria );
			
			$taxibotMissions = array();
			
			if( $this->onlyFatigue != null){
				foreach ($missions as $mission){
					if(count($mission->getTaxibotExceedEvents()) > 0){
						$taxibotMissions[] = $mission;
					}
				}
			}
			else{
				$taxibotMissions = $missions;
			}
			
			$this->getRequest()->setParameter('fromdate', $this->from_date);
			$this->getRequest()->setParameter('todate', $this->to_date);
			$this->getRequest()->setParameter('fromTime', $this->fromTime);
			$this->getRequest()->setParameter('toTime', $this->toTime);
			$this->getRequest()->setParameter('flightNumber', $this->flightNumber);
			$this->getRequest()->setParameter('tailNumber', $this->tailNumber);
			$this->getRequest()->setParameter('taxibotNumber', $this->taxibotNumber);
		}
				
		$this->getRequest()->setParameter('missions', $taxibotMissions);
		$this->forward('mission_list', 'missionlist');
	}
	
	public function executeMissionUploaded(sfWebRequest $request){
		$taxibotMissions = TaxibotMissionPeer::GetUncommitedMissions();
		$this->getRequest()->setParameter('missions', $taxibotMissions);
		$this->getRequest()->setParameter('isAfterUploading', true);
		$this->forward('mission_list', 'missionlist');		
	}
	
	public function executeMissionlist(sfWebRequest $request){		 
		$taxibotMissions = $request->getParameter("missions");
		$this->from_date = $request->getParameter("fromdate");
		$this->to_date = $request->getParameter("todate");
		$this->fromTime = $request->getParameter("fromTime");
		$this->toTime = $request->getParameter("toTime");
		
		$this->missions = array();
		foreach ($taxibotMissions as $taxibotMission) {
			 //$taxibotMission = new TaxibotMission();
			
			//dd($taxibotMission);
			$missionType = '';
			if($taxibotMission->getMissionType() == "1"){
				$missionType = "Regular Mission";
			}
			else if($taxibotMission->getMissionType() == "2"){
				$missionType = "Maintenance Tow";
			}
			$this->missions[] =	array(
				"operationalType" => $taxibotMission->getOperationalScenario(),
				'flightNumber' => $taxibotMission->getFlightNumber(),
				'startDateTime' => $taxibotMission->getStartTime(),
				'taxibotNumber' => $taxibotMission->getTaxibotTractor()->getName(),
				'tailNumber' => $taxibotMission->getAircraft()->getTailNumber(),
				'missionType' => $missionType,
				'isApproved'=> 	$taxibotMission->getIsCommited() ? "1": "0",
				'id'=> $taxibotMission->getId());
		}
		
		$this->route = $this->getController ()->genUrl ( 'mission_list/index' ). "/index";				
		$this->group = $this->getUser()->getUserGroup();
		$this->isafterUploading = $request->getParameter("isAfterUploading");
	}
	
	public function executeShowbyid(sfWebRequest $request) {
		$this->TaxibotMission = TaxibotMissionPeer::retrieveByPk ( $request->getParameter ( 'id' ) );
		$this->forward404Unless ( $this->TaxibotMission );
	}
	public function executeNew(sfWebRequest $request) {
		$this->form = new TaxibotMissionForm ();
	}
	public function executeCreate(sfWebRequest $request) {
		$this->forward404Unless ( $request->isMethod ( sfRequest::POST ) );
		
		$this->form = new TaxibotMissionForm ();
		
		$this->processForm ( $request, $this->form );
		
		$this->setTemplate ( 'new' );
	}
	public function executeEdit(sfWebRequest $request) {
		$this->forward404Unless ( $TaxibotMission = TaxibotMissionPeer::retrieveByPk ( $request->getParameter ( 'id' ) ), sprintf ( 'Object TaxibotMission does not exist (%s).', $request->getParameter ( 'id' ) ) );
		$this->form = new TaxibotMissionForm ( $TaxibotMission );
	}
	public function executeUpdate(sfWebRequest $request) {
		$this->forward404Unless ( $request->isMethod ( sfRequest::POST ) || $request->isMethod ( sfRequest::PUT ) );
		$this->forward404Unless ( $TaxibotMission = TaxibotMissionPeer::retrieveByPk ( $request->getParameter ( 'id' ) ), sprintf ( 'Object TaxibotMission does not exist (%s).', $request->getParameter ( 'id' ) ) );
		$this->form = new TaxibotMissionForm ( $TaxibotMission );
		
		$this->processForm ( $request, $this->form );
		
		$this->setTemplate ( 'edit' );	}
	public function executeSaveproperty(sfWebRequest $request){
		if ($request->isMethod('post')) {
			$data = $request->getPostParameter("data");
		
			$handle = fopen (sfConfig::get ( 'app_import_debug' ), 'a' );
			if ($handle) {			
				fwrite ( $handle, "[" . date ( 'Y-m-d H:i:s' ) . "] " .  print_r($data, true) . "\n\r" );
				fclose ( $handle );
			}	
			
			$mission = TaxibotMissionPeer::retrieveByPk ( $data[missionId] );
			
			switch ($data["propertyName"]) {
			    case ("flightNumber"):
			       	$mission->setFlightNumber($data["value"]);
			        break;
			    case ("operationalType"):
			       	$mission->setOperationalScenario($data["value"]);
			        break;
			    case ("startDate"):
			       	$mission->setStartTime($data["value"]);
			        break;
			}
				
			$mission->save();
		}
		
		return $this->renderText(json_encode(array(
				'data' => true
		)));
	}
	public function executeConfirm(sfWebRequest $request){
		$status = false;
		if ($request->isMethod('post')) {			
			$missionsId = $request->getPostParameter("missionsIsd");
			if(count($missionsId) > 0){				
				TaxibotMissionPeer::CommitMissions($missionsId);
				$status = true;
			}
		}
		
		return $this->renderText(json_encode(
			$status
		));
	}
	public function executeMerge(sfWebRequest $request){
		$status = false;
		if ($request->isMethod('post')) {			
			$data = $request->getPostParameter("missionsIsd");			
			if(count($data) > 1){
				TaxibotMissionPeer::MergeMissions($data);				
				$status = true;
			}
		}
		
		return $this->renderText(json_encode(
			$status
		));
	}
	public function executeDelete(sfWebRequest $request) {
		$this->forward404Unless ( $TaxibotMission = TaxibotMissionPeer::retrieveByPk ( $request->getParameter ( 'id' ) ), sprintf ( 'Object TaxibotMission does not exist (%s).', $request->getParameter ( 'id' ) ) );		
		
		TaxibotTrailPeer::deleteTrailsByMissionId($TaxibotMission->getId());
		TaxibotExceedEventPeer::deleteByMissionId($TaxibotMission->getId());
		TaxibotPartsMissionPeer::deleteByMissionId($TaxibotMission->getId());
		TaxibotFatigueHistoryPeer::deleteByMissionId($TaxibotMission->getId());
		
		$TaxibotMission->delete ();
		
		return $this->renderText(json_encode(array(
				'data' => true
		)));
	}
	protected function processForm(sfWebRequest $request, sfForm $form) {
		$form->bind ( $request->getParameter ( $form->getName () ), $request->getFiles ( $form->getName () ) );
		if ($form->isValid ()) {
			$TaxibotMission = $form->save ();
			
			$this->redirect ( 'mission_list/edit?id=' . $TaxibotMission->getId () );
		}
	}
}
