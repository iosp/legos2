<?php
class MissionPageViewModel {
	public $DcmTotalTime;
	public $PcmTotalTime;
	public $PcmTimes = array ();
	public $PushbackTimes = array ();
	public $TotalMissionTime;
	public $LeftPcmFuel;
	public $RightPcmFuel;
	public $LeftDcmFuel;
	public $RightDcmFuel;
	public $LeftPushbackFuel;
	public $RightPushbackFuel;
	public $DateFilter;
	public $FlightNumber;
	public $TaxibotNumber;
	public $BlfName;
	public $chartData = array();
	public $PushbackTotalTime;
	function __construct(TaxibotMission $mission) {
		$this->DateFilter = $mission->getStartTime("Y-m-d");
		$this->FlightNumber = $mission->getFlightNumber ();
		$this->TaxibotNumber = $mission->getTaxibotTractor ()->getName ();
		$this->BlfName = $mission->getBlfName ();
		
		$criteria = new Criteria();
		$criteria->addAscendingOrderByColumn(TaxibotPartsMissionPeer::START);
		$partsMission =   $mission->getTaxibotPartsMissions ($criteria);
		//dd($partsMission);
		foreach ( $partsMission as $part ) {
			//$part = new TaxibotPartsMission();
			$this->chartData[] = array($part->getType(), $part->getStart(), $part->getEnd());
			
			if ($part->getType () == PART_MISSION::PCM) {
				array_push ( $this->PcmTimes, array (
						'start' => $part->getStart ( "H:i:s" ),
						'end' => $part->getEnd ( "H:i:s" ),
						'total' => $this->getDiffTime ( $part->getStart (), $part->getEnd () ) 
				) );
			}
			
			if ($part->getType () == PART_MISSION::PUSHBACK) {
				array_push ( $this->PushbackTimes, array (
						'start' => $part->getStart ( "H:i:s" ),
						'end' => $part->getEnd ( "H:i:s" ),
						'total' => $this->getDiffTime ( $part->getStart (), $part->getEnd () ) 
				) );
			}
		}
		
		$pcmTotalSeconds = TaxibotPartsMissionPeer::GetPartMissionSeconds ( PART_MISSION::PCM, $mission->getTaxibotPartsMissions () );
		$pushbackTotalSeconds = TaxibotPartsMissionPeer::GetPartMissionSeconds ( PART_MISSION::PUSHBACK, $mission->getTaxibotPartsMissions () );
		$totalMissionSeconds = $this->getSecondsBetweenTowDates ( $mission->getStartTime (), $mission->getEndTime () );
		$this->TotalMissionTime = gmdate ( "H:i:s", $totalMissionSeconds );
		$this->DcmTotalTime = gmdate ( "H:i:s", $totalMissionSeconds - $pcmTotalSeconds );
		$this->PcmTotalTime = gmdate ( "H:i:s", $pcmTotalSeconds );
		$this->PushbackTotalTime = gmdate ( "H:i:s", $pushbackTotalSeconds );
		
		
		$this->LeftDcmFuel = TaxibotPartsMissionPeer::GetAmountOfCoulmn ( PART_MISSION::DCM, $mission->getTaxibotPartsMissions (), PART_COULMN::LEFT_FUEL );
		$this->RightDcmFuel = TaxibotPartsMissionPeer::GetAmountOfCoulmn ( PART_MISSION::DCM, $mission->getTaxibotPartsMissions (), PART_COULMN::RIGHT_FUEL );
		$this->LeftPcmFuel = TaxibotPartsMissionPeer::GetAmountOfCoulmn ( PART_MISSION::PCM, $mission->getTaxibotPartsMissions (), PART_COULMN::LEFT_FUEL );
		$this->RightPcmFuel = TaxibotPartsMissionPeer::GetAmountOfCoulmn ( PART_MISSION::PCM, $mission->getTaxibotPartsMissions (), PART_COULMN::RIGHT_FUEL );
		$this->LeftPushbackFuel = TaxibotPartsMissionPeer::GetAmountOfCoulmn ( PART_MISSION::PUSHBACK, $mission->getTaxibotPartsMissions (), PART_COULMN::LEFT_FUEL );
		$this->RightPushbackFuel = TaxibotPartsMissionPeer::GetAmountOfCoulmn ( PART_MISSION::PUSHBACK, $mission->getTaxibotPartsMissions (), PART_COULMN::RIGHT_FUEL );	
		
	}
	private function getDiffTime($d1, $d2) {
		$diff = $this->getSecondsBetweenTowDates ( $d1, $d2 );
		return gmdate ( "H:i:s", $diff );
	}
	private function getSecondsBetweenTowDates($d1, $d2) {
		$date1 = new DateTime ( $d1 );
		$date2 = new DateTime ( $d2 );
		return $date2->getTimestamp () - $date1->getTimestamp ();
	} 
}