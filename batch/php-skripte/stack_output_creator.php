<?php

// some 'Stack' mumbo-jumbo stuff at file header
$header = "DataPro Export File\nCopyright (c) Stack Limited 2002\n\nTrack : SILTST1\nSession  : 121029\nRun : 002\nCreation Date : Monday  October 29 2012 17:37:05\n\nData Range : 00:00:00.000 -> 00:00:36.500 (Complete Run)\nData Exported : Tuesday October 30 2012 13:33:45\n\n";

$csvFile = '/home/user/workspace/csv-files/taxibot/logger_structure/CAN-DB_Log_Mapping_with_Names.csv';

// header creation
$column_headers = '';
$units = '';
$num_of_fields = 0;
$maxs = array ();
$mins = array ();

$csv_file_handle = fopen ( $csvFile, 'r' );
while ( ! feof ( $csv_file_handle ) ) {
	$line = fgetcsv ( $csv_file_handle, 1024 );
	if (strlen ( $line [4] ) > 0 && ! strstr ( $line [4], "STACK Name" )) {
		$column_headers .= ',' . $line [4];
		$units .= ',' . $line [18];
		$max = $line [15];
		$min = $line [14];
		settype ( $max, 'int' );
		settype ( $min, 'int' );
		$maxs [] = $max;
		$mins [] = $min;
		++ $num_of_fields;
	}
}

$missionColNum = 52;
$missionId = rand ( 100, 1000 );
$nlgColNum = 85;

// trim first colon
$column_headers = substr ( $column_headers, 1 );
$units = substr ( $units, 1 );

// data creation
$data = '';

for($i = 0; $i < 50; $i ++) {
	echo 'line no. ' . $i . "\n";
	$line = '';
	list ( $usec, $sec ) = explode ( " ", microtime () );
	var_dump ( $usec );
	echo "<br />";
	var_dump ( $sec );
	echo "<br />";
	die ();
	
	for($j = 0; $j < $num_of_fields; $j ++) {
		$length = 3;
		switch ($j) {
			case 0 : // year
				$line = '2013';
				break;
			case 1 : // mounth
				$line .= ',' . '06';
				break;
			case 2 : // day of mounth
				$line .= ',' . '27';
				break;
			case 3 : // hour
				$line .= ',' . '22';
				break;
			case 4 : // mim
				$line .= ',' . $sec;
				break;
			case 5 : // mili sec
				$line .= ',' . ( string ) (( float ) $sec * 1000.0 + ( float ) $usec);
				break;
			case $missionColNum :
				$line .= (',' . $missionId);
				break;
			case $nlgColNum :
				$line .= (',' . rand ( - 5, 5 ));
				break;
			default :
				if ($maxs [$j] > 0) {
					$line .= ',' . rand ( $mins [$j], $maxs [$j] );
				} else {
					$line .= ',' . substr ( str_shuffle ( "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ" ), 0, $length );
				}
				break;
		}
	}
	
	// trim first colon and whitespace and add LF
	$data .= $line . "\n";
}

// open file for writing
// $file_handle = fopen('/home/user/workspace/legos2/config/logger_output1.txt', 'w');
$file_handle = fopen ( '/home/user/workspace/legos2/config/logger_output1.txt', 'w' );

// write to file
fwrite ( $file_handle, $header . $column_headers . "\n" . $units . "\n" . $data );

// close file
fclose ( $file_handle );

?>