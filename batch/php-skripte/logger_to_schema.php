<?php
function readCSV($csvFile) {
	$stack_name = array ();
	$scehma = array ();
	$schema [] = "<table name=\"taxibot_stack\" phpName=\"TaxibotStack\" description=\"TaxibotStack\">";
	$schema [] = "	<column name=\"id\" type=\"INTEGER\" primaryKey=\"true\" required=\"true\" autoIncrement=\"true\"/>";
	$file_handle = fopen ( $csvFile, 'r' );
	while ( ! feof ( $file_handle ) ) {
		$line = fgetcsv ( $file_handle, 1024 );
		if (strlen ( $line [4] ) > 0) {
			$stack_name [] = $line [4];
			$schema [] = "	<column name=\"" . $line [4] . "\" type=\"VARCHAR\" description=\"" . $line [1] . "\"  required=\"true\"/>";
			$line_of_text [] = $line;
		}
	}
	fclose ( $file_handle );
	$schema [] = "</table>";
	return $schema;
}

// Set path to CSV file
$csvFile = '/home/user/workspace/csv-files/taxibot/logger_structure/CAN-DB_Log_Mapping_with_Names.csv';
$schemaFile = '/home/user/workspace/legos2/config/schema1.txt';

$csv = readCSV ( $csvFile );

$file_handle = fopen ( $schemaFile, 'w' );

foreach ( $csv as $column ) {
	fwrite ( $file_handle, $column . "\n" );
}
fclose ( $file_handle );

?>