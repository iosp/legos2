	/**
	 * Dieses jQuery-Plugin wendet das jQuery "dataTables"-Plugin auf unsere Tabellen an. Dazu muss das table-Tag
	 * folgende Attribute enthalten:
	 * 
	 * <table id="<tabellen-id>" class="daten" titel="<Tabellen-Titel>">
	 * 
	 * Da das dataTables-Plugin über "document.ready()" aufgerufen wird, muss "make_dataTable()" bei per AJAX
	 * nachgeladenen Tabellen nochmal manuell auf der nachgeladenen Tabelle ausgeführt werden.
	 */

// Um Namespace-Probleme zu verhindern, weisen wir durch das umgebende "function($)" die $()-Funktion explizit jQuery() zu.
// Ansonsten müssten wir überall "jQuery()" statt "$()" verwenden.
(function($){
	
	// Wenn die Seite geladen ist, führen wir die Funktion make_dataTable() auf jeder Tabelle
	// mit css-Klasse "daten" aus.
	$(document).ready(function(){
		$("table.daten").each( function() { $(this).make_dataTable(); } );
	});
	
	// Funktion als jQuery-Plugin definieren.
	$.fn.make_dataTable = function() {
		
		//Prüft ob die Tabelle einen Footer haben soll und erweitert ggf. den DOM-Baum entsprechend
		if ( $(this).hasClass('no_footer') ){
			footer = '';
		}
		else {
			footer ='<"table_bottom"ilp>';
		}
		
		//Sortierung anhand classen und plugins
		var CustomSort = false
		//Funktioniert derzeit nur mit Einzeiligen Kopfzeilen
		//TODO: Sortierung nach der zweiten Zeile
		if ($(this).children(':first-child').children().size() == 1) {
			var SortArray = [];
			CustomSort = true;
			$(this).children(':first-child').children().children().each( function () {
				switch ($(this).attr('class')) {
					case "date-eu":
						SortArray.push({ "sType": "date-eu"});
						break;
					case "formatted-num":
						SortArray.push({ "sType": "formatted-num"});
						break;
					case "natural":
						SortArray.push({ "sType": "natural"});
						break;
					case "percent":
						SortArray.push({ "sType": "percent"});
						break;
					case "noSort":
						SortArray.push({ "bSortable": false });
						break;
					case "date-time-eu":
						SortArray.push({ "sType": "date-time-eu"});
						break;
					default:
						SortArray.push( null );
						break;
				}
			} );
		}
		
		// Daten-Tabelle laden
		$(this).dataTable({
				"sDom": '<"table_title"<"table_top"f>>rt' + footer + '<"clear">',
				"bScrollCollapse": true,
				"oLanguage": {
					"sProcessing": "Please Wait ...",
					"sLengthMenu": "_MENU_ Records Shown",
					"sZeroRecords":"No Records Exist.",
					"sInfo": "_START_ to _END_ from _TOTAL_ Records",
					"sInfoEmpty": "0 to 0 from 0 Records",
					"sInfoFiltered": "(filtered from _MAX_ Records)",
					"sInfoPostFix": "",
					"sSearch": "Search",
					"sUrl": "",
					"oPaginate": {
						"sFirst": "|<",
						"sPrevious": "<",
						"sNext": ">",
						"sLast": ">|"
					},
				},
				"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Alle"]],
				"sPaginationType": "full_numbers",
				"bPaginate": !$(this).hasClass('no_footer'),
				"bDestroy": true,
				"bSort": !$(this).hasClass('no_sort'),
				"aoColumns": (CustomSort) ? SortArray : null,
				"aaSorting": [], //Initiale Sortierung deaktiviert. Serverseitig geht diese schneller als per Javascript
				"fnCreatedRow": function(nRow, aData, iDataIndex){
									// Beim Doppelklick die Klasse 'highlighted' toggeln.
									$(nRow).dblclick( function() {
										$(this).toggleClass("highlighted");	
									});
									// Bei Escsape-Druck (KeyCode 27) Klasse 'highlighted' wieder entfernen.
									$(document).keypress( function(e) {
										if( e.keyCode == 27 ) {
											$(nRow).removeClass("highlighted");
										}
									});
								}
		});
		
		// Titel in Tabelle einfügen, wenn vorhanden
		if( typeof($(this).attr('titel')) != "undefined" ) {
			$('#' + $(this).attr('id') + '_filter').before("<div id='table_name'>" + $(this).attr('titel') + "</div>");
		}
		if( typeof($(this).attr('zusatz_link'))!= "undefined" ) {
			$('#' + $(this).attr('id') + '_filter').before("<div id='zusatz_link'>" + $(this).attr('zusatz_link') + "</div>");
		}
	}
})(jQuery);
