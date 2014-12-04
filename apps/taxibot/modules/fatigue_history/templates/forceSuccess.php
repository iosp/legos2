
<div class="row">
	<div id="content-chart">
		<div id="chart"></div>
		<!-- <div class="long-border chart-border"></div>
		<div class="lat-border chart-border"></div>
		<div class="veolcity-border chart-border"></div>
		<div class="tiller-border chart-border"></div>
		<div class="break-border chart-border"></div> -->
	</div>

</div>


<script type="text/javascript">
	debugger;
	window.Lahav = window.Lahav || {};
	Lahav.fatigueHistory= {};
	Lahav.fatigueHistory.items = <?php echo json_encode($items);  ?>;
	Lahav.fatigueHistory.longSafe = <?php echo $longSafe;?>; 
	Lahav.fatigueHistory.latSafe = <?php  echo $latSafe;?>; 
	Lahav.fatigueHistory.longfatig  = <?php echo $longfatig;?>; 

</script>
<?php
echo use_javascript ( 'jquery.min.js' );
use_javascript ( 'jquery-ui.custom.min.js' );
use_stylesheet ( 'jquery-ui-1.8.16.custom.css' );
use_stylesheet ( "app/taxibot/fatigue_history/show.css" );
?>

<script src="http://code.highcharts.com/stock/highstock.js"></script>
<script src="http://code.highcharts.com/stock/modules/exporting.js"></script>

<?php
echo use_javascript ( "app/taxibot/fatigue_history/force.js" );

?>

