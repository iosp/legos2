<?php
class solution_05Actions extends sfActions {
	public function executeIndex(sfWebRequest $request) {
		// Simple query by ID
		$criteria = new Criteria ();
		$criteria->add ( TaxibotActivityPeer::TRACTOR_ID, 1 );
		$this->activities = TaxibotActivityPeer::doSelect ( $criteria );
		
		// Advanced query using a JOIN statement
		$criteria = new Criteria ();
		$criteria->addJoin ( TaxibotTractorPeer::ID, TaxibotActivityPeer::TRACTOR_ID );
		$criteria->add ( TaxibotTractorPeer::NAME, "S03" );
		$this->activities_two = TaxibotActivityPeer::doSelect ( $criteria );
		
		// Advanced query using a JOIN and an OR statement
		$criteria = new Criteria ();
		$criteria->addJoin ( TaxibotTractorPeer::ID, TaxibotActivityPeer::TRACTOR_ID );
		$criteria->add ( TaxibotTractorPeer::NAME, "S03" );
		$criteria->addOr ( TaxibotTractorPeer::NAME, "S05" );
		$this->activities_three = TaxibotActivityPeer::doSelect ( $criteria );
		
		// All activities after 12 o'clock (LIMIT 5)
		$criteria = new Criteria ();
		$criteria->add ( TaxibotActivityPeer::DEPARTURE, "2013-02-02 12:00:00", Criteria::GREATER_THAN );
		$criteria->setLimit ( 5 );
		$this->activities_four = TaxibotActivityPeer::doSelect ( $criteria );
	}
}
