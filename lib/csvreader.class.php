<?php

/**
 * Klasse zum Lesen von CSV-Dateien, welche die Zeilen in einem Hash (Spaltenname=>Zeileninhalt) zurückgibt
 *
 * @author Jan Dillmann
 **/
class CSVReader {
	private $csv_file;
	private $rows;
	private $columns;
	
	/**
	 * Konstruktor
	 *
	 * @param string $filename
	 *        	Name der zu importierenden Datei
	 * @return NULL
	 */
	function __construct($filename) {
		$this->csv_file = $filename;
		
		if (! file_exists ( $this->csv_file )) {
			die ( "FEHLER: Die Datei \"$this->csv_file\" konnte nicht gefunden werden.\n" );
		} else {
			$handle = fopen ( $this->csv_file, "r" );
			$row = 0;
			$n = 0;
			// jede Zeile in der CSV-Datei auslesen und speichern
			while ( ($data = fgetcsv ( $handle, 2000, ";" )) !== FALSE ) {
				$row ++;
				if ($row == 1) {
					// erste Zeile = Spaltennamen
					$new_data = array ();
					foreach ( $data as $d )
						$new_data [] = utf8_encode ( $d );
					$this->columns = $new_data;
				} else {
					// restliche Zeilen = Daten
					if (sizeof ( $data ) > 0) {
						$new_data = array ();
						foreach ( $data as $d )
							$new_data [] = utf8_encode ( $d );
						$this->rows [$n] = $new_data;
						$n ++;
					}
				}
			}
			fclose ( $handle );
		}
	}
	
	/**
	 * Gibt die Anzahl der Zeilen zurück
	 */
	function count() {
		return sizeof ( $this->rows );
	}
	
	/**
	 * Gibt einen Hash mit Spaltenname=>Zeileninhalt der gewünschten Zeile zurück
	 *
	 * @param integer $row
	 *        	Nummer der gewünschten Zeile
	 */
	function get($row) {
		$return = array ();
		for($i = 0; $i < sizeof ( $this->rows [$row] ) - 1; $i ++) {
			$return [$this->columns [$i]] = trim ( $this->rows [$row] [$i] );
		}
		return $return;
	}
}

?>