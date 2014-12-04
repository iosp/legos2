<?php
function auswahlFilter($zeitauswaehler = "Tag", $selectedFahrzeuge = null, $route = "", $zusatz = null, $hinweis = "", $ausgeklappt = true) {
	// Beginn des Auswahlfilters
	$result = auswahlStart ( $route );
	
	// Allgemeine Filter
	$result .= optionDatum ( $zeitauswaehler );
	
	if ($zusatz && in_array ( "Wochentage", $zusatz ))
		$result .= optionWochentage ();
		
		// spezifische Filter für Schlepper
	if ($zusatz && in_array ( "Schlepper", $zusatz )) {
		if (in_array ( "Kontinental", $zusatz ))
			$result .= optionKontinental ();
		if (in_array ( "Verspaetet", $zusatz ))
			$result .= optionVerspaetet ();
		if (in_array ( "Vorgangsart", $zusatz ))
			$result .= optionVorgangsart ();
		if (in_array ( "VorgangsartMultiselect", $zusatz ))
			$result .= optionVorgangsartMultiselect ();
		if (in_array ( "Schleppertyp", $zusatz ))
			$result .= optionSchleppertyp ( $selectedFahrzeuge );
		if (in_array ( "Genauigkeit", $zusatz ))
			$result .= optionGenauigkeit ();
		if (in_array ( "Fahrzeugfilter", $zusatz ) && ! in_array ( "Schleppertyp", $zusatz ))
			$result .= optionFahrzeugfilter ( $selectedFahrzeuge, $zusatz );
		if (in_array ( "Ansicht", $zusatz ))
			$result .= optionAnsicht ();
		if (in_array ( "Airlines", $zusatz ))
			$result .= optionAirlines ();
		if (in_array ( "Stoergruende", $zusatz ))
			$result .= optionStoergruendeSchlepper ();
		if (in_array ( "Kunde", $zusatz ))
			$result .= optionKunde ();
		if (in_array ( "Geloescht", $zusatz ))
			$result .= optionGeloescht ();
		if (in_array ( "Fahrbereit", $zusatz ))
			$result .= optionFahrbereit ();
	}
	// spezifische Filter für Busse
	if ($zusatz && in_array ( "Bus", $zusatz )) {
		if (in_array ( "Fahrzeugfilter", $zusatz ) && ! in_array ( "Bustyp", $zusatz ))
			$result .= optionFahrzeugfilter ( $selectedFahrzeuge, $zusatz );
		if (in_array ( "Auswertungsart", $zusatz ))
			$result .= optionAuswertungsartBusse ();
		if (in_array ( "Bustyp", $zusatz ))
			$result .= optionBustyp ( $selectedFahrzeuge, $zusatz );
		if (in_array ( "MitStoerung", $zusatz ))
			$result .= optionMitStoerung ();
		if (in_array ( "AuswertungsartStoerdauer", $zusatz ))
			$result .= optionAuswertungsartStoerdauerBusse ();
	}
	
	// spezifische Filter für HON
	if ($zusatz && in_array ( "HON", $zusatz )) {
		if (in_array ( "Fahrttyp", $zusatz ))
			$result .= optionFahrttypHON ();
		if (in_array ( "LVG", $zusatz ))
			$result .= optionLVGHON ();
	}
	
	// spezifische Filter für Werkstatt Kunde
	if ($zusatz && in_array ( "WerkstattKunde", $zusatz )) {
		if (in_array ( "Fahrzeugfilter", $zusatz ))
			$result .= optionFahrzeugfilter ( $selectedFahrzeuge, $zusatz );
	}
	
	// spezifische Filter für DUS
	if ($zusatz && in_array ( "DUS", $zusatz )) {
		// TODO: Implementieren
		
		if (in_array ( "Fahrzeugfilter", $zusatz ))
			$result .= optionFahrzeugfilter ( $selectedFahrzeuge, $zusatz );
		if (in_array ( "DusSchlepperAnkunftszeitLimit", $zusatz ))
			$result .= optionDusSchlepperAnkunftszeitLimit ();
	}
	
	// Sonstiges
	
	if ($hinweis != null) {
		$result .= auswahlHinweis ( $hinweis );
	}
	
	// Ende des Auswahlfilters
	$result .= auswahlEnde ( $ausgeklappt );
	return $result;
}

/**
 * Startblock für Filter
 */
