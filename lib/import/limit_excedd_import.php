<?php
abstract class EXCEED_TYPE {
	const STATIC_LATERAL = "Static Lateral";
	const STATIC_LONGITUDAL = "Static Longitudal";
	const FATIGUE_LONGITUDAL = "Fatigue Longitudal";
}
class LimitExceedImport {
	private $_index = 0;
	private $_forceValidity;
	private $_aircaft;
	private $_row;
	private $_isForceValid = false;
	private $_aircraftType = null;
	private $_items = array ();
	private $_exceedEventFatigueLongitudal = null;
	private $_exceedEventStaticLongitudal = null;
	private $_exceedEventStaticLateral = null;
	private $_currentRowDateTime;
	private $_latitude;
	private $_longitude;
	function __construct(AircraftType $aircaftType) {
		// $this->_aircaft = $aircaft;
		$this->_aircraftType = $aircaftType;
	}
	public function readRowData($record, $currentTime, $latitude, $longitude ) {
		$this->_currentRowDateTime = $currentTime;
		
		$this->_latitude = $latitude;
		$this->_longitude = $longitude;
		
		$forceValidityCand = $record [LoggerFields::NLG_longitudinal_force_validity];
		if ($forceValidityCand != '') {
			$this->_forceValidity = ( boolean ) $forceValidityCand;
		}
		
		if (! isset ( $this->_forceValidity ) || ! $this->_forceValidity)
			return;
			
			// forces
		$nlgLogitudalForceCand = $record [LoggerFields::NLG_longTug_force_kN];
		if ($nlgLogitudalForceCand != '') {
			$nlgLogitudalForce = ( double ) $nlgLogitudalForceCand; // 41
		} else {
			return;
		}
		
		$nlgLateralForceCand = $record [LoggerFields::NLG_lateral_force_kN]; // 42
		if ($nlgLateralForceCand != '') {
			$nlgLateralForce = ( double ) $nlgLateralForceCand;
		} else {
			return;
		}
		
		$this->handleExceedLimit ( $this->isExceedFatigueLongitudal ( $nlgLogitudalForce ), EXCEED_TYPE::FATIGUE_LONGITUDAL, $this->_exceedEventFatigueLongitudal );
		$this->handleExceedLimit ( $this->isExceedStaticLongitudal ( $nlgLogitudalForce ), EXCEED_TYPE::STATIC_LONGITUDAL, $this->_exceedEventStaticLongitudal );
		$this->handleExceedLimit ( $this->isExceedStaticLateral ( $nlgLateralForce ), EXCEED_TYPE::STATIC_LATERAL, $this->_exceedEventStaticLateral );
		
		// TODO save fatigue data after quantisation // yakov??
		
		unset ( $this->_forceValidity );
	}
	private function handleExceedLimit($isExccedLimit, $exceedType, $cerruntExceedEvent) {
		// echo "exccedType = $exccedType <br/>"; //debug
		// $isExccedLimit && $this->currentExceeds
		$fatigueFlag = $this->_row[LoggerFields::Fatigue_flag];
		if ($fatigueFlag == "1" && $isExccedLimit && $cerruntExceedEvent == null) {
			$this->exceedStarted ( $exceedType );
		} else if (! $isExccedLimit && $cerruntExceedEvent != null) {
			// echo "exceedEnded = $exceedType <br/>"; //debug
			$this->exceedEnded ( $cerruntExceedEvent, $exceedType );
		}
	}
	private function GetDateTimeFromCsvFormat($value) {
		$datetime = new DateTime ( $value . "+00" );
		$datetime->setTimeZone ( new DateTimeZone ( 'Europe/Berlin' ) );
		return $datetime;
	}
	private function exceedStarted($exceedType) {
		// echo " start exceedType = $exceedType <br/>";
		$cerruntExceedEvent = new TaxibotExceedEvent ();
		$date = $this->GetDateTimeFromCsvFormat ( $this->_currentRowDateTime );
		$cerruntExceedEvent->setStartTime ( $date );
		$cerruntExceedEvent->setStartMilisecond($date->format('u'));
		$cerruntExceedEvent->setExceedType ( $exceedType );
				
		if ($exceedType == EXCEED_TYPE::FATIGUE_LONGITUDAL) {
			$this->_exceedEventFatigueLongitudal = $cerruntExceedEvent;
		} else if ($exceedType == EXCEED_TYPE::STATIC_LONGITUDAL) {
			$this->_exceedEventStaticLongitudal = $cerruntExceedEvent;
		} else if ($exceedType == EXCEED_TYPE::STATIC_LATERAL) {
			$this->_exceedEventStaticLateral = $cerruntExceedEvent;
		}
		
		/*
		 * if ($exceedType == EXCEED_TYPE::FATIGUE_LONGITUDAL) { ++ $this->_exceedEventFatigueLongitudalNum; //$this->_exceedEventFatigueLongitudals [$this->_exceedEventFatigueLongitudalNum] = $cerruntExceedEvent; } else if ($exceedType == EXCEED_TYPE::STATIC_LATERAL) { ++ $this->_exceedEventStaticLateralNum; //$this->_exceedEventStaticLaterals [$this->_exceedEventStaticLateralNum] = $cerruntExceedEvent; } else if ($exceedType == EXCEED_TYPE::STATIC_LONGITUDAL) { ++ $this->_exceedEventStaticLongitudalNum; //$this->_exceedEventStaticLongitudals [$this->_exceedEventStaticLongitudalNum] = $cerruntExceedEvent; }
		 */
		
		// $test = $cerruntExceedEvent->getExceedType();echo "exceedStarted TEST = $test<br/>"; //DEBUG
	}
	private function exceedEnded($cerruntExceedEvent, $exceedType) {
		// $test = $cerruntExceedEvent->getExceedType();echo "exceedEnded TEST = $test<br/>"; //DEBUG
		$date = $this->GetDateTimeFromCsvFormat ( $this->_currentRowDateTime );
		$cerruntExceedEvent->setEndTime ($date);
		$cerruntExceedEvent->setEndMilisecond($date->format('u'));
		// $this->printArray($cerruntExceedEvent); die();
		// echo "</br>StartTime" . $cerruntExceedEvent->getStartTime() . "</br>"; // debug
		// echo "</br>endTime" . $cerruntExceedEvent->getEndTime() . "</br>"; // debug
		// die();
		
		$d1 = new DateTime ( $cerruntExceedEvent->getStartTime () );
		$d2 = new DateTime ( $cerruntExceedEvent->getEndTime () );
		
		$duration = $d2->diff ( $d1 );
		
		if ($duration != null) {
			// echo " duration = " . $duration->format ( "%h:%i:%s" ). " <br/>";
			$cerruntExceedEvent->setDuration ( $duration->format ( "%H:%I:%S" ) );
		}
				
		$cerruntExceedEvent->setLatitude ( $this->_latitude );
		$cerruntExceedEvent->setLongitude ( $this->_longitude );
		
		// $cerruntExceedEvent->save ();
		
		if ($exceedType == EXCEED_TYPE::FATIGUE_LONGITUDAL) {
			$this->_exceedEventFatigueLongitudal = null;
		} else if ($exceedType == EXCEED_TYPE::STATIC_LONGITUDAL) {
			$this->_exceedEventStaticLongitudal = null;
		} else if ($exceedType == EXCEED_TYPE::STATIC_LATERAL) {
			$this->_exceedEventStaticLateral = null;
		}
		
		array_push ($this->_items, $cerruntExceedEvent);
	}
	private function isExceedStaticLongitudal($nlgLogitudalForceTug) {
		return abs ( $nlgLogitudalForceTug ) > $this->_aircraftType->getLongStaticLimitValue ();
	}
	private function isExceedStaticLateral($nlgLateralForce) {
		return abs ( $nlgLateralForce ) > $this->_aircraftType->getLatStaticLimitValue ();
	}
	private function isExceedFatigueLongitudal($nlgLogitudalForceTug) {
		return abs ( $nlgLogitudalForceTug ) > $this->_aircraftType->getLongFatigueLimitValue ();
	}
	
	public function SaveAllItems($missionId) {
		if (isset ( $this->_exceedEventStaticLateral ))
			$this->exceedEnded ( $this->_exceedEventStaticLateral, EXCEED_TYPE::STATIC_LATERAL );
		if (isset ( $this->_exceedEventStaticLongitudal ))
			$this->exceedEnded ( $this->_exceedEventStaticLongitudal, EXCEED_TYPE::STATIC_LONGITUDAL );
		if (isset ( $this->_exceedEventFatigueLongitudal ))
			$this->exceedEnded ( $this->_exceedEventFatigueLongitudal, EXCEED_TYPE::FATIGUE_LONGITUDAL );
		TaxibotExceedEventPeer::insertMultiple ( $this->_items, $missionId );
	}
}