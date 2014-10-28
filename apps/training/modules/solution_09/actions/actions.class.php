<?php

/**
 * solution_09 actions.
 *
 * @package    legos2
 * @subpackage solution_09
 * @author     Karsten Spiekermann
 * @version    1
 */
class solution_09Actions extends sfActions {
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request
	 *        	A request object
	 */
	public function executeIndex() {
		// Where are the form data sent to?
		$this->route = $this->getController ()->genUrl ( 'solution_09/content' );
		
		// Get all tractors
		$this->tractors = TaxibotTractorPeer::doSelect ( new Criteria () );
	}
	public function executeContent(sfWebRequest $request) {
		// Get the time range
		$from = $request->getParameter ( 'auswahl[von]' );
		$until = $request->getParameter ( 'auswahl[bis]' );
		
		// Get the selected tractors
		$tractors = $request->getParameter ( 'auswahl[fahrzeugFilter]' );
		
		// SQL-Query. The TaxibotActivity-Table only contains tractor IDs, hence we need a Join on the TaxibotTractor-Table.
		$criteria = new Criteria ();
		$criteria->add ( TaxibotActivityPeer::COMPLETED, date ( 'Y-m-d H:i:s', $from ), CRITERIA::GREATER_EQUAL );
		$criteria->addAnd ( TaxibotActivityPeer::COMPLETED, date ( 'Y-m-d H:i:s', $until ), CRITERIA::LESS_EQUAL );
		$criteria->addJoin ( TaxibotTractorPeer::ID, TaxibotActivityPeer::TRACTOR_ID );
		$criteria->add ( TaxibotTractorPeer::NAME, explode ( ',', trim ( $tractors ) ), CRITERIA::IN );
		$criteria->addAscendingOrderByColumn ( TaxibotActivityPeer::ID );
		$this->activities = TaxibotActivityPeer::doSelect ( $criteria );
	}
}
