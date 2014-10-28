<?php
$pdfpath = sfConfig::get ( 'sf_web_dir' ) . DIRECTORY_SEPARATOR . 'hilfe' . DIRECTORY_SEPARATOR . 'pdf' . DIRECTORY_SEPARATOR;
function linkPDF($path, $filename) {
	if (file_exists ( $path . $filename ) && sfContext::getInstance ()->getUser ()->hasCredential ( substr ( $filename, 0, - 4 ) )) 	// Dateiname ist gleich Credential
	{
		return link_to ( image_tag ( 'icons/page_white_acrobat.png', array (
				'size' => '16x16',
				'alt' => 'PDF-Export',
				'title' => 'PDF-Export',
				'border' => '0' 
		) ), 'anwenderhandbuch/download', array (
				'query_string' => 'pdf=' . $filename 
		) );
	}
}

$bus = array ();
$bus [] = array (
		'name' => 'Aktivität',
		'datum' => '2012-08-15',
		'pdf' => 'bus-aktivitaet.pdf' 
);
$bus [] = array (
		'name' => 'Auftragexport',
		'datum' => '2012-08-15',
		'pdf' => 'bus-busauftragexport.pdf' 
);
$bus [] = array (
		'name' => 'Fahrtenexport',
		'datum' => '2012-12-06',
		'pdf' => 'bus-fahrtenexport.pdf' 
);
$bus [] = array (
		'name' => 'Auslastung',
		'datum' => '2012-08-15',
		'pdf' => 'bus-auslastung.pdf' 
);
$bus [] = array (
		'name' => 'Datenexport',
		'datum' => '2012-08-15',
		'pdf' => 'bus-busdatenexport.pdf' 
);
$bus [] = array (
		'name' => 'Fahrtenübersicht',
		'datum' => '2012-08-15',
		'pdf' => 'bus-fahrtenuebersicht.pdf' 
);
$bus [] = array (
		'name' => 'Kilometerstandauswertung',
		'datum' => '2012-08-15',
		'pdf' => 'bus-kilometerstandauswertung.pdf' 
);
$bus [] = array (
		'name' => 'Stördauerübersicht',
		'datum' => '2012-08-15',
		'pdf' => 'bus-stoerdaueruebersicht.pdf' 
);

$schlepper = array ();
$schlepper [] = array (
		'name' => 'Aktivität',
		'datum' => '2012-08-15',
		'pdf' => 'schlepper-aktivitaet.pdf' 
);
$schlepper [] = array (
		'name' => 'Auslastung',
		'datum' => '2012-08-15',
		'pdf' => 'schlepper-auslastung.pdf' 
);
$schlepper [] = array (
		'name' => 'Betriebsstundenauswertung',
		'datum' => '2012-08-15',
		'pdf' => 'schlepper-betriebsstundenstandauswertung.pdf' 
);
$schlepper [] = array (
		'name' => 'ExportSE',
		'datum' => '2012-08-15',
		'pdf' => 'schlepper-exportse.pdf' 
);
$schlepper [] = array (
		'name' => 'Gesamtexport',
		'datum' => '2012-08-15',
		'pdf' => 'schlepper-gesamtexport.pdf' 
);
$schlepper [] = array (
		'name' => 'Nachbearbeitung',
		'datum' => '2012-08-15',
		'pdf' => 'schlepper-nachbearbeitung.pdf' 
);
$schlepper [] = array (
		'name' => 'Schlepp- und Stördauer',
		'datum' => '2012-08-15',
		'pdf' => 'schlepper-schleppundstoerdauer.pdf' 
);
$schlepper [] = array (
		'name' => 'Selbsterledigte Störgründe',
		'datum' => '2012-08-15',
		'pdf' => 'schlepper-selbsterledigtestoergruende.pdf' 
);
$schlepper [] = array (
		'name' => 'Störungsauswertung',
		'datum' => '2012-08-15',
		'pdf' => 'schlepper-stoerungsauswertung.pdf' 
);
$schlepper [] = array (
		'name' => 'Verspätungsübersicht',
		'datum' => '2012-08-15',
		'pdf' => 'schlepper-verspaetungsuebersicht.pdf' 
);

