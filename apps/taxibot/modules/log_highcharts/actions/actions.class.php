<?php

/**
 * log_highcharts actions.
 *
 * @package    legos2
 * @subpackage log_highcharts
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class log_highchartsActions extends sfActions {
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request
	 *        	A request object
	 */
	public function executeIndex(sfWebRequest $request) {
		$activities = TaxibotLogPeer::doSelect ( new Criteria () );
		
		$data = array ();
		foreach ( $activities as $activity ) {
			$data [] = $activity->getLoad ();
		}
		
		$this->data = json_encode ( $data );
	}
}