function auswahlStart($route) {
	// Definition der div-Container für den Ajax-Aufruf des Form-Start-Tags
	$modulContainer = 'container-modulinhalt';
	$ajaxLoading = 'ajax_loading';
	
	$result = use_helper ( 'Global', 'Javascript' );
	$result .= use_javascript ( 'jquery.min.js' );
	$result .= use_javascript ( 'jquery-ui.custom.min.js' );
	$result .= use_javascript ( 'daterangepicker.jQuery.js' );
	$result .= use_javascript ( 'autowidth.js' ); // Width-Anpassung bei Formular-Labels.
	$result .= use_javascript ( 'auswahlhelper.js' ); // Ausgelagerter JavaScript-Code
	$result .= use_stylesheet ( 'ui.daterangepicker.css' );
	$result .= use_stylesheet ( 'AuswahlHelper.css' );
	$result .= use_stylesheet ( 'jquery-ui-1.8.16.custom.css' );
	$result .= '<div id="auswahlfilter" style="margin-left: -282px;">';
	// Im dev-Modus wird auf AJAX verzichtet und stattdessen die komplette Seite neu geladen.
	// Dadurch können von Symfony die Datenbankabfragen eingesehen werden etc.
	if (sfConfig::get ( 'sf_environment' ) == "dev") 	// Symfony Dev-Modus
	{
		$result .= '<form method="post" action="' . $route . '/id="form">';
	} else 	// Symfony Prod-Modus
	{
		$result .= '<form method="post" action="' . $route . '" onsubmit="
							jQuery.ajax({type:\'POST\',dataType:\'html\',
								data:jQuery(this).serialize(),
								
								success:function(data, textStatus){
											jQuery(\'#' . $modulContainer . '\').html(data);
										},
								beforeSend:function(XMLHttpRequest){
											jQuery(\'#' . $modulContainer . '\').hide();
											jQuery(\'#' . $ajaxLoading . '\').show();
										},
								complete:function(XMLHttpRequest, textStatus){
											jQuery(\'table.daten\').each( function(){
												jQuery(this).make_dataTable();
											});
											jQuery(\'#' . $modulContainer . '\').show();
											jQuery(\'#' . $ajaxLoading . '\').hide();
										},
								url:\'' . $route . '\'
							});
							return false;"
						/id="form">';
	}
	$result .= '<div id="inhalt">';
	return $result;
}

/**
 * Auswahlkomponenten
 */
function optionDatum($zeitauswaehler, $isTaxibot = false) {
	$einzeltag = (in_array ( "Einzeltag", $zeitauswaehler )) ? true : false;
	$tag = (in_array ( "Tag", $zeitauswaehler )) ? true : false;
	$woche = (in_array ( "Woche", $zeitauswaehler )) ? true : false;
	$monat = (in_array ( "Monat", $zeitauswaehler )) ? true : false;
	$uhrzeit = (in_array ( "Uhrzeit", $zeitauswaehler )) ? true : false;
	
	$tab_start = 0;
	if ($einzeltag)
		$tab_start = 4;
	if ($monat)
		$tab_start = 3;
	if ($woche)
		$tab_start = 2;
	if ($tag)
		$tab_start = 1;
	
	$result = $isTaxibot ? '<div id="optionen_header">Selection Filter</div>' : '<div id="optionen_header">Auswahlfilter</div>';
	
	$result .= '<input id="auswahl_von" type="hidden" name="auswahl[von]" style="display: none;" value="">';
	$result .= '<input id="auswahl_bis" type="hidden" name="auswahl[bis]" style="display: none;" value="">';
	$result .= '<input id="auswahl_tab" type="hidden" name="auswahl[tab]" style="display: none;" value="tab' . $tab_start . '">';
	
	// Beginn der Tabs
	$result .= '<div id="tabs">';
	// Liste der Überschriften
	$result .= '<ul>';
	if ($tag)
		$result .= $isTaxibot ? '<li><a href="#tabs-1" id = "tab1">Date</a></li>' : '<li><a href="#tabs-1" id = "tab1">Datum</a></li>';
	if ($einzeltag)
		$result .= $isTaxibot ? '<li><a href="#tabs-4" id = "tab4">Date</a></li>' : '<li><a href="#tabs-4" id = "tab4">Datum</a></li>';
	if ($woche)
		$result .= $isTaxibot ? '<li><a href="#tabs-2" id = "tab2">Week</a></li>' : '<li><a href="#tabs-2" id = "tab2">Kalenderwoche</a></li>';
	if ($monat)
		$result .= $isTaxibot ? '<li><a href="#tabs-3" id = "tab3">Month</a></li>' : '<li><a href="#tabs-3" id = "tab3">Monat</a></li>';
	$result .= '</ul>';
	
	// Tabinhalte
	$result .= '<div class="optionen_block">';
	
	$result .= $isTaxibot ? '<div class="optionen_title">Period Selection</div>' : '<div class="optionen_title">Zeitraumauswahl</div>';
	if ($tag)
		$result .= optionDatumTag ();
	if ($woche)
		$result .= optionDatumWoche ();
	if ($monat)
		$result .= optionDatumMonat ();
	if ($einzeltag)
		$result .= optionDatumEinzeltag ();
	if ($uhrzeit)
		$result .= optionDatumUhrzeit ();
	$result .= '</div>';
	return $result;
}
function optionDatumTag() {
	$gestern = date ( "d.m.Y", strtotime ( '-1 day' ) );
	$result = '<div id="tabs-1">';
	$result .= '<div class="optionen_zeitauswahl">';
	$result .= '<input id="auswahl_tag_von" ' . 'class="daterange" ' . 'type="text" ' . 'name="auswahl[tag_von]" ' . 'title="Bitte geben Sie das Von-Datum ein." ' . 'value="gestern" ' . 'size="12" ' . 'onChange="validateVon(this, \'' . $gestern . '\')" ' . 'style="display: inline;">';
	$result .= '&nbsp;';
	$result .= '<input id="auswahl_tag_bis" ' . 'class="daterange" ' . 'type="text" ' . 'name="auswahl[tag_bis]" ' . 'title="Bitte geben Sie das Bis-Datum ein." ' . 'value="" ' . 'size="12" ' . 'onChange="validateBis(this, \'' . $gestern . '\')" ' . 'style="display: inline;">';
	$result .= '</div>';
	$result .= '<script type="text/javascript" charset="utf-8">';
	$result .= "jQuery('#auswahl_tag_von, #auswahl_tag_bis').daterangepicker( {
							dateFormat: 'dd.mm.yy',
							presetRanges: [
								{text: 'Gestern', dateStart: 'yesterday', dateEnd: 'yesterday'},
								{text: 'Letzte 7 Tage', dateStart: 'yesterday-7days', dateEnd: 'yesterday'},
								{text: 'Monat bis gestern', dateStart: function(){ return Date.parse('today').moveToFirstDayOfMonth();  }, dateEnd: 'yesterday' }
							],
							presets: {
								specificDate: 'Datum',
								dateRange: 'Zeitraum'
							},
							posX:7,
							posY:252,
							rangeStartTitle: 'Von',
							rangeEndTitle: 'Bis',
							doneButtonText: 'OK',
							datepickerOptions: {
								showOtherMonths: 'true',
								selectOtherMonths: 'true',
								closeText: 'schließen',
								prevText: '&#x3c; zurück',
								nextText: 'Vor &#x3e;',
								currentText: 'heute',
								monthNames: ['Januar','Februar','März','April','Mai','Juni',
									'Juli','August','September','Oktober','November','Dezember'],
								monthNamesShort: ['Jan','Feb','Mär','Apr','Mai','Jun',
									'Jul','Aug','Sep','Okt','Nov','Dez'],
								dayNames: ['Sonntag','Montag','Dienstag','Mittwoch','Donnerstag','Freitag','Samstag'],
								dayNamesShort: ['So','Mo','Di','Mi','Do','Fr','Sa'],
								dayNamesMin: ['So','Mo','Di','Mi','Do','Fr','Sa'],
								weekHeader: 'Wo',
								firstDay: 1
							}
						} ); ";
	$result .= '</script>';
	$result .= '</div>';
	return $result;
}
function optionDatumEinzeltag() {
	$gestern = date ( "d.m.Y", strtotime ( '-1 day' ) );
	$result = '<div id="tabs-4">';
	$result .= '<div class="optionen_zeitauswahl">';
	$result .= '<input id="auswahl_tag_einzeln" class="daterange" type="text" name="auswahl[tag_einzeln]" title="Bitte geben Sie das Datum ein." value="gestern" size="12" onChange="validateVon(this, \'' . date ( "d.m.Y", strtotime ( '-1 day' ) ) . '\')" style="display: inline;">';
	$result .= '</div>';
	$result .= '<script type="text/javascript" charset="utf-8">';
	$result .= "jQuery('#auswahl_tag_einzeln').daterangepicker( {
							dateFormat: 'dd.mm.yy',
							presetRanges: [
								{text: 'Gestern', dateStart: 'yesterday', dateEnd: 'yesterday'}
							],
							presets: {
								specificDate: 'Datum'
							},
							posX:7,
							posY:252,
							doneButtonText: 'OK',
							datepickerOptions: {
								showOtherMonths: 'true',
								selectOtherMonths: 'true',
								closeText: 'schließen',
								prevText: '&#x3c; zurück',
								nextText: 'Vor &#x3e;',
								currentText: 'heute',
								monthNames: ['Januar','Februar','März','April','Mai','Juni',
									'Juli','August','September','Oktober','November','Dezember'],
								monthNamesShort: ['Jan','Feb','Mär','Apr','Mai','Jun',
									'Jul','Aug','Sep','Okt','Nov','Dez'],
								dayNames: ['Sonntag','Montag','Dienstag','Mittwoch','Donnerstag','Freitag','Samstag'],
								dayNamesShort: ['So','Mo','Di','Mi','Do','Fr','Sa'],
								dayNamesMin: ['So','Mo','Di','Mi','Do','Fr','Sa'],
								weekHeader: 'Wo',
								firstDay: 1
							}
						} ); ";
	$result .= '</script>';
	$result .= '</div>';
	return $result;
}
function optionDatumWoche() {
	$legos_startjahr = 2005;
	$jahre = range ( $legos_startjahr, date ( 'Y' ) );
	$jahre = array_combine ( $jahre, $jahre );
	$kalenderwochen = array_combine ( range ( 1, 52 ), range ( 1, 52 ) );
	
	$result = '<div id="tabs-2">';
	// Formularfelder "normal" posten
	$result .= '<label for="auswahl_kw_von" class="autowidth_kw_kw">Von KW:</label>';
	$result .= select_tag ( 'auswahl[kw_von]', options_for_select ( $kalenderwochen ), array (
			'id' => 'auswahl_kw_von' 
	) );
	$result .= '&nbsp;<label for="auswahl_jahr_kw_von" class="autowidth_kw_jahr">im Jahr:</label>';
	$result .= select_tag ( 'auswahl[jahr_kw_von]', options_for_select ( $jahre, date ( "Y" ) ), array (
			'id' => 'auswahl_jahr_kw_von' 
	) );
	$result .= '<br />';
	$result .= '<label for="auswahl_kw_bis" class="autowidth_kw_kw">Bis KW:</label>';
	$result .= select_tag ( 'auswahl[kw_bis]', options_for_select ( $kalenderwochen, date ( "W" ) ), array (
			'id' => 'auswahl_kw_bis' 
	) );
	$result .= '&nbsp;<label for="auswahl_jahr_kw_bis" class="autowidth_kw_jahr">im Jahr:</label>';
	$result .= select_tag ( 'auswahl[jahr_kw_bis]', options_for_select ( $jahre, date ( "Y" ) ), array (
			'id' => 'auswahl_jahr_kw_bis' 
	) );
	$result .= '</div>';
	return $result;
}

