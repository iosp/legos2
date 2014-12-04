<?php

/**
 * fatigue_history actions.
 *
 * @package    legos2
 * @subpackage fatigue_history
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class fatigue_historyActions extends sfActions {
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request
	 *        	A request object
	 */
	public function executeIndex(sfWebRequest $request) {
		// $this->forward('default', 'module');
		$this->route = $this->getController ()->genUrl ( 'fatigue_history/show' );
	}
	
	public function executeForce(sfWebRequest $request){
		//d(ini_get('memory_limit'));
		ini_set('memory_limit', '512M');
		//d(ini_get('memory_limit'));
		$missionId = $request->getParameter ( 'missionId' );
		
		$c = new Criteria ();
		$c->add(TaxibotMissionPeer::ID, $missionId);
		$mission = TaxibotMissionPeer::doSelectOne($c);
		
		$fatigueHistoryItems = $mission->getTaxibotFatigueHistorys();
		
		$this->items = array ();		
		foreach ( $fatigueHistoryItems as $item ) {
			//dd($item);
			$fatig = array (
					$item->getDate () . "." . $item->getMilisecond (),
					$item->getLongForceKn (),
					$item->getLatForceKn (),
					$item->getVeolcity (),
					$item->getTiller (),
					$item->getBreakEvent () == null ? 0 : 1
			);
				
			array_push ( $this->items, $fatig );
		}
		
		
//		dd(count($this->items));
		$aircaft =  $mission->getAircraft();
		
		$this->longSafe = $aircaft->getAircraftType ()->getLongStaticLimitValue ();
		$this->latSafe = $aircaft->getAircraftType ()->getLatStaticLimitValue ();
		$this->longfatig = $aircaft->getAircraftType ()->getLongFatigueLimitValue ();
	}
	
	/**
	 * Executes show action
	 *
	 * @param sfWebRequest $request        	
	 */
	public function executeShow(sfWebRequest $request) {
		$this->route = $this->getController ()->genUrl ( 'fatigue_history/show' );
		$this->from_str = $request->getParameter ( 'auswahl[tag_von]' );
		$this->to_str = $request->getParameter ( 'auswahl[tag_bis]' );
		$this->from_time = $request->getParameter ( 'from-time-selection' );
		$this->to_time = $request->getParameter ( 'to-time-selection' );
		$selected_tail_number = $request->getParameter ( 'auswahl[TailNumber]' );
		$this->isFilterSuccess = false;
		
		if ($this->from_time == "" || $this->to_time == "" || $selected_tail_number == "") {
			$this->message = "Some filter details missing. please change filter..";
			return;
		}
		
		$fromDateStr = $this->from_str . " $this->from_time:00";
		$toDateStr = $this->to_str . " $this->to_time:59";
		
		$startTimeInterval = new DateTime ( $fromDateStr . " +00" );
		$endTimeInterval = new DateTime ( $toDateStr . " +00" );
		
		$criteria = new Criteria ();
		$criteria->add ( AircraftPeer::TAIL_NUMBER, $selected_tail_number, Criteria::EQUAL );
		$aircaft = AircraftPeer::doSelectOne ( $criteria );
		
		if ($aircaft == null) {
			$this->message = "No find aircraft. please change filter..";
			return;
		}
		
		$this->tailNumber = $aircaft->getTailNumber ();
		
		$this->longSafe = $aircaft->getAircraftType ()->getLongStaticLimitValue ();
		$this->latSafe = $aircaft->getAircraftType ()->getLatStaticLimitValue ();
		$this->longfatig = $aircaft->getAircraftType ()->getLongFatigueLimitValue ();
		
		$criteria = new Criteria();
		$criteria->clearSelectColumns();
		$criteria->addSelectColumn(TaxibotFatigueHistoryPeer::DATE);
		$criteria->addSelectColumn(TaxibotFatigueHistoryPeer::MILISECOND);
		$criteria->addSelectColumn(TaxibotFatigueHistoryPeer::LONG_FORCE_KN);
		$criteria->addSelectColumn(TaxibotFatigueHistoryPeer::LAT_FORCE_KN);
		$criteria->addAnd(TaxibotFatigueHistoryPeer::AIRCRAFT_ID, $aircaft->getId());
		$criteria->addAnd(TaxibotFatigueHistoryPeer::DATE, $startTimeInterval, Criteria::GREATER_THAN);
		$criteria->addAnd(TaxibotFatigueHistoryPeer::DATE, $endTimeInterval, Criteria::LESS_THAN);
		
		$criteria1 = $criteria->getNewCriterion(TaxibotFatigueHistoryPeer::LONG_FORCE_KN, $aircaft->getAircraftType()->getLongFatigueLimitValue(), Criteria::GREATER_THAN);	 
		$criteria2 = $criteria->getNewCriterion(TaxibotFatigueHistoryPeer::LAT_FORCE_KN, $aircaft->getAircraftType()->getLatStaticLimitValue(), Criteria::GREATER_THAN);
		$criteria1->addOr($criteria2);
		
		$criteria->addAnd($criteria1);		
		
		$criteria->addAscendingOrderByColumn(TaxibotFatigueHistoryPeer::DATE);
		
		$resultQuery = TaxibotFatigueHistoryPeer::doSelectStmt($criteria);
		
		//dd($resultQuery);
		
		$results = array();	
		
		while ( $row = $resultQuery->fetch ( PDO::FETCH_BOTH ) ) {		
			
			$results [] = array(
				$row ['DATE'] . ".".$row ['MILISECOND'],
				$row ['LONG_FORCE_KN']*1,
				$row ['LAT_FORCE_KN']*1
			);
		}
		
		
		$this->items = $results;
		
		// dd($this->items);
		
		$this->isFilterSuccess = true;
		//ini_set('memory_limit', '128M');
	}
}
