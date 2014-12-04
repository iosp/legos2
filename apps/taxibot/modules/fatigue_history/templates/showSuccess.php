<?php
 use_helper( 'Global', 'Javascript',  'Selection' );

echo selectionFilter ( array (
		'Tag' 
), null, $route, array (
		'Taxibot', 'FatigueHistory' 
), '', true, false);

	if(!$isFilterSuccess){
		?><h3><?php  echo $message; ?></h3> <?php
		return ;
	}
?>

<div class="row">
	<div class="col-md-2">
		<div class="panel panel-default ">
			<div class="panel-heading">
				<h3 class="panel-title">From</h3>
			</div>
			<div class="panel-body"><h6><?php echo $from_str ."  ". $from_time.":00"?></h6></div>
		</div>
	</div>
	<div class="col-md-2">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">To</h3>
			</div>
			<div class="panel-body"><h6><?php echo $to_str ."  ". $to_time.":00"?></h6></div>
		</div>
	</div>
	<div class="col-md-2">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Tail Number</h3>
			</div>
			<div class="panel-body"><h6><?php echo $tailNumber;?></h6></div>
		</div>
	</div>
</div>

<div class="row">
	<div id="content-chart">
		<div id="long-chart"></div>
		<div id="lat-chart"></div>
	</div>

</div>


<script type="text/javascript">

	window.Lahav = window.Lahav || {};
	Lahav.fatigueHistory= {};
	Lahav.fatigueHistory.items = <?php echo json_encode($items);  ?>;
	Lahav.fatigueHistory.longSafe = <?php echo $longSafe;?>; 
	Lahav.fatigueHistory.latSafe = <?php  echo $latSafe;?>; 
	Lahav.fatigueHistory.longfatig  = <?php echo $longfatig;?>; 
	Lahav.fatigueHistory.flagIcon = "<?php echo image_path('flag-icon.png');?>";
	debugger;

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
echo use_javascript ( "app/taxibot/fatigue_history/show.js" );
?>