$werkstatt_bus = array ();
$werkstatt_bus [] = array (
		'name' => 'Auswertung Mängel',
		'datum' => '2012-08-15',
		'pdf' => 'werkstatt_bus-auswertungMaengel.pdf' 
);
$werkstatt_bus [] = array (
		'name' => 'Fahrzeughistorie',
		'datum' => '2012-08-15',
		'pdf' => 'werkstatt_bus-AuswertungFahrzeughistorie.pdf' 
);
$werkstatt_bus [] = array (
		'name' => 'Fahrzeugverwaltung',
		'datum' => '2012-08-15',
		'pdf' => 'werkstatt_bus-Fahrzeugverwaltung.pdf' 
);
$werkstatt_bus [] = array (
		'name' => 'Kennzahlen',
		'datum' => '2012-08-15',
		'pdf' => 'werkstatt_bus-auswertungKennzahlen.pdf' 
);
$werkstatt_bus [] = array (
		'name' => 'Mangeleingabe',
		'datum' => '2012-08-15',
		'pdf' => 'werkstatt_bus-Mangeleingabe.pdf' 
);
$werkstatt_bus [] = array (
		'name' => 'Übersicht Einsatzleiter',
		'datum' => '2012-08-15',
		'pdf' => 'werkstatt_bus-UebersichtEinsatzleiter.pdf' 
);
$werkstatt_bus [] = array (
		'name' => 'Übersicht Werkstatt',
		'datum' => '2012-08-15',
		'pdf' => 'werkstatt_bus-UebersichtWerkstatt.pdf' 
);
$werkstatt_bus [] = array (
		'name' => 'Wartungsartverwaltung',
		'datum' => '2012-08-15',
		'pdf' => 'werkstatt_bus-Wartungsartverwaltung.pdf' 
);
$werkstatt_bus [] = array (
		'name' => 'Wartungsterminverwaltung',
		'datum' => '2012-08-15',
		'pdf' => 'werkstatt_bus-Wartungsterminverwaltung.pdf' 
);

$werkstatt_schlepper = array ();
$werkstatt_schlepper [] = array (
		'name' => 'Auswertung Mängel',
		'datum' => '2012-08-15',
		'pdf' => 'werkstatt_schlepper-auswertungMaengel.pdf' 
);
$werkstatt_schlepper [] = array (
		'name' => 'Fahrzeughistorie',
		'datum' => '2012-08-15',
		'pdf' => 'werkstatt_schlepper-AuswertungFahrzeughistorie.pdf' 
);
$werkstatt_schlepper [] = array (
		'name' => 'Fahrzeugverwaltung',
		'datum' => '2012-08-15',
		'pdf' => 'werkstatt_schlepper-Fahrzeugverwaltung.pdf' 
);
$werkstatt_schlepper [] = array (
		'name' => 'Kennzahlen',
		'datum' => '2012-08-15',
		'pdf' => 'werkstatt_schlepper-auswertungKennzahlen.pdf' 
);
$werkstatt_schlepper [] = array (
		'name' => 'Mangeleingabe',
		'datum' => '2012-08-15',
		'pdf' => 'werkstatt_schlepper-Mangeleingabe.pdf' 
);
$werkstatt_schlepper [] = array (
		'name' => 'Übersicht Einsatzleiter',
		'datum' => '2012-08-15',
		'pdf' => 'werkstatt_schlepper-UebersichtEinsatzleiter.pdf' 
);
$werkstatt_schlepper [] = array (
		'name' => 'Übersicht Werkstatt',
		'datum' => '2012-08-15',
		'pdf' => 'werkstatt_schlepper-UebersichtWerkstatt.pdf' 
);
$werkstatt_schlepper [] = array (
		'name' => 'Wartungsartverwaltung',
		'datum' => '2012-08-15',
		'pdf' => 'werkstatt_schlepper-Wartungsartverwaltung.pdf' 
);
$werkstatt_schlepper [] = array (
		'name' => 'Wartungsterminverwaltung',
		'datum' => '2012-08-15',
		'pdf' => 'werkstatt_schlepper-Wartungsterminverwaltung.pdf' 
);

$werkstatt_dus = array ();
$werkstatt_dus [] = array (
		'name' => 'Fahrzeughistorie',
		'datum' => '2012-08-15',
		'pdf' => 'werkstatt_dus-auswertungFahrzeughistorie.pdf' 
);
$werkstatt_dus [] = array (
		'name' => 'Fahrzeugverwaltung',
		'datum' => '2012-08-15',
		'pdf' => 'werkstatt_dus-fahrzeugverwaltung.pdf' 
);
$werkstatt_dus [] = array (
		'name' => 'Mangeleingabe',
		'datum' => '2012-08-15',
		'pdf' => 'werkstatt_dus-mangeleingabe.pdf' 
);
$werkstatt_dus [] = array (
		'name' => 'Übersicht Einsatzleiter',
		'datum' => '2012-08-15',
		'pdf' => 'werkstatt_dus-uebersichtEinsatzleiter.pdf' 
);
$werkstatt_dus [] = array (
		'name' => 'Übersicht Werkstatt',
		'datum' => '2012-08-15',
		'pdf' => 'werkstatt_dus-uebersichtWerkstatt.pdf' 
);
$werkstatt_dus [] = array (
		'name' => 'Wartungsartverwaltung',
		'datum' => '2012-08-15',
		'pdf' => 'werkstatt_dus-wartungsartverwaltung.pdf' 
);
$werkstatt_dus [] = array (
		'name' => 'Wartungsterminverwaltung',
		'datum' => '2012-08-15',
		'pdf' => 'werkstatt_dus-wartungsterminverwaltung.pdf' 
);