/**
 * Erstellt einen Uhrzeitslider.
 * Anzeige des von-bis Zeitfensters
 *
 * @return auswahl[uhrzeit_von] in ms, auswahl[uhrzeit_bis] in ms
 */
function optionDatumUhrzeit() {
	$result = '<div class="optionen optionen_auswahl_uhrzeit" >';
	$result .= '<div id="auswahl_uhrzeit" class="liste auswahloption">';
	$result .= '<div class="auswahl_uhrzeit_slider"></div>
				<div id="auswahl_uhrzeit_text">Zeitfenster: </div>';
	$result .= input_hidden_tag ( 'auswahl[uhrzeit_von]', '0', array (
			'id' => 'auswahl_uhrzeit_von' 
	) );
	$result .= input_hidden_tag ( 'auswahl[uhrzeit_bis]', '86400', array (
			'id' => 'auswahl_uhrzeit_bis' 
	) );
	$result .= '</div>';
	$result .= '</div>';
	return $result;
}
function optionDatumMonat() {
	$legos_startjahr = 2005;
	$jahre = range ( $legos_startjahr, date ( 'Y' ) );
	$jahre = array_combine ( $jahre, $jahre );
	$monate_namen = array (
			'Januar',
			'Februar',
			'März',
			'April',
			'Mai',
			'Juni',
			'Juli',
			'August',
			'September',
			'Oktober',
			'November',
			'Dezember' 
	);
	$monate = array_combine ( range ( 0, 11 ), $monate_namen );
	
	$result = '<div id="tabs-3">';
	// Formularfelder "normal" posten
	$result .= '<label for="auswahl_monat_von" class="autowidth_monat_monat">Von:</label>';
	$result .= select_tag ( 'auswahl[monat_von]', options_for_select ( $monate ), array (
			'id' => 'auswahl_monat_von' 
	) );
	$result .= '&nbsp;<label for="auswahl_jahr_monat_von" class="autowidth_monat_jahr">im Jahr:</label>';
	$result .= select_tag ( 'auswahl[jahr_monat_von]', options_for_select ( $jahre, date ( "Y" ) ), array (
			'id' => 'auswahl_jahr_monat_von' 
	) );
	$result .= '<br />';
	$result .= '<label for="auswahl_monat_bis" class="autowidth_monat_monat">Bis:</label>';
	$result .= select_tag ( 'auswahl[monat_bis]', options_for_select ( $monate, date ( "m" ) - 1 ), array (
			'id' => 'auswahl_monat_bis' 
	) );
	$result .= '&nbsp;<label for="auswahl_jahr_monat_bis" class="autowidth_monat_jahr">im Jahr:</label>';
	$result .= select_tag ( 'auswahl[jahr_monat_bis]', options_for_select ( $jahre, date ( "Y" ) ), array (
			'id' => 'auswahl_jahr_monat_bis' 
	) );
	$result .= '</div>';
	return $result;
}

