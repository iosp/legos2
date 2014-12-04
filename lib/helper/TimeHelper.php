<?php
//require_once sfConfig::get ( 'app_lib_helper' ) . "/TimeHelper.php";
function DateIntervalToSec(DateInterval $di) {
	if ($di->d != 0 || $di->m != 0 || $di->y != 0) {
		echo "<br/> days =  $di->d  mounths =   $di->m   years =  $di->y <br/>";
		throw new Exception ( "DateIntervalToSec not good for dates" );
	}
	
	return $di->h * 3600 + $di->i * 60 + $di->s;
}
function SecToDateInterval($sec) {
	// echo "SecToDateInterval sec = $sec <br/>";//debug
	if ($sec == 0)
		return DateInterval::createFromDateString ( "0 seconds" );
	
	$intSec = ( int ) ($sec + 0.5);
	
	$hours = ( int ) ($intSec / 3600);
	
	$minutes = ( int ) (($intSec - $hours * 3600) / 60);
	
	$timeStr = $hours . " hours " . $minutes . " minutes " . ($intSec - $hours * 3600 - $minutes * 60) . " seconds";
	
	// echo "timeStr = $timeStr<br/>";//debug
	
	return DateInterval::createFromDateString ( $timeStr );
}
function GetDateTimeFromCsvFormat($value) {
	$datetime = new DateTime ( $value . "+00" );
	$datetime->setTimeZone ( new DateTimeZone ( 'Europe/Berlin' ) );
	return $datetime;
}
function getSumOfTowTimes($time1, $time2) {
	return gmdate ( "H:i:s", getSecondsFromTime ( $time1 ) + getSecondsFromTime ( $time2 ) );
}
function getSecondsFromTime($time) {
	$partTime = explode ( ":", $time );
	return ($partTime [0] * 3600) + ($partTime [1] * 60) + $partTime [2];
}
function getTimeBetweenDates($start, $end) {
	$startDate = new DateTime ( $start );
	$endDate = new DateTime ( $end );
	$seconds = $endDate->getTimestamp () - $startDate->getTimestamp ();
	return gmdate ( "H:i:s", $seconds );
}
function getSecondsBetweenDates($start, $end) {
	$startDate = new DateTime ( $start );
	$endDate = new DateTime ( $end );
	return $endDate->getTimestamp () - $startDate->getTimestamp ();
}

function dateDiff($time1, $time2, $precision = 6) {
	// If not numeric then convert texts to unix timestamps
	if (!is_int($time1)) {
		$time1 = strtotime($time1);
	}
	if (!is_int($time2)) {
		$time2 = strtotime($time2);
	}

	// If time1 is bigger than time2
	// Then swap time1 and time2
	if ($time1 > $time2) {
		$ttime = $time1;
		$time1 = $time2;
		$time2 = $ttime;
	}

	// Set up intervals and diffs arrays
	$intervals = array('year','month','day','hour','minute','second');
	$diffs = array();

	// Loop thru all intervals
	foreach ($intervals as $interval) {
		// Create temp time from time1 and interval
		$ttime = strtotime('+1 ' . $interval, $time1);
		// Set initial values
		$add = 1;
		$looped = 0;
		// Loop until temp time is smaller than time2
		while ($time2 >= $ttime) {
			// Create new temp time from time1 and interval
			$add++;
			$ttime = strtotime("+" . $add . " " . $interval, $time1);
			$looped++;
		}

		$time1 = strtotime("+" . $looped . " " . $interval, $time1);
		$diffs[$interval] = $looped;
	}

	$count = 0;
	$times = array();
	// Loop thru all diffs
	foreach ($diffs as $interval => $value) {
		// Break if we have needed precission
		if ($count >= $precision) {
			break;
		}
		// Add value and interval
		// if value is bigger than 0
		if ($value > 0) {
			// Add s if value is not 1
			if ($value != 1) {
				$interval .= "s";
			}
			// Add value and interval to times array
			$times[] = $value . " " . $interval;
			$count++;
		}
	}

	// Return string with times
	return implode(", ", $times);
}	
?>