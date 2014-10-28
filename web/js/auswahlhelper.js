/**
 * Rechnet Minuten in eine hh:mm Anzeige um Benutzt in AuswahlUhrzeit
 */
function getHourMinutes(minutes) {
	var curr_hour = Math.floor(minutes / 60);
	var curr_min = (minutes - (curr_hour * 60));
	curr_min = curr_min + "";
	if (curr_min.length === 1)
	{
		curr_min = "0" + curr_min;
	}
	var curr_time = curr_hour + ":" + curr_min;
	return curr_time;
}

/**
 * Prüft, ob das eingegebene Datum dd.mm.yyyy formatiert ist Benutzt von
 * js_datum
 * 
 * @param datum als String im Format dd.mm.yyyy
 * @return true, wenn valide formatiertes Datum Benutzt von js_datum
 */
function isValidDate(strDate) {
	var regex = /^([0-3]\d|[1-9])\.([0-3]\d|[1-9])\.(\d{4}|\d{2})$/g;
	if (!regex.exec(strDate)) return false;
	var tmp = new Date(RegExp.$3, RegExp.$2, 0);
	if (tmp.getDate() < RegExp.$1 || RegExp.$2 > 12) return false;
	return true;
}

/**
 * Prüft, ob das eingegebene Datum dd.mm.yyyy formatiert ist Benutzt von
 * js_datum
 * 
 * @param element DOM-Element, input-Feld
 * @param yesterday Datum, dass bei invalidem Format benutzt werden soll
 * @return alert() wenn invalide und setzt den Inhalt des elements auf gestern
 */
function validateVon(element, yesterday) {
	if (!isValidDate(element.value))
	{
		alert('Das eingegebene Datum "' + element.value +
			'" ist nicht gültig. \nBitte geben Sie ein gültiges Datum (dd.mm.yyyy) ein');
		window.setTimeout(function() {
			element.focus();
			element.value = yesterday;
		}, 0);
		return false;
	}
}

/**
 * Prüft, ob das eingegebene Datum dd.mm.yyyy formatiert ist Benutzt von
 * js_datum
 * 
 * @param element DOM-Element, input-Feld
 * @param yesterday Datum, dass bei invalidem Format benutzt werden soll
 * @return alert() wenn invalide und setzt den Inhalt des elements auf gestern
 */
function validateBis(element, yesterday) {
	if (!isValidDate(element.value))
	{
		alert('Das eingegebene Datum "' + element.value +
			'" ist nicht gültig. \nBitte geben Sie ein gültiges Datum (dd.mm.yyyy) ein');
		window.setTimeout(function() {
			element.focus();
			element.value = yesterday;
		}, 0);
		return false;
	}
}

/**
 * Errechnet den Wochentag aus dem 1. Januar eines gegebenen Jahres und der
 * Kalenderwoche das Datum vom Montag dieser KW oder der Sonntag dieser KW,
 * abhängig vom Parameter ende. Benutzt von js_datum
 * 
 * @param kw gewünschte Kalenderwoche
 * @param jahr gewünschte Jahreszahl
 * @param ende wenn true dann wird das Wochenende berechnet
 * @return timestamp Benutzt von js_datum
 */
function timestampAusKw(kw, jahr, ende) {
	// Gültig für Jahre nach 1990, wenn 1.1. = Do, dann 53 KW, sonst 52'
	// DIN EN 28601 (1993)'
	var dt = new Date(jahr, 0, 1);
	var Wochentag = dt.getDay();
	if (Wochentag === 0) Wochentag = 7;
	if (jahr < 1991 || kw < 1 || kw > 53 || (kw > 52 && Wochentag !== 4)) return false;
	if (Wochentag > 4)
		dt.setTime(dt.getTime() + (8 - Wochentag) * 24 * 60 * 60 * 1000);
	else
		dt.setTime(dt.getTime() + (1 - Wochentag) * 24 * 60 * 60 * 1000);
	if (ende === "true")
		dt.setTime(dt.getTime() + (kw) * 7 * 24 * 60 * 60 * 1000 - 1000);
	else
		dt.setTime(dt.getTime() + (kw - 1) * 7 * 24 * 60 * 60 * 1000);
	return dt.getTime();
}

/**
 * Errechnet aus Monat eines gegebenem Jahres und das Datum des Monatsersten
 * oder des Monatsletzen, abhängig vom Parameter ende. Benutzt von js_datum
 * 
 * @param monat gewünschte Kalenderwoche
 * @param jahr gewünschte Jahreszahl
 * @param ende wenn true dann wird das Monatsende berechnet
 * @return timestamp
 */
function timestampAusMonat(monat, jahr, ende) {
	if (ende === "true") monat++;
	var dt = new Date(jahr, monat, 1, 0, 0, 0, 0);
	if (ende === "true") dt.setSeconds(-1);
	return dt.getTime();
}

