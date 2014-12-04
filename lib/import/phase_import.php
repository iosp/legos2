<?php
abstract class PART_MISSION {
	const DCM = "DCM";
	const PCM = "PCM";
	const PUSHBACK = "PUSHBACK";
	const LOADING = "LOADING";
	const UNLOADING = "UNLOADING";
	const BREAKING = "BREAKING";
}
class PhaseImport {
	private $__index = 0;
	private $_row;
	public $_currentPartsMission = array (
			PART_MISSION::LOADING => null,
			PART_MISSION::UNLOADING => null,
			PART_MISSION::PUSHBACK => null,
			PART_MISSION::DCM => null,
			PART_MISSION::PCM => null 
	);
	private $_startLeftFuel = array (
			PART_MISSION::LOADING => null,
			PART_MISSION::UNLOADING => null,
			PART_MISSION::PUSHBACK => null,
			PART_MISSION::DCM => null,
			PART_MISSION::PCM => null 
	);
	private $_startRightFuel = array (
			PART_MISSION::LOADING => null,
			PART_MISSION::UNLOADING => null,
			PART_MISSION::PUSHBACK => null,
			PART_MISSION::DCM => null,
			PART_MISSION::PCM => null 
	);
	private $_startLeftHours = array (
			PART_MISSION::LOADING => null,
			PART_MISSION::UNLOADING => null,
			PART_MISSION::PUSHBACK => null,
			PART_MISSION::DCM => null,
			PART_MISSION::PCM => null 
	);
	private $_startRightHours = array (
			PART_MISSION::LOADING => null,
			PART_MISSION::UNLOADING => null,
			PART_MISSION::PUSHBACK => null,
			PART_MISSION::DCM => null,
			PART_MISSION::PCM => null 
	);
	private $_isMaintance = false;
	private $_lastLoadingStep;
	private $_lastDrivingMode;
	private $_isLoadingEnd = false;	
	private $_isLocVelValidity = false;
	private $_lastStopEvent = false;	
	private $_hoursEngineRight;
	private $_hoursEngineLeft;
	private $_currentDate;
	public $veolcity;
	public $items = array ();
	public $lastFuelEngineLeft;
	public $lastFuelEngineRight;
	public $firstFuelEngineLeft;
	public $firstFuelEngineRight;
	function __construct() {
	}
	public function readRow($record, $currentDate) {
		$this->_row = $record;
		$this->_currentDate = $currentDate;
		
		$this->calcVeolcity();		
		$this->examineFuelUsage ();
		$this->examineEngineHours ();
		
		$this->checkLoadingStep ();
		
		if (! $this->_isMaintance) {
			$this->checkDrivingMode ();
			$this->checkStopEvent ();
			
			if ($record [LoggerFields::Mission_Type] == '2') {
				$this->_isMaintance = true;
			}
		}
	}
	private function startPartMission($type) {
		$part = new TaxibotPartsMission ();
		$part->setType ( $type );
		$part->setStart ( $this->GetDateTimeByCurrentDate () );
		$this->_currentPartsMission [$type] = $part;
		$this->_startLeftFuel [$type] = $this->lastFuelEngineLeft;
		$this->_startRightFuel [$type] = $this->lastFuelEngineRight;
		$this->_startLeftHours [$type] = $this->_hoursEngineLeft;
		$this->_startRightHours [$type] = $this->_hoursEngineRight;
	}
	private function printTest() {
	}
	private function endPartMission($type) {
		
		/* if($type == PART_MISSION::LOADING){
			dd($this->_currentPartsMission);
		} */
		
		$part = new TaxibotPartsMission ();
		
		if ($this->_currentPartsMission [$type] != null) {
			$startTime = $this->_currentPartsMission [$type]->getStart ();
			$part->setStart (   $startTime  );
		}
		
		$part->setType ( $type );
		
		/*
		 * print "<pre>"; print_r ( $this->lastlastFuelEngineLeft ); print "</pre>"; print "<pre>"; print_r ( $this->_startLeftFuel [$type] ); print "</pre>"; print "<pre>"; print_r ( $this->lastlastFuelEngineLeft - $this->_startLeftFuel [$type] ); print "</pre>"; die();
		 */
		
		if (PART_MISSION::PUSHBACK == $type) {
			$part->setEnd ( $this->_lastStopEvent );
		} else {
			$part->setEnd ( $this->GetDateTimeByCurrentDate () );
		}
		$part->setLeftEngineFuel ( $this->lastFuelEngineLeft - $this->_startLeftFuel [$type] );
		$part->setRightEngineFuel ( $this->lastFuelEngineRight - $this->_startRightFuel [$type] );
		$part->setLeftEngineHours ( $this->_hoursEngineLeft - $this->_startLeftHours [$type] );
		$part->setRightEngineHours ( $this->_hoursEngineRight - $this->_startRightHours [$type] );
		
		array_push ( $this->items, $part );
		$this->_currentPartsMission [$type] = null;
	}
	private function checkDrivingMode() {
		$drivingMode = $this->_row [LoggerFields::Driving_mode];
		if ($drivingMode == '')
			return;
		
		$drivingMode = ( integer ) $drivingMode;
		
		if ($drivingMode == 9 || $drivingMode == 10 || $drivingMode == 11) {
			if ($this->_lastDrivingMode != 9 && $this->_lastDrivingMode != 10 && $this->_lastDrivingMode != 11) {
				// pcm start
				$this->startPartMission ( PART_MISSION::PCM );
			}
		} else {
			if ($this->_lastDrivingMode == 9 || $this->_lastDrivingMode == 10 || $this->_lastDrivingMode == 11) {
				// pcm end
				$this->endPartMission ( PART_MISSION::PCM );
			}
		}
		
		if ($drivingMode == 4 || $drivingMode == 6) {
			if ($this->_lastDrivingMode != 4 && $this->_lastDrivingMode != 6) {
				// dcm start
				$this->startPartMission ( PART_MISSION::DCM ); 
			}
			
			if ($this->isInMoment () && $this->_currentPartsMission [PART_MISSION::PUSHBACK] == null) {
				 
				// pushback start
				$this->startPartMission ( PART_MISSION::PUSHBACK );
			}
		} else {
			if ($this->_lastDrivingMode == 4 || $this->_lastDrivingMode == 6) {
				// dcm end
				$this->endPartMission ( PART_MISSION::DCM );
				
				if ($this->_currentPartsMission [PART_MISSION::PUSHBACK] != null) {
					// pushback end
					$this->endPartMission ( PART_MISSION::PUSHBACK );
				}
			}
		}
		
		$this->_lastDrivingMode = $drivingMode;
	}
	private function checkStopEvent() {
		if ($this->_isLocVelValidity && $this->veolcity < 0.1) {
			$this->_lastStopEvent = $this->GetDateTimeByCurrentDate ();
		}
	}
	
