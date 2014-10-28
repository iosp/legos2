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
		// get the 'from' date of time interval string format
		$this->from_date = $request->getParameter ( 'auswahl[tag_von]' );
		//echo " from_date".$this->from_date;//DEBUG
		
		// get the 'to' date of time interval string format
		$this->to_date = $request->getParameter ( 'auswahl[tag_bis]' );
		//echo "to_date ".$this->to_date;//DEBUG
		
		if($this->from_date == null){
			$taxibotMissions = TaxibotMissionPeer::doSelect ( new Criteria () );
		}
		else{
			
			$startTimeInterval = new DateTime ( $this->from_date . " 00:00:00 +00" );
			$endTimeIntarval = new DateTime( $this->to_date . " 23:59:59 +00" );			
			$criteria = new Criteria ();			
			$criteria->add ( TaxibotMissionPeer::START_TIME, $startTimeInterval, Criteria::GREATER_EQUAL );
			$criteria->addAnd ( TaxibotMissionPeer::END_TIME, $endTimeIntarval, Criteria::LESS_EQUAL );			
			$taxibotMissions = TaxibotMissionPeer::doSelect( $criteria );
		}	

		$this->getRequest()->setParameter('missions', $taxibotMissions);
		$this->getRequest()->setParameter('fromdate', $this->from_date);
		$this->getRequest()->setParameter('todate', $this->to_date);
		$this->forward('mission_list', 'missionlist');
	}
	
	public function executeMissionlist(sfWebRequest $request){
		 
		$taxibotMissions = $request->getParameter("missions");
		$this->from_date = $request->getParameter("fromdate");
		$this->to_date = $request->getParameter("todate");
		
		$this->missions = array();
		foreach ($taxibotMissions as $taxibotMission) {
			array_push($this->missions,
			array("operationalType" => $taxibotMission->getOperationalScenario(),
			'flightNumber' => $taxibotMission->getFlightNumber(),
			'startDateTime' => $taxibotMission->getStartTime(),
			'taxibotNumber' => $taxibotMission->getTaxibotTractor()->getName(),
			'acNumber' => $taxibotMission->getAircraftTailNumber(),
			'missionType' => $taxibotMission->getMissionType(),
			'id'=> $taxibotMission->getId()));
		}
		
		$this->route = $this->getController ()->genUrl ( 'mission_list/index' );
		$this->user = sfContext::getInstance ()->getUser ();
	}
	
	public function executeMissionupload(sfWebRequest $request){
		$lastMission = TaxibotMissionPeer::GetLastMission();
		$taxibotMissions = array ($lastMission);
		
		$this->getRequest()->setParameter('missions', $taxibotMissions);
		$this->forward('mission_list', 'missionlist');
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
	public function executeMarge(sfWebRequest $request){
		$status = false;
		if ($request->isMethod('post')) {
			$data = $request->getPostParameter("missionsIsd");			
			if(count($data) > 1){				
				TaxibotMissionPeer::MargeMissions($data);				
				$status = true;
			}
		}
		
		return $this->renderText(json_encode(array(
				'data' => $status
		)));
	}
	public function executeDelete(sfWebRequest $request) {
		$this->forward404Unless ( $TaxibotMission = TaxibotMissionPeer::retrieveByPk ( $request->getParameter ( 'id' ) ), sprintf ( 'Object TaxibotMission does not exist (%s).', $request->getParameter ( 'id' ) ) );		
			
		TaxibotTrailPeer::deleteTrailsByMissionId($TaxibotMission->getId());
		TaxibotExceedEventPeer::deleteByMissionId($TaxibotMission->getId());
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
