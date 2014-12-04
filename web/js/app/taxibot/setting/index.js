$(function() {	
	$('.th-edit-icon').on('click', function() { 

		var $tdtext = $(this).closest('tr').find('.limit-value');
		var oldText = $tdtext.text();
		$tdtext.text("");
		$tdtext.append('<input type="text" class="operational-type-input" value="'
						+ oldText + '"></input>');

		var $input = $tdtext.find('input');
		$input.css('display', 'inline-block');
		$input.css('width', '70%');
		$input.focus();

		$input.blur(function() {
			finishEditCell($tdtext, $input, oldText);
		});

		$input.keypress(function(e) {
			if (e.which == 13) {
				finishEditCell($tdtext, $input, oldText);
			}
		});

		$input.dblclick(function(event) {
			event.stopPropagation();
		});		
	});
	
	function finishEditCell($tdtext, $input, oldValue) {		
		
		var newValue = $input.val();

		if (oldValue == newValue) {
			$tdtext.text(oldValue);
			return;
		} 
	 
		if(isNaN(newValue)){
			alert("Only number is allowed!!!");
			$tdtext.text(oldValue);
			return;
		}
		
		var result = confirm("Change database and update force?");
		if (!result) {
			$tdtext.text(oldValue);
			return;
		}
		
		var data = {};
		data.aricaftType = $tdtext.closest('tr').attr('data-aircraft');
		data.forceType = $tdtext.closest('tr').attr('data-force');
		data.angleType = $tdtext.closest('tr').attr('data-angle');
		data.value = newValue;

		//debugger;
		$.ajax({
			data : {
				data : data
			},
			url : "../data_management/saveForce",
			type : "POST",
		}).done(function(data) {
			console.log(data);
		}).fail(function(data) {
			var t = data;
		});

		$tdtext.text(newValue);		 
	}
});