$werkstatt_kunde = array ();
$werkstatt_kunde [] = array (
		'name' => 'Auswertung Mängel',
		'datum' => '2012-08-15',
		'pdf' => 'werkstatt_kunde-auswertungMaengel.pdf' 
);
$werkstatt_kunde [] = array (
		'name' => 'Fahrzeughistorie',
		'datum' => '2012-08-15',
		'pdf' => 'werkstatt_kunde-auswertungFahrzeughistorie.pdf' 
);
$werkstatt_kunde [] = array (
		'name' => 'Fahrzeugverwaltung',
		'datum' => '2012-08-15',
		'pdf' => 'werkstatt_kunde-fahrzeugverwaltung.pdf' 
);
$werkstatt_kunde [] = array (
		'name' => 'Kennzahlen',
		'datum' => '2012-08-15',
		'pdf' => 'werkstatt_kunde-auswertungKennzahlen.pdf' 
);
$werkstatt_kunde [] = array (
		'name' => 'Mangeleingabe',
		'datum' => '2012-08-15',
		'pdf' => 'werkstatt_kunde-mangeleingabe.pdf' 
);
$werkstatt_kunde [] = array (
		'name' => 'Übersicht Einsatzleiter',
		'datum' => '2012-08-15',
		'pdf' => 'werkstatt_kunde-uebersichtEinsatzleiter.pdf' 
);
$werkstatt_kunde [] = array (
		'name' => 'Übersicht Werkstatt',
		'datum' => '2012-08-15',
		'pdf' => 'werkstatt_kunde-uebersichtWerkstatt.pdf' 
);
$werkstatt_kunde [] = array (
		'name' => 'Wartungsartverwaltung',
		'datum' => '2012-08-15',
		'pdf' => 'werkstatt_kunde-wartungsartverwaltung.pdf' 
);
$werkstatt_kunde [] = array (
		'name' => 'Wartungsterminverwaltung',
		'datum' => '2012-08-15',
		'pdf' => 'werkstatt_kunde-wartungsterminverwaltung.pdf' 
);

$werkstatt_gesamt = array ();
$werkstatt_gesamt [] = array (
		'name' => 'Übersicht Werkstatt',
		'datum' => '2012-08-15',
		'pdf' => 'werkstatt_gesamt-UebersichtWerkstattGesamt.pdf' 
);

$hon = array ();
$hon [] = array (
		'name' => 'Auslastung',
		'datum' => '2012-08-15',
		'pdf' => 'hon-auslastung.pdf' 
);
$hon [] = array (
		'name' => 'Gästeübersicht',
		'datum' => '2012-08-15',
		'pdf' => 'hon-gaesteuebersicht.pdf' 
);
$hon [] = array (
		'name' => 'Grafische Auswertung',
		'datum' => '2012-08-15',
		'pdf' => 'hon-grafische_auswertung.pdf' 
);
$hon [] = array (
		'name' => 'Fahrtenübersicht',
		'datum' => '2012-08-15',
		'pdf' => 'hon-fahrtenuebersicht.pdf' 
);
$hon [] = array (
		'name' => 'Fahrttypenübersicht',
		'datum' => '2012-08-15',
		'pdf' => 'hon-fahrttypenuebersicht.pdf' 
);
$hon [] = array (
		'name' => 'Nicht durchgeführte Fahrten',
		'datum' => '2012-08-15',
		'pdf' => 'hon-nichtDurchgefuehrtUebersicht.pdf' 
);
$hon [] = array (
		'name' => 'Pünktlichkeit',
		'datum' => '2012-08-15',
		'pdf' => 'hon-puenktlichkeit.pdf' 
);
$hon [] = array (
		'name' => 'Störungsübersicht',
		'datum' => '2012-08-15',
		'pdf' => 'hon-stoerungsuebersicht.pdf' 
);

$dus_schlepper = array ();
$dus_schlepper [] = array (
		'name' => 'Auslastung',
		'datum' => '2012-08-15',
		'pdf' => 'dus_schlepper-abrechnung.pdf' 
);
$dus_schlepper [] = array (
		'name' => 'Auswertung Ankunftszeit',
		'datum' => '2012-08-15',
		'pdf' => 'dus_schlepper-ankunftszeit.pdf' 
);

