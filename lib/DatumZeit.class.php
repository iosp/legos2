<?php
class DatumZeit {
	private $meldungen = array ();
	
	/**
	 * Diese Funktion gibt den Zeitstempel eines deutsch formatierten Datums ('d.m.Y H:i:s') zurück.
	 * Sollte es zu einem Fehler kommen, so kann man diesen in einer in der app.yml-Datei angegebene
	 * Logfile schreiben lassen.
	 *
	 * @author Michael
	 * @param $datum string
	 *        	Ein String, der ein Datum (optional mit Uhrzeit) in deutschem Format enthält
	 * @param $logfile optionaler
	 *        	string Bezeichner einer Logfile aus der app.yml
	 * @return integer Unix-Timestamp der Datums
	 */
	public static function getZeitstempelVonDeutschemDatum($datum, $logfile = null) {
		try {
			$zerlegtes_datum = explode ( '.', $datum, 4 );
			/*
			 * An dieser Stelle ist der $zerlegtes_datum[0] der Tag und [1] der Monat. Wurde nur ein Datum übergeben, ist $zerlegtes_datum[2] das Jahr. Wurde ein Datum mit Uhrzeit übergeben, ist $zerlegtes_datum[2] folgendes: 'Y H:i:s'.
			 */
			if (count ( $zerlegtes_datum ) <= 2) {
				throw new Exception ( 'Falsch formatiertes Datum übergeben' );
			}
			$monat = $zerlegtes_datum [1];
			$tag = $zerlegtes_datum [0];
			
			/*
			 * Nun wird das Jahr von der Uhrzeit getrennt. Wurde keine Uhrzeit übergeben, wird nur das Jahr zurückgegeben.
			 */
			$jahr_und_uhrzeit = explode ( ' ', $zerlegtes_datum [2] );
			
			$jahr = $jahr_und_uhrzeit [0];
			$uhrzeit = (count ( $jahr_und_uhrzeit ) >= 2 ? $jahr_und_uhrzeit [1] : null);
			
			return strtotime ( $jahr . '-' . $monat . '-' . $tag . ' ' . $uhrzeit );
			
			/*
			 * Wenn beim Trennen von Jahr und Uhrzeit eine Uhrzeit mit abgefallen ist, könnte man diese nun noch in Stunde, Minute und Sekunde teilen. Das ist nicht nötig, da das Format der Uhrzeit im Deutschen und im Angelsächsischen gleich ist. if( count($jahr_und_uhrzeit) > 1 ) { $zerlegtes_jahr_und_uhrzeit = explode( ':', $jahr_und_uhrzeit[1] ); $stunde = $zerlegtes_jahr_und_uhrzeit[0]; $minute = $zerlegtes_jahr_und_uhrzeit[1]; $sekunde = $zerlegtes_jahr_und_uhrzeit[2]; }
			 */
		} catch ( Exception $e ) {
			global $meldungen;
			
			// Wenn Exception geworfen wird, dann wird es auch noch ins Log geschrieben, sofern ein Dateiname mit angegeben wurde.
			if ($logfile != null) {
				$meldungen [] = date ( 'd.m.Y H:i:s' ) . ' ' . $e->getMessage () . ' ("' . $datum . '")';
				self::schreibeLog ( $meldungen, $logfile );
				// mail(sfConfig::get('app_mail_reciever'), "Fehler beim generieren des Timestamps aus einem deutschen Datum", "Fehlermeldung: ". $e->getMessage(), sfConfig::get('app_mail_header') . sfConfig::get('app_mail_reply_to'));
			}
		}
	}
	
	/**
	 * Gibt das Jahr aus dem übergebenen Datum zurück
	 *
	 * @author Jan
	 * @param
	 *        	string Datum und Uhrzeit in deutschem Format
	 * @return integer Die Jahreszahl
	 */
	public static function getJahr($datum) {
		$zerlegtes_datum = explode ( '.', $datum, 4 );
		$jahr_und_uhrzeit = explode ( ' ', $zerlegtes_datum [2] );
		$jahr = $jahr_und_uhrzeit [0];
		return $jahr;
	}
	
	/**
	 * Gibt den Monat aus dem übergebenen Datum zurück
	 *
	 * @author Jan
	 * @param
	 *        	string Datum und Uhrzeit in deutschem Format
	 * @return integer Die Monatszahl
	 */
	public static function getMonat($datum) {
		$zerlegtes_datum = explode ( '.', $datum, 4 );
		$monat = $zerlegtes_datum [1];
		return $monat;
	}
	
	/**
	 * Gibt den Tag aus dem übergebenen Datum zurück
	 *
	 * @author Jan
	 * @param
	 *        	string Datum und Uhrzeit in deutschem Format
	 * @return integer Die Tageszahl
	 */
	public static function getTag($datum) {
		$zerlegtes_datum = explode ( '.', $datum, 4 );
		$tag = $zerlegtes_datum [0];
		return $tag;
	}
	
