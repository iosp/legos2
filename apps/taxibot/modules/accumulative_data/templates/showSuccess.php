<?php

use_helper ( 'Global', 'Javascript', 'Selection' );

echo selectionFilter ( array (
		'Tag' 
), null, $route, array (
		'Taxibot',
		'AccumulativeData' 
), '', true, false );

if ($data == null) {
	?><h2><?php echo "No find data.. please change filter";?></h2><?php
	return;
}
?>

<h1>Accumulative Data</h1>

<hr>


<div class="row">
	<div class="col-md-2">
		<div class="panel panel-default ">
			<div class="panel-heading">
				<h3 class="panel-title">From</h3>
			</div>
			<div class="panel-body">
				<h6><?php echo $from_str . " " . $from_time?></h6>
			</div>
		</div>
	</div>
	<div class="col-md-2">
		<div class="panel panel-default ">
			<div class="panel-heading">
				<h3 class="panel-title">To</h3>
			</div>
			<div class="panel-body">
				<h6><?php echo $to_str . " " . $to_time;?></h6>
			</div>
		</div>
	</div>
	<div class="col-md-2">
		<div class="panel panel-default ">
			<div class="panel-heading">
				<h3 class="panel-title">Taxibot Number</h3>
			</div>
			<div class="panel-body">
				<h6><?php echo $selected_taxibot_number?></h6>
			</div>
		</div>
	</div>
</div>




<div class="row">
	<div class="col-md-4" >
		<table id="data-table" class="table table-bordered">			 
			<tbody>
				<tr>
					<th>Mission time average</th>
					<td><?php echo $data->MissionTimeAvg;?></td>
				</tr>
				<tr>
					<th>PCM time in single mission</th>
					<td><?php echo $data->PcmTimeAvg; ?></td>
				</tr>
				<tr>
					<th>Pushback time average</th>
					<td><?php  echo $data->PushbackTimeAvg; ?></td>
				</tr>
				<tr>
					<th>Cul –De- Sac time average</th>
					<td><?php  echo $data->CulDeSecTimeAvg; ?></td>
				</tr>
				<tr>
					<th>Speed in PCM average</th>
					<td><?php  echo $data->PcmSpeedAvg; ?></td>
				</tr>
				<tr>
					<th>Mission interruptions</th>
					<td>Z</td>
				</tr>
				<tr>
					<th>Degraded mode missions</th>
					<td>Z</td>
				</tr>
				<tr>
					<th>Fuel per mission –Average</th>
					<td><?php  echo $data->FuelPerMissionAvg ?></td>
				</tr>
				<tr>
					<th>Total amount of missions</th>
					<td><?php  echo $data->TotalAmountMissions ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div id="content-chart">
	<div id="missions-chart"></div>
</div>


<script type="text/javascript">

	window.Lahav = window.Lahav || {};
	Lahav.accumulativeData= {};
	Lahav.accumulativeData.items = <?php echo json_encode($data->amountMissionPerDay);  ?>;	

</script>
<?php
echo use_javascript ( 'jquery.min.js' );
use_javascript ( 'jquery-ui.custom.min.js' );
use_stylesheet ( 'jquery-ui-1.8.16.custom.css' );
use_stylesheet ( "app/taxibot/accumulative_data/show.css" );
?>

<script src="http://code.highcharts.com/stock/highstock.js"></script>
<script src="http://code.highcharts.com/stock/modules/exporting.js"></script>

<?php
echo use_javascript ( "app/taxibot/accumulative_data/show.js" );
?>