// Definition der sonstigen Auswahlarten
function _textfeld($field, $label = '', $value = '') {
	$result = '<div class="optionen_block">';
	$result .= '<div class="optionen_title">';
	$result .= '' . $label . '';
	$result .= '</div>';
	$result .= '<div class="optionen">';
	$result .= '<div id="' . $field . '" class="liste auswahloption textfeld">';
	$result .= input_tag ( 'auswahl[' . $field . ']', $value, array () );
	$result .= '</div>';
	$result .= '</div>';
	$result .= '</div>';
	return $result;
}
function _zahlenfeld($field, $label = '', $value = '') {
	$result = '<div class="optionen_block">';
	$result .= '<div class="optionen_title">';
	$result .= $label;
	$result .= '</div>';
	$result .= '<div class="optionen">';
	$result .= '<div id="' . $field . '" class="liste auswahloption zahlenfeld">';
	$result .= input_tag ( 'auswahl[' . $field . ']', $value, array (
			'class' => 'auswahlZahl' 
	) );
	$result .= '</div>';
	$result .= '</div>';
	$result .= '</div>';
	return $result;
}
function _checkbox($field, $label = '', $array, $selected_array) {
	$result = '<div class="optionen_block">';
	$result .= '<div class="optionen_title">';
	$result .= $label;
	$result .= '</div>';
	$result .= '<div class="optionen">';
	$result .= '<div id="' . $field . '" class="liste auswahloption checkbox">';
	foreach ( $array as $key => $value ) {
		$result .= checkbox_tag ( 'auswahl[' . $field . '][]', $key, in_array ( $key, $selected_array ) ) . '<label for="auswahl_' . $field . '_' . $key . '">' . $value . '</label>';
	}
	$result .= '</div>';
	$result .= '</div>';
	$result .= '</div>';
	return $result;
}
function _radiobutton($field, $label = '', $array, $selected_array) {
	$result = '<div class="optionen_block">';
	$result .= '<div class="optionen_title">';
	$result .= $label;
	$result .= '</div>';
	$result .= '<div class="optionen">';
	$result .= '<div id="' . $field . '" class="liste auswahloption radiobutton">';
	foreach ( $array as $key => $value ) {
		$result .= radiobutton_tag ( 'auswahl[' . $field . ']', $key, in_array ( $key, $selected_array ) ) . '<label for="auswahl_' . $field . '_' . $key . '">' . $value . '</label>';
	}
	$result .= '</div>';
	$result .= '</div>';
	$result .= '</div>';
	return $result;
}

/**
 * Checks if a value exists in an array.
 * Angepasst auch auf Integer-Werte
 * 
 * @link http://www.php.net/manual/en/function.in-array.php
 * @see http://www.php.net/manual/de/function.in-array.php#89256
 * @param
 *        	<b>needle</b> mixed - The searched value. Needle could be string, int and is not case-sensitive.
 * @param
 *        	<b>haystack</b> array - The array.
 * @return bool true if needle is found in the array,
 *         false otherwise.
 */
