<?php
require 'lib/model/om/BaseTaxibotPartsMissionPeer.php';

/**
 * Skeleton subclass for performing query and update operations on the 'taxibot_parts_mission' table.
 *
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * Sat Nov 8 22:37:25 2014
 *
 * You should add additional methods to this class to meet the
 * application requirements. This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package lib.model
 */
class TaxibotPartsMissionPeer extends BaseTaxibotPartsMissionPeer {
	
	public static function updateMissionId($fromMissionId, $toMissionId) {
		$connection = Propel::getConnection ();
		$query = 'UPDATE `taxibot_parts_mission` SET `mission_id`= ' . $toMissionId . ' WHERE `mission_id` = ' . $fromMissionId;
		$statement = $connection->prepare ( $query );
		$statement->execute ();
	}
	
	static public function GetPartMissionSeconds($type, $parts) {		
		$seconds = 0;
		foreach ( $parts as $part ) {
			if ($part->getType () != $type)
				continue;
			
			$start = new DateTime ( $part->getStart () );
			$end = new DateTime ( $part->getEnd () );
			
			$seconds += $end->getTimestamp() - $start->getTimestamp();
		}
		
		return $seconds; // gmdate ( "H:i:s", $seconds );
	}
	
	static public function GetPartByType($type, $parts) {		 
		foreach ( $parts as $part ) {
			if ($part->getType () == $type)
				return  $part;
		}
	
		return null;
	}	
	
	static public function GetAmountOfCoulmn($type, $parts, $column) {
		$amount = 0;
		foreach ( $parts as $part ) {
			if ($part->getType () != $type)
				continue;
			
			switch ($column) {
				case PART_COULMN::LEFT_FUEL :
					$amount += $part->getLeftEngineFuel ();
					break;
				case PART_COULMN::LEFT_HOURS :
					$amount += $part->getLeftEngineHours ();
					break;
				case PART_COULMN::RIGHT_FUEL :
					$amount += $part->getRightEngineFuel ();
					break;
				case PART_COULMN::RIGHT_HOURS :
					$amount += $part->getRightEngineHours ();
					break;
			}
		}
		
		return $amount;
	}
	public static function deleteByMissionId($missionId)
	{
		$connection = Propel::getConnection();
		$query = 'DELETE FROM `taxibot_parts_mission` WHERE `mission_id` = ' . $missionId;
		$statement = $connection->prepare($query);
		$statement->execute();
	}
	static public function GetSumHours($parts, $side) {
		
		$amount = 0;
		foreach ( $parts as $part ) {
			if ($part->getType () == PART_MISSION::BREAKING || $part->getType () == PART_MISSION::PUSHBACK) {				
				continue;
			}
			
			//$part = new TaxibotPartsMission(); // DEBUG
			
			switch ($side) {
				case ENGINE_SIDE::LEFT :
					$amount += $part->getLeftEngineHours();
					break;
				case ENGINE_SIDE::RIGHT :
					$amount += $part->getRightEngineHours();
					break;
			}
		}
		
		return $amount;
	}
} // TaxibotPartsMissionPeer
abstract class ENGINE_SIDE {
	const LEFT = "LEFT";
	const RIGHT = "RIGHT";
}
abstract class PART_COULMN {
	const LEFT_FUEL = "LEFT_FUEL";
	const RIGHT_FUEL = "RIGHT_FUEL";
	const LEFT_HOURS = "LEFT_HOURS";
	const RIGHT_HOURS = "RIGHT_HOURS";
}
