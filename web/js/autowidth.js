	/**
	 * Dieses jQuery-Plugin passt die 'width' aller label-Elemente, die in '.form-content'-divs stecken, an die maximal
	 * vorkommende Breite an. Nützlich, um Formulare schön auszurichten.
	 * 
	 * Es kann die Option "limitWidth" übergeben werden, um einen Maximalwert der Breite anzugeben.
	 */

// Um Namespace-Probleme zu verhindern, weisen wir durch das umgebende "function($)" die $()-Funktion explizit jQuery() zu.
// Ansonsten müssten wir überall "jQuery()" statt "$()" verwenden.
(function($){
	
	// Wenn die Seite geladen ist, führen wir die Funktion autowidth() für alle label-Elemente
	// aus, die in 'form_content'-divs stecken. Somit werden mehrere Formulare auf einer Seite
	// unabhängig voneinander betrachtet.
	$(document).ready( function(){
		$(".form_content").each( function() {
			$(this).children("label").autowidth();
		});
	});
	
	// Funktion als jQuery-Plugin definieren.
	$.fn.autowidth = function(options) {
		var settings = {
			limitWidth: false
		}
		
		if(options) {
			$.extend(settings, options);
		};
		
		var maxWidth = 0;
		
		$(this).each(function() {
			if( $(this).width() > maxWidth ) {
				if( settings.limitWidth && maxWidth >= settings.limitWidth ) {
					maxWidth = settings.limitWidth;
				} else {
					maxWidth = $(this).width();
				}
			}
		}); 
		
		$(this).width(maxWidth);
	}

})(jQuery);