function in_array_custom($needle, $haystack) {
	return in_array ( strtolower ( $needle ), array_map ( 'strtolower', $haystack ) );
}
function _modalMultiselect($fieldname, $label = '', $objekte, $selected = null, $fieldvalue = 'Alle') {
	if ($selected)
		$fieldvalue = implode ( ',', $selected );
	$result = '<div class="optionen_block">';
	$result .= use_javascript ( 'jquery.multi-select.js' );
	$result .= use_stylesheet ( 'ui.multi-select.css' );
	$result .= '<div class="optionen_title">';
	$result .= $label;
	$result .= '</div>';
	$result .= '<div class="optionen">';
	$result .= input_tag ( 'auswahl[' . $fieldname . ']', $fieldvalue );
	$result .= '</div>';
	$result .= '<div class="clear"></div>';
	$result .= '<div id="dialog_' . $fieldname . '" title="' . $label . '">';
	$result .= '<select id="multiselect_' . $fieldname . '" class="multiselect" multiple="multiple" name="auswahl[2' . $fieldname . '][]">';
	foreach ( $objekte as $key => $value ) {
		$setSelected = (in_array_custom ( $key, $selected )) ? ' selected="selected"' : '';
		$result .= '<option value="' . $key . '"' . $setSelected . '>' . $value . '</option>';
	}
	$result .= '</select>';
	$result .= '<div class="ms-select-all">';
	$result .= "<a href='#' id='select-all_" . $fieldname . "' class='pfeil'>Alle auswählen</a>";
	$result .= '</div>';
	$result .= '<div class="ms-deselect-all">';
	$result .= "<a href='#' id='deselect-all_" . $fieldname . "' class='pfeil'>Alle abwählen</a>";
	$result .= '</div>';
	$result .= '</div></div>';
	return $result;
}
function _modalSelectable($fieldname, $label = '', $objekte) {
	$result = '<div class="optionen_block">';
	$result .= '<div class="optionen_title">';
	$result .= $label;
	$result .= '</div>';
	$result .= '<div class="optionen">';
	$result .= input_tag ( 'auswahl[' . $fieldname . ']', 'Alle' );
	$result .= '</div>';
	$result .= '<div class="clear"></div>';
	$result .= '<div id="dialog_' . $fieldname . '" title="' . $label . '">';
	$result .= '<p id="feedback_' . $fieldname . '" style="display:none">';
	$result .= '<span id="select-result_' . $fieldname . '"></span>';
	$result .= '</p>';
	$result .= '<ol id="selectable">';
	foreach ( $objekte as $key => $value ) {
		$result .= '<li id="' . $key . '" class="ui-widget-content ui-state-default" style="float:left">' . $value . '</li>';
	}
	$result .= '</ol>';
	$result .= '</div></div>';
	return $result;
}

