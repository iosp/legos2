<?php ?>

<div id="example">Example</div>

<div id="box"
	style="width: 200px; height: 50px; background-color: blue;">Box</div>


<script type="text/javascript">

jQuery('#box').on('click',function(){
	jQuery('#example').html('New Example');
});



</script>