/**
 * Errechnet aus einem Datumsstring den Tagesanfang oder das Tagesende, abhängig
 * vom Parameter ende. Benutzt von js_datum
 * 
 * @param string das gewünschte Datum
 * @param ende wenn true dann wird das Tagesende berechnet
 * @return timestamp
 */
function timestampAusDatum(string, ende) {
	if (isValidDate(string))
	{
		var dateStr = string.split(".");
		var dt = new Date(dateStr[2], dateStr[1] - 1, dateStr[0], 0, 0, 0, 0);
		if (ende === "true") dt.setSeconds(+86399);
		return dt.getTime();
	}
	return false;
}

/**
 * Den Auswahlfilter ausblenden
 */
function auswahlfilter_ausblenden() {
	// Ausblende-Pin verstecken und alle gebundenen
	// (Klick-)Events löschen, damit während der Animation
	// nichts geklickt werden kann.
	jQuery('#pin_offen').hide().off();
	jQuery('#pin_geschlossen').show();
	
	jQuery('#auswahlfilter').animate({
		'marginLeft': '-' + (jQuery('#inhalt').width() + 2) + 'px'
		}, 500, function() {
			// one() bindet einen Eventhandler einmalig an das
			// Element. Nach der Ausführung wird er automatisch
			// entfernt.
			jQuery('#pin_geschlossen').one('click', auswahlfilter_einblenden);

			// Info speichern, dass der Filter geschlossen ist.
			jQuery('#inhalt').data('state', 'geschlossen');
		}
	);
	// Overlay entfernen
	jQuery('#auswahlfilter_overlay').animate({
		opacity: 0
	}, 500, 'linear', function() {
		jQuery('#auswahlfilter_overlay').remove();
	});
}

/*
 * Den Auswahlfilter einblenden
 */
function auswahlfilter_einblenden() {
	// Einblende-Pin verstecken und alle gebundenen
	// (Klick-)Events löschen, damit während der Animation
	// nichts geklickt werden kann.
	jQuery('#pin_geschlossen').hide().off();
	jQuery('#pin_offen').show();
	jQuery('#auswahlfilter').animate({
		'marginLeft': '0px'
		}, 500, function() {
			// one() bindet einen Eventhandler einmalig an das
			// Element. Nach der Ausführung wird er automatisch
			// entfernt.
			jQuery('#pin_offen').one('click', auswahlfilter_ausblenden);
			// Info speichern, dass der Filter offen ist.
			jQuery('#inhalt').data('state', 'offen');
		}
	);
	
	// Overlay einbauen
	jQuery('#page')
		.append(
			'<div id="auswahlfilter_overlay" style="left:0; top:0; width:100%; height:100%; z-index:10; position:fixed; background-color: #000000; opacity:0">&nbsp;</div>');
	jQuery('#auswahlfilter_overlay').animate({
		opacity: 0.5
		}, 500, 'linear');
}

/**
 * Den geöffneten Daterangepicker schließen.
 */
function closeDaterangepicker() {
	jQuery('.ui-daterangepicker').hide().data('state', 'closed');
}