// Optionsfelder definieren
function optionVorgangsart() {
	// $vorgangsarten_array = array();
	// $vorgangsarten = SchleppvorgangVorgangsartPeer::doSelect( new Criteria() );
	// foreach( $vorgangsarten as $art )
	// {
	// $vorgangsarten_array[ strtolower( $art->getName() ) ] = $art;
	// }
	$vorgangsarten_array = array (
			'bereitstellung' => 'Bereitstellung',
			'abzug' => 'Abzug',
			'pushback' => 'Pushback',
			'rangieren' => 'Rangieren' 
	);
	$selected = array (
			'bereitstellung' 
	);
	$result = _radiobutton ( 'vorgangsart', 'Vorgangsarten', $vorgangsarten_array, $selected );
	return $result;
}
function optionVorgangsartMultiselect() {
	$array = array (
			'bereitstellung' => 'Bereitstellung',
			'abzug' => 'Abzug',
			'pushback' => 'Pushback' 
	);
	// 'rangieren'=>'Rangieren' ); // Rangieren ist in der ursprünglichen Form nicht enthalten
	$selected = array (
			'bereitstellung' 
	);
	$result = _checkbox ( 'vorgangsart', 'Vorgangsarten', $array, $selected );
	return $result;
}
function optionAuswertungsartBusse() {
	$auswertungsarten = CSVBusdatenVorgangsartKategoriePeer::doSelect ( new Criteria () );
	$array = array ();
	$selected = array ();
	foreach ( $auswertungsarten as $auswertung ) {
		$array [$auswertung->getId ()] = $auswertung->getBezeichnung ();
		$selected [] = $auswertung->getId ();
	}
	$result = _checkbox ( 'auswertungsart', 'Auswertungsart', $array, $selected );
	return $result;
}
function optionAuswertungsartStoerdauerBusse() {
	$auswertungsartenStoerdauer = BusStoerdaueruebersichtAuswertungsartPeer::doSelect ( new Criteria () );
	$array = array ();
	$selected = array ();
	foreach ( $auswertungsartenStoerdauer as $art ) {
		$array [$art->getId ()] = $art->getName ();
		$selected [] = $art->getId ();
	}
	$result = _checkbox ( 'auswertungsartStoerdauer', 'Auswertungsart', $array, $selected );
	return $result;
}
function optionVerspaetet() {
	$array = array (
			'alle' => 'Alle',
			'verspaetete' => 'Verspätete' 
	);
	$selected = array (
			'verspaetete' 
	);
	$result = _radiobutton ( 'verspaetet', 'Verspätet', $array, $selected );
	return $result;
}
function optionMitStoerung() {
	$array = array (
			'alle' => 'Alle',
			'mitStoerung' => 'Mit Störungen' 
	);
	$selected = array (
			'mitStoerung' 
	);
	$result = _radiobutton ( 'mitStoerung', 'Filter', $array, $selected );
	return $result;
}
function optionDusSchlepperAnkunftszeitLimit() {
	$result = _zahlenfeld ( 'limit_low', 'Unteres Limit in Minuten', '-15' );
	$result .= _zahlenfeld ( 'limit_high', 'Oberes Limit in Minuten', '15' );
	return $result;
}
function optionFahrttypHON() {
	$fahrttypen = array (
			'OUT',
			'IN',
			'UM',
			'RDS' 
	);
	$array = array_combine ( $fahrttypen, $fahrttypen );
	$result = _checkbox ( 'fahrttyp', 'Fahrttypen', $array, $fahrttypen );
	return $result;
}
function optionLVGHON() {
	$fieldname = "lvg";
	$label = "LVG";
	// Objektarray bauen aus id und String
	$objekte = array ();
	$c = new Criteria ();
	$c->addSelectColumn ( HONFlugPeer::LVG );
	$c->addGroupByColumn ( HONFlugPeer::LVG );
	foreach ( HONFlugPeer::doSelectStmt ( $c )->fetchAll () as $lvg ) {
		$objekte [$lvg ['LVG']] = $lvg ['LVG'];
	}
	$selected = $objekte;
	$value = join ( ',', $selected );
	$result = _modalMultiselect ( $fieldname, $label, $objekte, $selected, $value );
	$result .= js_modalMultiselect ( $fieldname, $label );
	return $result;
}
function optionWochentage() {
	$wochentage_kurz = array (
			'Mo',
			'Di',
			'Mi',
			'Do',
			'Fr',
			'Sa',
			'So' 
	);
	// $wochentage_kurz = array('Mon', 'Die', 'Mit', 'Don', 'Fre', 'Sam', 'Son');
	// $wochentage_lang = array('Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag', 'Sonntag');
	$array = array_combine ( $wochentage_kurz, $wochentage_kurz );
	$result = _checkbox ( 'wochentage', 'Wochentage', $array, $wochentage_kurz );
	return $result;
}
function optionAnsicht() {
	$array = array (
			'zeiten' => 'Ansicht Zeiten',
			'verantwortlichkeiten' => 'Ansicht Verantwortlichkeiten' 
	);
	$selected = array (
			'zeiten' 
	);
	$result = _radiobutton ( 'ansicht', 'Ansicht', $array, $selected );
	return $result;
}
function optionKontinental() {
	$array = array (
			'kont' => 'kontinental',
			'interkont' => 'interkontinental' 
	);
	$selected = array (
			'kont',
			'interkont' 
	);
	$result = _checkbox ( 'kont', 'Kontinental', $array, $selected );
	return $result;
}
function optionFahrbereit() {
	$array = array (
			'fahrbereite_anzeigen' => 'fahrbereiter Schlepper anzeigen' 
	);
	$selected = array ();
	$result = _checkbox ( 'fahrbereite_anzeigen', 'Anzahl fahrbereiter Schlepper anzeigen', $array, $selected );
	return $result;
}
function optionKunde() {
	return _textfeld ( 'kunde', 'Kunde' );
}
function optionGenauigkeit() {
	return _zahlenfeld ( 'genauigkeit', 'Genauigkeit', '20' );
}
function optionGeloescht() {
	$array = array (
			'alle' => 'Alle anzeigen',
			'geloescht' => 'Gelöschte anzeigen',
			'nicht_geloescht' => 'Nichtgelöschte anzeigen' 
	);
	$selected = array (
			'alle' 
	);
	$result = _radiobutton ( 'geloescht', 'Gelöschte Schlepper', $array, $selected );
	return $result;
}
function optionAirlines() {
	// Array mit Airlines erstellen
	$airline_array = array ();
	$criteria = new Criteria ();
	$criteria->addAscendingOrderByColumn ( AirlinePeer::NAME );
	$airlines = AirlinePeer::doSelect ( $criteria );
	foreach ( $airlines as $airline ) {
		$airline_array [$airline->getName ()] = $airline->getName ();
	}
	
	$fieldname = "airlines";
	$label = "Airlines";
	
	$result = _modalMultiselect ( $fieldname, $label, $airline_array, array (
			'LH',
			'DE' 
	) );
	$result .= js_modalMultiselect ( $fieldname, $label );
	return $result;
}
function optionStoergruendeSchlepper() {
	// Array mit Auswertungsarten erstellen
	$auswertungsarten_array = array ();
	$auswertungsarten = SchleppvorgangStoergrundPeer::doSelect ( new Criteria () );
	foreach ( $auswertungsarten as $art ) {
		$auswertungsarten_array [$art->getID ()] = $art;
	}
	$fieldname = "stoergruende";
	$label = "Störgründe";
	
	$result = _modalMultiselect ( $fieldname, $label, $auswertungsarten_array, array (
			'6',
			'41' 
	) );
	$result .= js_modalMultiselect ( $fieldname, $label );
	return $result;
}
function optionFahrzeugfilter($fahrzeuge, $zusatz) {
	$selected = null;
	if ($zusatz) {
		if (in_array ( "Schlepper", $zusatz )) {
			$crit_schlepperreihenfolge = new Criteria ();
			$crit_schlepperreihenfolge->addAscendingOrderByColumn ( TaxibotTractorPeer::ID );
			if ($fahrzeuge == null) {
				$fahrzeuge = TaxibotTractorPeer::doSelect ( $crit_schlepperreihenfolge );
			}
			$selected = TaxibotTractorPeer::doSelect ( $crit_schlepperreihenfolge );
		} elseif (in_array ( "Bus", $zusatz )) {
			$crit_busreihenfolge = new Criteria ();
			$crit_busreihenfolge->addAscendingOrderByColumn ( BusPeer::INFOMAN_ID );
			if ($fahrzeuge == null) {
				$fahrzeuge = BusPeer::doSelect ( $crit_busreihenfolge );
			}
			$selected = BusPeer::doSelectAktiveBusse ( $crit_busreihenfolge );
		} elseif (in_array ( "WerkstattKunde", $zusatz )) {
			$crit_schlepperreihenfolge = new Criteria ();
			$crit_schlepperreihenfolge->addAscendingOrderByColumn ( WerkstattKundeFahrzeugPeer::NAME );
			if ($fahrzeuge == null) {
				$fahrzeuge = WerkstattKundeFahrzeugPeer::doSelect ( $crit_schlepperreihenfolge );
			}
			$selected = $fahrzeuge;
		} elseif (in_array ( "DUS", $zusatz )) {
			$crit_schlepperreihenfolge = new Criteria ();
			$crit_schlepperreihenfolge->addAscendingOrderByColumn ( DusSchlepperPeer::NAME );
			if ($fahrzeuge == null) {
				$fahrzeuge = DusSchlepperPeer::doSelectAktiveSchlepper ( $crit_schlepperreihenfolge );
			}
			$selected = $fahrzeuge;
		}
	}
	
	$fieldname = "fahrzeugFilter";
	$label = "Fahrzeugauswahl";
	// Objektarray bauen aus id und String
	$objekte = array ();
	foreach ( $fahrzeuge as $key => $fahrzeug ) {
		$objekte [$fahrzeug->getName ()] = $fahrzeug->getName ();
	}
	$result = _modalMultiselect ( $fieldname, $label, $objekte, $selected );
	$result .= js_modalMultiselect ( $fieldname, $label );
	return $result;
}
function optionSchleppertyp($fahrzeuge = null, $selectedSchleppertyp = null, $genauigkeit = '20') {
	// Array mit Schleppertypen für die Select-Box erstellen :
	$crit_schleppertyp = new Criteria ();
	$crit_schleppertyp->addAscendingOrderByColumn ( SchlepperTypPeer::HERSTELLER );
	$crit_schleppertyp->addAscendingOrderByColumn ( SchlepperTypPeer::MODELL );
	$schleppertyps = SchlepperTypPeer::doSelect ( $crit_schleppertyp );
	$schleppertyp_select_array = array ();
	foreach ( $schleppertyps as $schleppertyp ) {
		$schleppertyp_select_array [$schleppertyp->getId ()] = $schleppertyp->getHersteller () . ' ' . $schleppertyp->getModell ();
	}
	
	$result = '<div class="optionen_block">';
	$result .= '<div class="optionen_title">';
	$result .= 'Schleppertypen';
	$result .= '</div>';
	$result .= '<div class="optionen">';
	$result .= '<div id="schleppertyp" class="liste">';
	// TODO: umbiegen, dass der Fahrzeugfilter verwendet werden kann
	$result .= select_tag ( 'auswahl[Schleppertyp]', options_for_select ( $schleppertyp_select_array, $selectedSchleppertyp, 	// Defaultwert
	array (
			'include_custom' => 'Alle' 
	) ), 	// den Punkt 'Alle' mit hinzunehmen
	array (
			'onChange' => 'if(this.value != ""){auswahl_fahrzeugFilter.value="Alle";}' 
	) )	// Wenn ein Schleppertyp ausgewählt wird, die Schlepperauswahl zurücksetzen.
	;
	// $result.= include_component(
	// 'startseite', 'schlepperAuswaehlen',
	// array( 'benutzerdefinierteWerte' => array(
	// array('include_custom' => 'Alle'),
	// array( 'onChange' => 'if(this.value != ""){auswahl_fahrzeugFilter.value="Alle";}') ),
	// // Wenn ein Schlepper ausgewählt wird, die Schleppertyp-Auswahl zurücksetzen.
	// 'geloeschte_anzeigen' => true )
	// ); // Die Component macht sein eigenes <th> und <td>
	$result .= '</div>';
	$result .= '</div>';
	$result .= '</div>';
	$result .= '<div class="optionen_block">';
	$result .= '<div class="optionen_title">';
	$result .= 'Fahrzeugauswahl';
	$result .= '</div>';
	$result .= '<div class="optionen">';
	$result .= input_tag ( 'auswahl[fahrzeugFilter]', 'Alle' );
	$result .= '</div>';
	$result .= '<div class="clear"></div>';
	$result .= '<div id="dialog" title="Fahrzeugauswahl">';
	$result .= '<p id="feedback" style="display:none">';
	$result .= '<span id="select-result"></span>';
	$result .= '</p>';
	$result .= '<ol id="selectable">';
	foreach ( $fahrzeuge as $fahrzeug ) {
		$result .= '<li class="ui-widget-content ui-state-default" style="float:left">' . $fahrzeug->getName () . '</li>';
	}
	$result .= '</ol>';
	$result .= '</div>';
	$result .= '</div>';
	return $result;
}

