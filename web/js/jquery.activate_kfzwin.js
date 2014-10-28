/**
 * Diese Funktion aktiviert die Möglichkeit kfzWin-Nummern einzugeben und wird u.a. nach dem Neuladen einer Zeile 
 * aufgerufen.
 * 
 * Die Funktion findet in allen Werkstätten Verwendung.
 * 
 */
function activate_kfzwin(){	
	jQuery('.edit').editable('/werkstatt_bus.php/UebersichtWerkstatt/updateKfzwin', {
		indicator : 'Wird gespeichert...',
		select:		true,
		tooltip		: 'Klicken zum Editieren',
		callback	: function(value, settings) {
			jQuery().toastmessage(
				'showToast', {
					text		: 'KfzWin erfolgreich gespeichert',
					type		: 'success',
					stayTime	: 2500,
					position	: 'top-right'
			});
			// Toast-Container an den Anfang von '#page_content' schieben, damit er oben rechts erscheinen kann
			jQuery('#page_content').prepend(jQuery('.toast-container'));
			
			if( value == '--/--' ) {
				jQuery(this).css('color', 'white');
			}
			else {
				jQuery(this).css('color', '');
			}
		}
		}
	);	
}




