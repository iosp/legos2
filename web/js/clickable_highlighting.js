	/**
	 * Dieses jQuery-Plugin ermöglicht es, bei einem Doppelklick auf eine Tabellenzeile dieses
	 * farblich hervorzuheben.
	 * Bei einem Druck auf die Escape-Taste werden alle Hervorhebungen wieder entfernt.
	 *
	 * Sämtliche tr-Objekte, auf die dieses Skript angewendet werden soll, müssen die Klasse "clickable_highlighting" besitzen.
	 * 
	 * Dieses Plugin darf nur auf 'normale' Tabellen engewendet werden, da dataTables-Tabellen über eine Funktion in
	 * make_datatables.js bereits diese Funktion erhalten.
	 */

// Um Namespace-Probleme zu verhindern, weisen wir durch das umgebende "function($)" die $()-Funktion explizit jQuery() zu.
// Ansonsten müssten wir überall "jQuery()" statt "$()" verwenden.
(function($){

	// Wenn die Seite geladen ist, führen wir die Funktion clickableHighlighting() auf jeder Tabellenzeile
	// der Klasse 'clickable_highlighting' aus.
	$(document).ready(function(){
		$("tr.clickable_highlighting").each( function() { $(this).clickableHighlighting(); } );
	});
	
	
	// Unsere Funktion als jQuery-Plugin definieren.
	$.fn.clickableHighlighting = function() {
		// Bei einem Doppelklick auf die Tabellenzeile die Klasse "highlighted" togglen (je nach dem, hinzufügen oder entfernen).
		// Dies ist die Klasse, die die farbliche Hervorhebung beinhaltet.
		$(this).dblclick( function() {
			$(this).toggleClass("highlighted");	
		});
		
		// Bei einem Escape-Druck sämtliche Hervorhebungen entfernen. (Escape-Taste hat KeyCode 27)
		$(document).keypress( function(e) {
			if( e.keyCode == 27 ) {
				$("tr.highlighted.clickable_highlighting").each( function() {
					$(this).removeClass("highlighted");
				});
			}
		});
	}
})(jQuery);