/**
 * Endblock für Filter
 */
function auswahlHinweis($hinweis = "") {
	$result = '<div class="optionen_block">';
	$result .= '<div class="optionen_title">';
	$result .= 'Hinweise';
	$result .= '</div>';
	$result .= '<div class="optionen">';
	$result .= $hinweis;
	$result .= '</div>';
	$result .= '</div>';
	return $result;
}
function auswahlEnde($ausgeklappt = false) {
	$result = '<div class="option_actionbuttons">';
	$result .= submit_tag ( 'Absenden', array (
			'class' => 'abfragebutton' 
	) );
	$result .= '</div>';
	$result .= '</div>'; // Ende class="optionen_block"
	$result .= '</div>'; // //Ende id="tabs-?"
	$result .= '<div id="fahne">';
	$result .= '<br/><br/><br/>';
	$result .= image_tag ( 'pin_fahne_optionen_geschlossen.png', array (
			'width' => '25',
			'id' => 'pin_geschlossen' 
	) );
	$result .= image_tag ( 'pin_fahne_optionen_offen.png', array (
			'width' => '25',
			'id' => 'pin_offen' 
	) );
	$result .= '</div>';
	$result .= form_end_tag ();
	$result .= '</div>';
	return $result;
}

/**
 * Erstellt den Javascriptcode um den JQuery-Mehrfachauswähler zu erstellen.
 *
 *
 * @param $fieldname Feldname        	
 * @param $label Klartext        	
 */