$verwaltung = array ();
$verwaltung [] = array (
		'name' => 'Benutzerverwaltung',
		'datum' => '2012-08-15',
		'pdf' => 'verwaltung-benutzerverwaltung.pdf' 
);
$verwaltung [] = array (
		'name' => 'Crewbusauslastung',
		'datum' => '2012-08-15',
		'pdf' => 'verwaltung-busauslastung.pdf' 
);
$verwaltung [] = array (
		'name' => 'DUS Flugzeugkategorisierung',
		'datum' => '2012-08-15',
		'pdf' => 'verwaltung-dus_flugzeugkategorisierung.pdf' 
);
$verwaltung [] = array (
		'name' => 'Flugzeugtypverwaltung',
		'datum' => '2012-08-15',
		'pdf' => 'verwaltung-flugzeugtypverwaltung.pdf' 
);
$verwaltung [] = array (
		'name' => 'Flugzeugzuordnung',
		'datum' => '2012-08-15',
		'pdf' => 'verwaltung-flugzeugzuordnung.pdf' 
);
$verwaltung [] = array (
		'name' => 'Gruppenübersicht',
		'datum' => '2012-08-15',
		'pdf' => 'verwaltung-gruppenuebersicht.pdf' 
);
$verwaltung [] = array (
		'name' => 'Gruppenverwaltung',
		'datum' => '2012-08-15',
		'pdf' => 'verwaltung-gruppenverwaltung.pdf' 
);
$verwaltung [] = array (
		'name' => 'Passwort ändern',
		'datum' => '2012-08-15',
		'pdf' => 'verwaltung-passwortaendern.pdf' 
);

$hilfe = array ();
$hilfe [] = array (
		'name' => 'Bus',
		'content' => $bus 
);
$hilfe [] = array (
		'name' => 'Schlepper',
		'content' => $schlepper 
);
$hilfe [] = array (
		'name' => 'Werkstatt Bus',
		'content' => $werkstatt_bus 
);
$hilfe [] = array (
		'name' => 'Werkstatt Schlepper',
		'content' => $werkstatt_schlepper 
);
$hilfe [] = array (
		'name' => 'Werkstatt DUS',
		'content' => $werkstatt_dus 
);
$hilfe [] = array (
		'name' => 'Werkstatt Kunde',
		'content' => $werkstatt_kunde 
);
$hilfe [] = array (
		'name' => 'Werkstatt Gesamt',
		'content' => $werkstatt_gesamt 
);
$hilfe [] = array (
		'name' => 'HON',
		'content' => $hon 
);
$hilfe [] = array (
		'name' => 'DUS Schlepper',
		'content' => $dus_schlepper 
);
$hilfe [] = array (
		'name' => 'Verwaltung',
		'content' => $verwaltung 
);
?>


<table class="normal">
	<thead>
		<tr>
			<th>#</th>
			<th>Anwendung</th>
			<th>Modul</th>
			<th>Datum</th>
			<th>PDF</th>
		</tr>
	</thead>
	<tr class="ungerade clickable_highlighting">
		<td>0.0</td>
		<td>-/-</td>
		<td>Allgemeines Bedienkonzept</td>
		<td>2012-08-15</td>
		<td><?php
		
echo link_to ( image_tag ( 'icons/page_white_acrobat.png', array (
				'size' => '16x16',
				'alt' => 'PDF-Export',
				'title' => 'PDF-Export',
				'border' => '0' 
		) ), 'anwenderhandbuch/download', array (
				'query_string' => 'pdf=LEGOS-Bedienkonzept.pdf' 
		) )?></td>
	</tr>
	<?php
	$a = 0;
	$i = 0;
	foreach ( $hilfe as $app ) {
		$a ++;
		$m = 0;
		foreach ( $app ['content'] as $modul ) {
			// Link nur anzeigen, wenn der User Credentials hat. Der Dateiname entspricht dabei dem Credential.
			if (sfContext::getInstance ()->getUser ()->hasCredential ( substr ( $modul ['pdf'], 0, - 4 ) )) {
				$zeilentyp = (($i % 2) == 0) ? "gerade" : "ungerade";
				$m ++;
				echo '<tr class="' . $zeilentyp . ' clickable_highlighting">';
				echo "<td>" . $a . '.' . $m . "</td>";
				echo "<td>" . $app ['name'] . "</td>";
				echo "<td>" . $modul ['name'] . "</td>";
				echo "<td>" . $modul ['datum'] . "</td>";
				echo "<td>" . linkPDF ( $pdfpath, $modul ['pdf'] ) . "</td>";
				echo "</tr>";
				$i ++;
			}
		}
	}
	?>
	<tfoot>
	</tfoot>
</table>
