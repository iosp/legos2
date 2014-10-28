$(function() {
	setFlightNumber($("#auswahl_FlightNumber"));
	$("#auswahl_FlightNumber").change(function() {
		saveFlightNumber(this);
	});
	
	setTailNumber($("#auswahl_TailNumber"));
	$("#auswahl_TailNumber").change(function() {
		saveTailNumber(this);
	});
	
	setTractorName($("#auswahl_TaxibotNumber"));
	$("#auswahl_TaxibotNumber").change(function() {
		saveTractorName(this);
	});
});