jQuery(document).ready(
	function($) {
		$(".checkbox").buttonset();
		$(".radiobutton").buttonset();
		// Javascript, um Labels gleich breit zu machen
		$(".autowidth_monat_monat").autowidth();
		$(".autowidth_monat_jahr").autowidth();
		$(".autowidth_kw_kw").autowidth();
		$(".autowidth_kw_jahr").autowidth();
		
		// Funktion für die Tabs
		$(function() {
			$('#tabs').tabs({
				select: function(event, ui) {
					// Close datepicker when switching tabs
					$('.ui-daterangepicker').hide().data('state', 'closed');
					$('#auswahl_tab').val($(ui.tab).attr('id'));
				}
			});
		});
		$('#auswahlfilter input').click(
			function() {
				var tab = $('#auswahl_tab').val();
				var ts_von;
				var ts_bis;
				var yesterday = new Date();
				var yesterdayString = "dd.mm.yyyy";
				if (tab === "tab1")
				{
					if ($('#auswahl_tag_von').val() === "gestern")
					{
						yesterday.setDate(new Date().getDate() - 1);
						yesterdayString = yesterday.getDate() + "." +
							(parseInt(yesterday.getMonth()) + parseInt(1)) + "." + yesterday.getFullYear();
						ts_von = timestampAusDatum(yesterdayString, "false");
						ts_bis = timestampAusDatum(yesterdayString, "true");
					}
					else
					{
						ts_von = timestampAusDatum($('#auswahl_tag_von').val(), "false");
						if ($('#auswahl_tag_bis').val() === "" || $('#auswahl_tag_bis').val() === "NaN")
						{
							ts_bis = timestampAusDatum($('#auswahl_tag_von').val(), "true");
						}
						else
						{
							ts_bis = timestampAusDatum($('#auswahl_tag_bis').val(), "true");
						}
					}
				}
				if (tab === "tab2")
				{
					ts_von = timestampAusKw($('#auswahl_kw_von').val(), $('#auswahl_jahr_kw_von').val(), "false");
					ts_bis = timestampAusKw($('#auswahl_kw_bis').val(), $('#auswahl_jahr_kw_bis').val(), "true");
				}
				if (tab === "tab3")
				{
					ts_von = timestampAusMonat($('#auswahl_monat_von').val(), $('#auswahl_jahr_monat_von').val(),
						"false");
					ts_bis = timestampAusMonat($('#auswahl_monat_bis').val(), $('#auswahl_jahr_monat_bis').val(),
						"true");
				}
				if (tab === "tab4")
				{
					if ($('#auswahl_tag_einzeln').val() === "gestern")
					{
						yesterday.setDate(new Date().getDate() - 1);
						yesterdayString = yesterday.getDate() + "." +
							(parseInt(yesterday.getMonth()) + parseInt(1)) + "." + yesterday.getFullYear();
						ts_von = timestampAusDatum(yesterdayString, "false");
						ts_bis = timestampAusDatum(yesterdayString, "true");
					}
					else
					{
						ts_von = timestampAusDatum($('#auswahl_tag_einzeln').val(), "false");
						ts_bis = timestampAusDatum($('#auswahl_tag_einzeln').val(), "true");
					}
				}
				if (ts_von > ts_bis)
				{
					$('#auswahl_von').val(Math.round(ts_bis / 1000));
					$('#auswahl_bis').val(Math.round(ts_von / 1000));
				}
				else
				{
					$('#auswahl_von').val(Math.round(ts_von / 1000));
					$('#auswahl_bis').val(Math.round(ts_bis / 1000));
				}
			});
		
		/**
		 * Erstellt die Funktionalität für den Uhrzeit-Slider und erzeugt den
		 * Text mit der aktuellen Auswahl
		 */
		$(function() {
			$(".auswahl_uhrzeit_slider").slider({
				range: true,
				min: 0,
				max: 1440,
				values: [ 0, 1440 ],
				step: 1,
				slide: function(e, ui) {
					var time1 = getHourMinutes(ui.values[0]);
					var time2 = getHourMinutes(ui.values[1]);
					$("#auswahl_uhrzeit_text").html("Zeitfenster: " + time1 + " - " + time2 + " Uhr");
					$("#auswahl_uhrzeit_von").val(ui.values[0] * 60);
					$("#auswahl_uhrzeit_bis").val(ui.values[1] * 60);
				}
			});
			var time1 = getHourMinutes($(".auswahl_uhrzeit_slider").slider("values", 0));
			var time2 = getHourMinutes($(".auswahl_uhrzeit_slider").slider("values", 1));
			$("#auswahl_uhrzeit_text").html("Zeitfenster: " + time1 + " - " + time2 + " Uhr");
		});
		
		// Je nach übergebener Option zu Beginn ein- oder ausblenden
		// TODO:
		//$isShowOptionOnStart ? "auswahlfilter_einblenden();" : "auswahlfilter_ausblenden();";
		//auswahlfilter_einblenden();
		
		if(isShowOptionOnStart){
			auswahlfilter_einblenden();
		}	
		else{
			auswahlfilter_ausblenden();
		}	
		
		// Escape schließt den Auswahlfilter ohne die Seite neu zu
		// laden.
		document.onkeydown = function(evt) {
			evt = evt || window.event;
			if (evt.keyCode === 27 && $('#inhalt').data('state') === 'offen')
			{
				// Wenn ein jQueryUI-Dialog geöffnet ist (z.B.
				// Fahrzeugauswähler), dann diesen erst schließen
				if ($('.ui-dialog-content').dialog('isOpen') === true)
				{
					$('.ui-dialog-content').dialog('close');
				}
				else
				{
					auswahlfilter_ausblenden();
				}
			}
		}
		
		// Beim Senden den Filter ausblenden
		$('form').submit(function() {
			auswahlfilter_ausblenden();
		});
		
		// Setze von-Feld auf leer, wenn reingeklickt wird
		$('#auswahl_tag_einzeln').focus(function() {
			$(this).val('');
		});
		$('#auswahl_tag_von').focus(function() {
			$(this).val('');
		});
		$('#auswahl_tag_bis').focus(function() {
			$(this).val('');
		});
		// Schließe Daterangepicker bei manueller Eingabe
		$('#auswahl_tag_von, #auswahl_tag_bis').on('input', function() {
			$('.ui-daterangepicker').hide().data('state', 'closed');
		});
		$('#auswahl_tag_einzeln').on('input', function() {
			$('.ui-daterangepicker').hide().data('state', 'closed');
		});
	});