function js_modalMultiselect($fieldname, $label) {
	$result = "<script type='text/javascript'>
		(function($){ $(function() {";
	// Dialog mit den Buttons definieren
	$result .= "$( \"#dialog_$fieldname\" ).dialog({
				autoOpen: false,
				closeOnEscape: false, // Nicht selbst per Esc schließen lassen, weil uns das den Escape-Knopf vom Auswahlfilter zerstört.
				modal: true,
				dialogClass: 'dialogButtons',
				width: 500,
				buttons: {
					\"$label übernehmen\": function() {
						jQuery( \"#auswahl_$fieldname\" ).val(jQuery( \"#multiselect_$fieldname\" ).val());
						jQuery( this ).dialog( \"close\" );
					},
					\"Abbrechen\": function() {
						jQuery( this ).dialog( \"close\" );
					}
				},
				close: function() {}
			});";
	
	// Dialog per Click auf das Inputfeld öffnen
	$result .= "$( '#auswahl_$fieldname' ).click(function() {
				jQuery( '#dialog_$fieldname' ).dialog( 'open' );
			});";
	
	// Multisselectfeld definieren
	$result .= "$('#multiselect_$fieldname').multiSelect({
				selectableHeader: '<div class=\'ms-header\'>Verfügbar</div>',
				selectedHeader: '<div class=\'ms-header\'>Ausgewählt</div>',
				keepOrder: true
			});";
	// Links zum Select/Deselect aller Items
	$result .= "$('#select-all_$fieldname').click(function(){
				$('#multiselect_$fieldname').multiSelect('select_all');
				return false;
			});
			$('#deselect-all_$fieldname').click(function(){
				$('#multiselect_$fieldname').multiSelect('deselect_all');
				return false;
			});
		});})(jQuery)
	</script>";
	
	return $result;
}

/**
 * Erstellt den Javascriptcode um den JQuery-Mehrfachauswähler zu erstellen.
 *
 *
 * @param $fieldname Feldname        	
 * @param $label Klartext        	
 * @param $width Breite
 *        	des Dialogs
 * @param $separator String
 *        	zur Trennung der einzelnen Werte
 */
function js_modalSelectable($fieldname, $label, $width, $separator) {
	$result = "<script type='text/javascript'>
			erstes_mal_$fieldname = true;
		(function($){ $(function() {";
	// Auswahlfenster für die $label, Definition der Buttons und der Funktion die bei spreichern ausgeführt wird
	$result .= "$( \"#dialog_$fieldname\" ).dialog({
				autoOpen: false,
				modal: true,
				width: " . $width . ",
				buttons: {
					\"$label auswählen\": function() {
						var result = jQuery( '#select-result_$fieldname' ).text();
						jQuery( \"#auswahl_$fieldname\" ).val(result);
						jQuery( this ).dialog( \"close\" );
					},
					\"Abbrechen\": function() {
						jQuery( this ).dialog( \"close\" );
					}
				},
				close: function() {}
			});";
	
	$result .= "$( '#dialog_$fieldname #selectable' ).selectable({
				stop: function() {
					var result = jQuery( '#select-result_$fieldname' ).empty();
					var anzahl_selected = jQuery( '.ui-selected', this).size();
					var i = 1;
					jQuery( '.ui-selected', this ).each(function() {
						var index = jQuery(this).attr('id');
						if( i < anzahl_selected) {
							result.append( ( index ) + '" . $separator . "' );
						}
						else {
							result.append( ( index ));
						}
					i=i+1;
					});
				}
			});";
	// Beim ersten Aufruf des Dialogs, Standardmässig alle Elemente auswählen
	$result .= "$( '#auswahl_$fieldname' ).click(function() {
				if (erstes_mal_$fieldname !=false) {
					jQuery( '.ui-widget-content').addClass('ui-selected');
				}
				erstes_mal_$fieldname = false;
				
				jQuery( '#dialog_$fieldname' ).dialog( 'open' );

				var result = jQuery( '#select-result_$fieldname' ).empty();
				var anzahl_selected = jQuery( '#dialog_$fieldname .ui-selected').size();
				var i = 1;
				jQuery( '#dialog_$fieldname .ui-selected').each(function() {
					var index = jQuery(this).attr('id');
					if( i < anzahl_selected) {
						result.append( ( index ) + '" . $separator . "' );
					}
					else {
						result.append( ( index ));
					}
					i=i+1;
				});
				return false;
			});
		});})(jQuery)
	</script>";
	
	return $result;
}
?>
