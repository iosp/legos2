<?php
class FatigueHistoryImport {
	private $_index = 0;
	private $_aircaft;
	private $_longForceKn = null;
	private $_latForceKn = null;
	private $_lastVeolcity = null;
	private $_tiller = null;
	private $_isBreakEvent = null;
	private $_row;
	private $_drivingMode;
	private $_items = array ();
	private $_isForceValid = false;
	private $_turretValidity = false;
	private $_pilotValidity = false;
	private $_isLocVelValidity = false;
	private $_type = null;
	function __construct($aircaft) {		
		$this->_aircaft = $aircaft;
		$this->_type = AircraftTypePeer::GetAircaftType ( $this->_aircaft );
	}	 
	public function GetItems() {
		return $this->_items;
	}
	public function readRowData($rowItem, $veolcity) {
		$this->_row = $rowItem;
		
		$isNewlongForce = $this->dasLongForceChange ();
		$isNewlatForce = $this->dasLatForceChange ();
		$isNewveolcity = $this->dasVeolcityChange ($veolcity);
		$isNewtiller = $this->dasTillerChange ();
		$isNewBreakEvent = $this->getBreakEvent ();
				
		if ($isNewlongForce || $isNewlatForce || $isNewveolcity || $isNewtiller || $isNewBreakEvent) {
			$date = $this->GetDateTimeFromCsvFormat ( $this->_row [LoggerFields::Data_Time_UTC] );
			
			$item = new TaxibotFatigueHistory ();
			$item->setAircraftId ( $this->_aircaft->getId());
			$item->setDate ( $date );	
			$item->setMilisecond($date->format('u') );
			$item->setLongForceKn ( $this->_longForceKn == null ? 0 : $this->_longForceKn );
			$item->setLatForceKn ( $this->_latForceKn == null ? 0 : $this->_latForceKn );
			$item->setVeolcity ( $this->_lastVeolcity == null ? 0 : $this->_lastVeolcity );
			$item->setTiller ( $this->_tiller == null ? 0 : $this->_tiller );
			$item->setBreakEvent ( $this->_isBreakEvent );
			array_push ( $this->_items, $item );
		}		
		// $this->_index++;
	}
	private function dasLongForceChange() {
		$isValid = $this->_row [LoggerFields::NLG_longitudinal_force_validity];
		$longForce = $this->_row [LoggerFields::NLG_longTug_force_kN];
		
		if ($isValid != '') {
			$this->_isForceValid = ( bool ) $isValid;
		}
		
		if ($this->_isForceValid && $longForce != '' && $longForce != $this->_longForceKn) {
			$this->_longForceKn = $longForce;
			return true;
		}  

		return false;
		
	}
	private function dasLatForceChange() {
		$isValid = $this->_row [LoggerFields::NLG_longitudinal_force_validity];
		$latForce = $this->_row [LoggerFields::NLG_lateral_force_kN];
		
		if ($isValid != '') {
			$this->_isForceValid = ( bool ) $isValid;
		}
		
		if ($this->_isForceValid && $latForce != '' && $latForce != $this->_latForceKn) {
			$this->_latForceKn = $latForce;
			return true;
		}  
			
		return false; 
	}
	private function dasTillerChange() {
		$totalSteerAngle = $this->_row [LoggerFields::Total_Steer_Angle_Demand];
	
		if ($totalSteerAngle == '') {
			return false;
		}
		
		$tiller = $totalSteerAngle * 1;
		if ($this->_tiller != $tiller){
			$this->_tiller = $tiller;
			return true;
		}
		
		return false;
	}
/* 	private function getTiller() {
		$drivingMode = $this->_row [LoggerFields::Driving_mode];
		
		if ($drivingMode != '') {
			$this->_drivingMode = $drivingMode;
		}
		
		if (Ac_Type::Airbus == $this->_type) {
			return $this->getAirbusTiller ();
		} elseif (Ac_Type::Boeing == $this->_type) {
			return $this->getBoeingTiller ();
		}
	}
  	private function getAirbusTiller() {
		$pilotValidity = $this->_row [LoggerFields::Pilot_command_angle_validity];
		$pilotDeg = $this->_row [LoggerFields::Pilot_command_angle_deg];
		
		if ($pilotValidity != '') {
			$this->_pilotValidity = ( bool ) $pilotValidity;
		}
		
		if ($this->_drivingMode == 10 && $this->_pilotValidity && $pilotDeg != $this->_tiller) {
			$this->_tiller = $pilotDeg;
			return true;
		} else {
			return false;
		}
	}
	private function getBoeingTiller() {
		$turretValidity = $this->_row [LoggerFields::Turret_angle_validity];
		$turretDeg = $this->_row [LoggerFields::Turret_angle_deg];
		
		if ($turretValidity != '') {
			$this->_turretValidity = ( bool ) $turretValidity;
		}
		
		if ($this->_drivingMode == 9 && $this->_turretValidity && $turretDeg != $this->_tiller) {
			$this->_tiller = $turretDeg;
			return true;
		} else {
			return false;
		}
	} */
	private function getBreakEvent() {
		$isBreakEvent = $this->_row [LoggerFields::Pilot_Brake_flag_Filtered];
		
		if ($isBreakEvent != '' && $isBreakEvent != $this->_isBreakEvent) {
			$this->_isBreakEvent = $isBreakEvent;
			return true;
		}
		 
		return false;		
	}
	private function dasVeolcityChange($veolcity) {		
		/* if($veolcity > 0){
			$date =  $this->GetDateTimeFromCsvFormat ( $this->_row [LoggerFields::Data_Time_UTC] );
			dd($date);
			
			die($veolcity);
		} 	 */
		
		$veolcityKnot = $veolcity *  1.9438444924406;
		
		if ($veolcityKnot != $this->_lastVeolcity) {
			$this->_lastVeolcity = $veolcityKnot;
			return true;
		}  
		
		return false;
	}
	private function GetDateTimeFromCsvFormat($value) {
		$datetime = new DateTime ( $value . "+00" );
		$datetime->setTimeZone ( new DateTimeZone ( 'Europe/Berlin' ) );
		return $datetime;
	}	
	public function SaveAllItems($missionId) {
		//TaxibotFatigueHistoryPeer::insertMultiple ( $this->_items, $missionId );return;
		$count =  count($this->_items);
		if($count < 2000){
			$index = 0;
		}
		else{
			$index = $count - 2000;
		}
		
		$items = array_splice($this->_items, $index, 2000);	
		
		while( $items ){
			TaxibotFatigueHistoryPeer::insertMultiple ( $items, $missionId );
			
			$count =  count($this->_items);
			if($count < 2000){
				$index = 0;
			}
			else{
				$index = $count - 2000;
			}
			
			$items = array_splice($this->_items, $index, 2000);			
		}		
	}
}