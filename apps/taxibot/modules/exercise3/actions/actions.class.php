<?php

/**
 * exercise3 actions.
 *
 * @package    legos2
 * @subpackage exercise3
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class exercise3Actions extends sfActions {
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request
	 *        	A request object
	 */
	public function executeIndex(sfWebRequest $request) {
		$criteria = new Criteria ();
		// $criteria->add(TaxibotActivityPeer::AC_REGISTRATION, 'DAISE');
		$criteria->add ( TaxibotActivityPeer::TRACTOR_ID, 1 );
		$criteria->addOr ( TaxibotActivityPeer::TRACTOR_ID, 2 );
		
		$this->daise = TaxibotActivityPeer::doSelect ( $criteria );
	}
}
