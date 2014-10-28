<?php

/**
 * fatigue_history actions.
 *
 * @package    legos2
 * @subpackage fatigue_history
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class fatigue_historyActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
   // $this->forward('default', 'module');
  	$this->route = $this->getController ()->genUrl ( 'fatigue_history/show' );
  }
  
  /**
   * Executes show action
   * @param sfWebRequest $request
   */
  public function executeShow(sfWebRequest $request) {
  
  	// get the 'from' date of time interval string format
  	$this->from_str = $request->getParameter ( 'auswahl[tag_von]' );
  
  	// get the 'to' date of time interval string format
  	$this->to_str = $request->getParameter ( 'auswahl[tag_bis]' );
  
  	$failures = array();
  
  	$series_one = array ();
  	$series_two = array ();
  
  	// Create random walk-like numbers
  	$series_one [] = 50;
  	$series_two [] = 100;
  
  	for($i = 1; $i < 1440; $i ++) {
  		$fail = new TaxibotFailure();
  		$fail->setName("fail $i");
  		$fail->setDates("dates $i");
  		$fail->setTaxibotNumber($i%3 + 1);
  		$fail->setFailureFamily("family $i");
  		$fail->setModeOfOperation('pcm');
  		$fail->setMission(1);
  		$failures[$i] = $fail;
  			
  		$series_one [$i] = $series_one [$i - 1] + mt_rand ( - 10, 10 );
  		$series_two [$i] = $series_two [$i - 1] + mt_rand ( - 10, 10 );
  	}
  
  	$this->ser_one_arr = $failures;
  	$this->series_one = json_encode ( $series_one );
  	$this->series_two = json_encode ( $series_two );
  }
  
}
