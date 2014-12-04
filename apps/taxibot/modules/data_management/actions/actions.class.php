<?php

/**
 * dataManagement actions.
 *
 * @package    legos2
 * @subpackage dataManagement
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class data_ManagementActions extends sfActions 
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request) {  	
  	$this->airbus = AircraftTypePeer::GetAirbusLimits();  	
  	$this->boeing = AircraftTypePeer::GetBoeingLimits();
  }
  
  public function executeSaveForce(sfWebRequest $request) {
  	$this->forward404Unless ( $request->isMethod ( sfRequest::POST ) || $request->isMethod ( sfRequest::PUT ) );
  	$data = $request->getParameter ( 'data' ); 
  	
  	if(!is_numeric($data['value'])) {
  		return ;
  	}
  	
  	AircraftTypePeer::updateAircraftType($data);
  	
  	return $this->renderText ( json_encode (   $data["aricaftType"] ) );
  }
}