	private function isInMoment() {
		if ($this->_isLocVelValidity && $this->veolcity > 0.1) {
			return  true;
		}
		
		return false;
	}
	private function calcVeolcity() {
		$isLocVelValidity = $this->_row [LoggerFields::Loc_Vel_Validity];
		$velNorthMps = $this->_row [LoggerFields::Vel_North_mps];
		$velEastMps = $this->_row [LoggerFields::Vel_East_mps];
		$this->__index++;
		
		//echo "<br>". $this->_isLocVelValidity . " ". $this->_lastDrivingMode ." " . $this->veolcity. " ". $this->_currentDate. " ". $velNorthMps. " ". $velNorthMps;
		/* if($this->_lastStopEvent != null){
			 echo " lastStopEvent=". $this->_lastStopEvent->format("Y-m-d H:i:s");
		} */
		
		if ($isLocVelValidity != '') {			 
			$this->_isLocVelValidity = ( bool ) $isLocVelValidity;
		}		
		
		if ($velNorthMps == '' && $velEastMps == '') {
			return;
		}
		
		//echo "<br>". $this->_isLocVelValidity . " ". $this->_lastDrivingMode ." " . $this->veolcity. " " .$this->_currentDate. " ". $velNorthMps. " ". $velNorthMps;
		
		
		$velNorthMpsInt = ( double ) $velNorthMps;
		$velEastMpsInt = ( double ) $velEastMps;
		
		$this->veolcity = sqrt ( pow ( abs ( $velNorthMpsInt ), 2 ) + pow ( abs ( $velEastMpsInt ), 2 ) );  
	}
	private function checkLoadingStep() {
		$loadingStep = $this->_row [LoggerFields::Loading_Step];
		if ($loadingStep == '')
			return;
		
		$loadingStep = ( integer ) $loadingStep;		
		
		if ( $this->_currentPartsMission [PART_MISSION::LOADING] == null &&
			 $loadingStep < 48 &&
			 !$this->_isLoadingEnd) {
			// loading start
			$this->startPartMission ( PART_MISSION::LOADING );
		}
		
		if ($loadingStep == 48 &&
			!$this->_isLoadingEnd && 
			$this->_currentPartsMission[PART_MISSION::LOADING] != null) {
				
				/* d($this->_isLoadingEnd);
				d($this->_currentPartsMission);
				dd($loadingStep); */
				
			// loading end
			$this->endPartMission ( PART_MISSION::LOADING );
			$this->_isLoadingEnd = true;
		}
		
		if ($this->_isLoadingEnd) {
			if ( $loadingStep == 48) {
				// unloading start
				$this->startPartMission ( PART_MISSION::UNLOADING );
			}
			
			if ($loadingStep == 0 && $this->_currentPartsMission[PART_MISSION::UNLOADING] != null) {
				// unloading end
				$this->endPartMission ( PART_MISSION::UNLOADING );
			}
		}
		$this->_lastLoadingStep = $loadingStep;
	}
	private function GetDateTimeByCurrentDate() {
		$datetime = new DateTime ( $this->_currentDate . "+00" );
		$datetime->setTimeZone ( new DateTimeZone ( 'Europe/Berlin' ) );
		return $datetime;
	}
	private function GetDateTimeByDateString($date) {
		$datetime = new DateTime ( $date . "+00" );
		$datetime->setTimeZone ( new DateTimeZone ( 'Europe/Berlin' ) );
		return $datetime;
	}
	private function examineFuelUsage() {
		$fuelEngineLeft = $this->_row [LoggerFields::Total_fuel_used_Engine_Left]; // 73
		$fuelEngineRight = $this->_row [LoggerFields::Total_fuel_used_Engine_Right]; // 72
		
		if ($fuelEngineLeft != '') {
			if ($this->lastFuelEngineLeft == null) {
				$this->firstFuelEngineLeft = ( double ) $fuelEngineLeft;
				$this->_startLeftFuel [PART_MISSION::LOADING] = ( double ) $fuelEngineLeft;
			}
			
			$this->lastFuelEngineLeft = ( double ) $fuelEngineLeft;
		}
		
		if ($fuelEngineRight != '') {
			if ($this->lastFuelEngineRight == null) {
				$this->firstFuelEngineRight = ( double ) $fuelEngineRight;
				$this->_startRightFuel [PART_MISSION::LOADING] = ( double ) $fuelEngineRight;
			}
			
			$this->lastFuelEngineRight = ( double ) $fuelEngineRight;
		}
	}
	private function examineEngineHours() {
		$hoursEenginRight = $this->_row [LoggerFields::Total_engine_hours_Eng_R]; // 85
		$hoursEenginLeft = $this->_row [LoggerFields::Total_engine_hours_Eng_L]; // 86
		
		if ($hoursEenginRight != '') {
			if ($this->_hoursEngineRight == null) {
				$this->_startRightHours [PART_MISSION::LOADING] = ( double ) $hoursEenginRight;
				// print "<pre>"; print_r ($this->_startRightHours [PART_MISSION::LOADING] ); print "</pre>"; die();
			}
			$this->_hoursEngineRight = (( double ) $hoursEenginRight);
		}
		
		if ($hoursEenginLeft != '') {
			if ($this->_hoursEngineLeft == null) {
				$this->_startLeftHours [PART_MISSION::LOADING] = ( double ) $hoursEenginLeft;
			}
			$this->_hoursEngineLeft = (( double ) $hoursEenginLeft);
		}
	}
	public function getPartMissionInEndFile($type, $start) {
		
		$part = new TaxibotPartsMission ();
		$part->setType ( $type );
		$part->setStart (   $start  );
		$part->setEnd ( $this->GetDateTimeByCurrentDate () );
	 
		$part->setLeftEngineFuel ( $this->lastFuelEngineLeft - $this->_startLeftFuel [$type] );
		$part->setRightEngineFuel ( $this->lastFuelEngineRight - $this->_startRightFuel [$type] );
		$part->setLeftEngineHours ( $this->_hoursEngineLeft - $this->_startLeftHours [$type] );
		$part->setRightEngineHours ( $this->_hoursEngineRight - $this->_startRightHours [$type] );
		
		return $part;
	}
}