$(function(){
	$("tbody").on("click", ".position-exceed", function(){ 
		var lat = $(this).attr("data-position-lat");
		var long = $(this).attr("data-position-long");
		window.location = 'http://maps.google.com/?q='+ lat + ',' + long + '&t=k';
	});
});