	/**
	 * Gibt das Format Minute:Sekunde aus den übergebenen Sekunden zurück
	 *
	 * @author Joachim
	 * @param
	 *        	integer Sekunden
	 * @return string Min:Sek
	 */
	public static function getMinuteUndSekunde($sekunden) {
		return self::berechneUhrzeit ( $sekunden );
	}
	
	/**
	 * Gibt das Format Stunde:Minute aus den übergebenen Minuten zurück
	 *
	 * @author Michael
	 * @param
	 *        	integer Minuten
	 * @return string Std:Min
	 */
	public static function getStundeUndMinute($minuten) {
		return self::berechneUhrzeit ( $minuten );
	}
	
	/**
	 * Wandelt eine Dauer in Sekunden ins Format H:m:s um
	 * (Bei der Verwendung von date() kommt eine Stunde zuviel bei raus)
	 *
	 * @author Jan
	 * @param integer $timestamp
	 *        	Sekunden
	 * @return string Uhrzeit
	 */
	public static function getUhrzeit($timestamp) {
		$sekunden = $timestamp % 60;
		$minuten = floor ( $timestamp / 60 ) % 60;
		$stunden = floor ( floor ( $timestamp / 60 ) / 60 );
		return ($stunden < 10 ? "0" . $stunden : $stunden) . ':' . ($minuten < 10 ? "0" . $minuten : $minuten) . ':' . ($sekunden < 10 ? "0" . $sekunden : $sekunden);
	}
	
	/**
	 * Diese Funktion entfernt in einem Datums-String "<Tag>, dd.mm.yyyy" den ersten Teil,
	 * sodass "dd.mm.yyyy" zurück gegeben wird.
	 *
	 * @param $datum string
	 *        	im Format "<Tag>, dd.mm.yyyy"
	 * @return string im Format "dd.mm.yyyy"
	 */
	public static function removeDayName($datum) {
		$datum = str_replace ( "Montag, ", "", $datum );
		$datum = str_replace ( "Dienstag, ", "", $datum );
		$datum = str_replace ( "Mittwoch, ", "", $datum );
		$datum = str_replace ( "Donnerstag, ", "", $datum );
		$datum = str_replace ( "Freitag, ", "", $datum );
		$datum = str_replace ( "Samstag, ", "", $datum );
		$datum = str_replace ( "Sonntag, ", "", $datum );
		
		return $datum;
	}
	
	/**
	 * Diese Funktion ersetzt in einem Datums-String "dd.
	 * <monat> yyyy" den Monat durch die Zahl
	 *
	 * @param $datum string
	 *        	im Format "dd. <monat> yyyy"
	 * @return string im Format "dd.mm.yyyy"
	 */
	public static function removeMonthName($datum) {
		$datum = str_replace ( "Januar", "01", $datum );
		$datum = str_replace ( "Februar", "02", $datum );
		$datum = str_replace ( "März", "03", $datum );
		$datum = str_replace ( "April", "04", $datum );
		$datum = str_replace ( "Mai", "05", $datum );
		$datum = str_replace ( "Juni", "06", $datum );
		$datum = str_replace ( "Juli", "07", $datum );
		$datum = str_replace ( "August", "08", $datum );
		$datum = str_replace ( "September", "09", $datum );
		$datum = str_replace ( "Oktober", "10", $datum );
		$datum = str_replace ( "November", "11", $datum );
		$datum = str_replace ( "Dezember", "12", $datum );
		// Leerzeichen durch Punkte ersetzen
		$datum = str_replace ( " ", ".", $datum );
		// Zwei Punkte durch einen Punkt ersetzen
		$datum = str_replace ( "..", ".", $datum );
		return $datum;
	}
	
	/**
	 * Schreibe den Inhalt vom Array $meldung an das Ende der Logfile, die in der Konfiguration unter $datei angegeben ist
	 *
	 * @author Michael
	 * @param $meldung Array
	 *        	mit Meldungen
	 * @param $datei String
	 *        	der angibt welche Datei aus der Konfiguration beschrieben werden soll (Bsp: "app_import_schlepper_logfile")
	 */
	private static function schreibeLog($meldungen, $datei) {
		$handle = fopen ( sfConfig::get ( $datei ), 'a' );
		if ($handle) {
			foreach ( $meldungen as $key => $meldung ) {
				fwrite ( $handle, "\n\r" . $meldung );
			}
			fclose ( $handle );
		}
	}
	
	/**
	 * Berechnet die erste Kalenderwoche eines Jahres
	 *
	 * @author Joachim
	 * @param $jahr Jahr
	 *        	das betrachtet werden soll
	 */
	public static function erstekw($jahr) {
		$erster = mktime ( 0, 0, 0, 1, 1, $jahr );
		$wtag = date ( 'w', $erster );
		
		if ($wtag <= 4) {
			/*
			 * Donnerstag oder kleiner: auf den Montag zurückrechnen.
			 */
			$montag = mktime ( 0, 0, 0, 1, 1 - ($wtag - 1), $jahr );
		} else {
			/*
			 * auf den Montag nach vorne rechnen.
			 */
			$montag = mktime ( 0, 0, 0, 1, 1 + (7 - $wtag + 1), $jahr );
		}
		return $montag;
	}
	
