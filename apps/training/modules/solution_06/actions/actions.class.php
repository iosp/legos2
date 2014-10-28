<?php

/**
 * solution_06 actions.
 *
 * @package    legos2
 * @subpackage solution_06
 * @author     Karsten Spiekermann
 * @version    1
 */
class solution_06Actions extends sfActions {
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request
	 *        	A request object
	 */
	public function executeIndex(sfWebRequest $request) {
		$criteria = new Criteria ();
		$criteria->add ( TaxibotActivityPeer::COMPLETED, '2013-02-02 00:00:00', CRITERIA::GREATER_EQUAL );
		$criteria->addAnd ( TaxibotActivityPeer::COMPLETED, '2013-02-02 23:59:59', CRITERIA::LESS_EQUAL );
		$this->activities = TaxibotActivityPeer::doSelect ( $criteria );
	}
	
	/**
	 * Marks an activity in the TaxibotActivity-table as deleted and generates a copy in the TaxibotActivityDeleted-table.
	 */
	public function executeDelete(sfWebRequest $request) {
		$activity = TaxibotActivityPeer::retrieveByPk ( $request->getParameter ( 'pk' ) );
		$activity->delete ();
		
		$this->redirect ( 'solution_06/index' );
	}
	public function executeRender(sfWebRequest $request) {
		
		// data base request instead !!!!
		echo rand ( $request->getParameter ( 'lower' ), $request->getParameter ( 'upper' ) );
		
		return sfView::NONE;
	}
}
