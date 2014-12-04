<?php
class MaintenanceViewModel{
	public $maintStartDate;
	public $maintEndDate;
	public $maintTotalTime;
	public $leftEngineFuel;
	public $rightEngineFuel;	
	function __construct(TaxibotMission $mission) {
		require_once sfConfig::get( 'app_lib_helper' ). "/TimeHelper.php";
		
		$this->maintStartDate = $mission->getStartTime();	
		$this->maintEndDate = $mission->getEndTime();
		$this->maintTotalTime = getTimeBetweenDates($this->maintStartDate, $this->maintEndDate);
		$this->leftEngineFuel = $mission->getLeftEngineFuel();
		$this->rightEngineFuel = $mission->getRightEngineFuel();
	}
}