	/**
	 * Berechnet den ersten Montag einer zu betrachteten Kalenderwoche
	 *
	 * @author Joachim
	 * @param $kw Kalenderwoche
	 *        	die betrachtet werden soll
	 * @param $jahr Jahr
	 *        	das betrachtet werden soll
	 * @return (int) Timestamp eines Montags
	 */
	public static function montagkw($kw, $jahr) {
		$erstermontag = self::erstekw ( $jahr );
		$mon_monat = date ( 'm', $erstermontag );
		$mon_jahr = date ( 'Y', $erstermontag );
		$mon_tage = date ( 'd', $erstermontag );
		
		$tage = ($kw - 1) * 7;
		
		$mondaykw = mktime ( 0, 0, 0, $mon_monat, $mon_tage + $tage, $mon_jahr );
		return $mondaykw;
	}
	
	/**
	 * Macht aus einer Zahl einen String mit zwei Zahlen zur Basis 60 (z.B.
	 * Sekunden ==> Minuten:Sekunden)
	 * mit führender 0 bei Zahlen < 10
	 *
	 * @param int $sekunden        	
	 * @return string Uhrzeit
	 */
	public static function berechneUhrzeit($sekunden) {
		$min = floor ( $sekunden / 60 );
		$sek = $sekunden % 60;
		return ($min < 10 ? "0" . $min : $min) . ':' . ($sek < 10 ? "0" . $sek : $sek);
	}
	
	/**
	 * Diese Funktion gibt die Anzahl der Minuten des jeweiligen Tages zurück.
	 * Das sind normalerweise 1440 Minuten, bei Zeitumstellungen können es jedoch
	 * auch 1380 oder 1550 Minuten sein.
	 *
	 * @param Integer $timestamp
	 *        	- Timestamp des Tages
	 * @return Integer Anzahl Minuten
	 */
	public static function getMinutenProTag($timestamp = null) {
		if ($timestamp == null) {
			$timestamp = time ();
		}
		/*
		 * Wir basteln uns einen Zeitstempel von 00:00:00 Uhr und einen von 23:59:59 Uhr. Aus der Differenz berechnen wir die Anzahl der Minuten. Das geht, weil die date()-Funktion die Zeitumstellung berücksichtigt.
		 */
		$anfang = mktime ( 0, 0, 0, date ( 'm', $timestamp ), date ( 'd', $timestamp ), date ( 'Y', $timestamp ) );
		$ende = mktime ( 23, 59, 59, date ( 'm', $timestamp ), date ( 'd', $timestamp ), date ( 'Y', $timestamp ) );
		
		return round ( (date ( 'U', $ende ) - date ( 'U', $anfang )) / 60 );
	}
	
	/**
	 * Diese Funktion berechnet zu einem Timestamp den Monatsbeginn
	 * z.B.
	 * 1302797371 ( 14.04.2011 um 18:09:31 )
	 * wird zu
	 * 1301608800 (01.04.2011 um 00:00:00 Uhr)
	 *
	 * @author Markus
	 * @return Int Timestamp
	 */
	public static function getErstenTagImMonat($timestamp) {
		$today = getDate ( $timestamp );
		$first_day = getdate ( mktime ( 0, 0, 0, $today ['mon'], 1, $today ['year'] ) );
		
		return $first_day [0];
	}
	
	/**
	 * Diese Funktion berechnet zu einem Timestamp das Monatsende
	 * z.B.
	 * 1302797371 ( 14.04.2011 um 18:09:31 )
	 * wird zu
	 * 1304114400 (30.04.2011 um 00:00:00 Uhr)
	 *
	 * @author Joachim
	 * @return Int Timestamp
	 */
	public static function getLetztenTagImMonat($timestamp) {
		$today = getDate ( $timestamp );
		$last_day = getdate ( mktime ( 0, 0, 0, $today ['mon'], date ( 't', $timestamp ), $today ['year'] ) );
		
		return $last_day [0];
	}
	
	/**
	 * Gibt die erste Sekunde des Tages vom übergegebenen Timestamp zurück
	 *
	 * @author Joachim
	 * @param integer $timestamp
	 *        	Sekunden
	 * @return timestamp
	 *
	 */
	public static function getBeginnDesTages($timestamp) {
		$tag = date ( "d.m.Y", $timestamp );
		return strtotime ( $tag );
	}
	
	/**
	 * Gibt die letzte Sekunde des Tages vom übergegebenen Timestamp zurück
	 *
	 * @author Joachim
	 * @param integer $timestamp
	 *        	Sekunden
	 * @return timestamp
	 *
	 */
	public static function getEndeDesTages($timestamp) {
		$tag = date ( "d.m.Y", $timestamp );
		$tag = $tag . ' 23:59:59';
		return strtotime ( $tag );
	}
}
