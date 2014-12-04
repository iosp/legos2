<?php

/**
 * accumulative_data actions.
 *
 * @package    legos2
 * @subpackage accumulative_data
 * @author     Your name here
 */
class accumulative_dataActions extends sfActions {
	public function executeIndex(sfWebRequest $request) {
		$this->route = $this->getController ()->genUrl ( 'accumulative_data/show' );
	}
	public function executeShow(sfWebRequest $request) {
		$this->route = $this->getController ()->genUrl ( 'accumulative_data/show' );
		
		$this->from_str = $request->getParameter ( 'auswahl[tag_von]' );
		$this->to_str = $request->getParameter ( 'auswahl[tag_bis]' );
		$this->from_time = $request->getParameter ( 'from-time-selection' );
		$this->to_time = $request->getParameter ( 'to-time-selection' );
		$this->selected_taxibot_number = $request->getParameter ( 'auswahl[TaxibotNumber]' );
		
		
		$this->operationChecked = $request->getParameter ( 'operation-select' );
		$this->testChecked = $request->getParameter ( 'test-select' );
		$this->trainChecked = $request->getParameter ( 'train-select' );
		 
 
		if($this->from_time == "" || $this->to_time == "" || $this->selected_taxibot_number == ""){
			$this->redirect ( 'accumulative_data/index' );
		}
		
		$startTimeInterval = new DateTime ( $this->from_str . " $this->from_time:00 +00" );
		$endTimeInterval = new DateTime ( $this->to_str . " $this->to_time:59 +00" );
		
		$this->data = TaxibotMissionPeer::GetAccumulativeData($this->selected_taxibot_number 
				,$startTimeInterval, $endTimeInterval, $this->operationChecked
				,$this->testChecked, $this->trainChecked);	
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
		
		$this->setTemplate ( 'edit' );
	}
	public function executeDelete(sfWebRequest $request) {
		$request->checkCSRFProtection ();
		
		$this->forward404Unless ( $TaxibotMission = TaxibotMissionPeer::retrieveByPk ( $request->getParameter ( 'id' ) ), sprintf ( 'Object TaxibotMission does not exist (%s).', $request->getParameter ( 'id' ) ) );
		$TaxibotMission->delete ();
		
		$this->redirect ( 'accumulative_data/index' );
	}
	protected function processForm(sfWebRequest $request, sfForm $form) {
		$form->bind ( $request->getParameter ( $form->getName () ), $request->getFiles ( $form->getName () ) );
		if ($form->isValid ()) {
			$TaxibotMission = $form->save ();
			
			$this->redirect ( 'accumulative_data/edit?id=' . $TaxibotMission->getId () );
		}
	}
}
