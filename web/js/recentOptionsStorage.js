function setStartDefaultDate(){	
	if(typeof(Storage) === "undefined") return;
	var startDate = localStorage.startDate;	
	if(startDate != null && startDate != "undefined")
		$('#auswahl_tag_von').val(startDate);
};
function setEndDefaultDate(){
	if(typeof(Storage) === "undefined") return;
	var endDate = localStorage.endDate;	
	if(endDate != null  && endDate != "undefined")
		$('#auswahl_tag_bis').val(endDate);
};

function setSingleDate(){
	if(typeof(Storage) === "undefined") return;	
	var endDate = localStorage.singleDate;	
	if(endDate != null  && endDate != "undefined")
		$('#auswahl_tag_einzeln').val(endDate);		
};

function setTailNumber(selector){
	if(typeof(Storage) === "undefined") return;
	var tailNumber = localStorage.tailNumber;	
	if(tailNumber != null  && tailNumber != "undefined")		
		selector.val(tailNumber);
};

function setTractorName(selector){
	if(typeof(Storage) === "undefined")  return;
	var tractorName = localStorage.tractorName;	
	if(tractorName != null  && tractorName != "undefined")		
		selector.val(tractorName);
};

function setFlightNumber(selector){
	if(typeof(Storage) === "undefined")  return;
	var flightNumber = localStorage.flightNumber;	
	if(flightNumber != null  && flightNumber != "undefined")		
		selector.val(flightNumber);
};


//*******Saves

function saveTailNumber(selector){
	if(typeof(Storage) === "undefined") {
		return;
	}	
	var tailNumber = $(selector).val();	
	if(tailNumber != null && tailNumber != "undefined" ){
		localStorage.tailNumber = tailNumber; 
	} 
};

function saveTractorName(selector){
	if(typeof(Storage) === "undefined") {
		return;
	}	
	var tractorName = $(selector).val();	
	if(tractorName != null && tractorName != "undefined" ){
		localStorage.tractorName = tractorName; 
	} 
};

function saveFlightNumber(selector){
	if(typeof(Storage) === "undefined") {
		return;
	}	
	var flightNumber = $(selector).val();	
	if(flightNumber != null && flightNumber != "undefined" && flightNumber != ""){
		localStorage.flightNumber = flightNumber; 
	} 
};

function saveSingleDate(){
	if(typeof(Storage) === "undefined") return;
	var date = $('#auswahl_tag_einzeln').val();	
	if(date != null && date != "undefined")
		localStorage.singleDate = date;
};

function saveStartDate(){	
	if(typeof(Storage) === "undefined") return;
	var date = $('#auswahl_tag_von').val();	
	if(date != null && date != "undefined")
		localStorage.startDate = date; 
};

function saveEndDate(){
	if(typeof(Storage) === "undefined")  return;	
	var date = $('#auswahl_tag_bis').val();	
	if(date != null && date != "undefined")
		localStorage.endDate = date; 
};