<?php



function DateIntervalToSec(DateInterval $di){
	if($di->d != 0 ||  $di->m != 0 || $di->y != 0){
		echo "<br/> days =  $di->d  mounths =   $di->m   years =  $di->y <br/>";
		throw new Exception("DateIntervalToSec not good for dates");
	}		

	return $di->h * 3600 + $di->i * 60 + $di->s;
}


function SecToDateInterval( $sec){
	//echo "SecToDateInterval sec = $sec <br/>";//debug
	
	if($sec == 0)
		return DateInterval::createFromDateString("0 seconds");
	
	$intSec =  (int)($sec + 0.5);
	
	$hours = (int)($intSec/3600);
	
	$minutes = (int)(($intSec - $hours * 3600)/60);
	
	$timeStr = $hours . " hours " . $minutes . " minutes " . ($intSec - $hours * 3600 - $minutes * 60) . " seconds";
	
	//echo "timeStr = $timeStr<br/>";//debug  

	return DateInterval::createFromDateString($timeStr);

}

?>