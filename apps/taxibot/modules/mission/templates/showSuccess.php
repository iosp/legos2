<?php
use_helper ( 'Global', 'Javascript', 'Selection' );

ini_set ( "memory_limit", "2048M" );
set_time_limit ( 1500 );
use_helper ( 'Global', 'Javascript' );
use_javascript ( 'jquery.min.js' );

echo selectionFilter ( array (
		'Einzeltag' 
), null, $route, array (
		'Taxibot',
		'Mission' 
), '', true, false );

if ($missionId == - 1) {
	?><h2><?php echo "No find data.. please change filter";?></h2><?php
	return;
}

use_stylesheet ( "app/taxibot/mission/show.css" );
?>

<div class="row">
	<div class="col-md-2">
		<div class="panel panel-default ">
			<div class="panel-heading">
				<h3 class="panel-title">Start Date</h3>
			</div>
			<div class="panel-body">
				<h6><?php echo $mission_page->DateFilter;?></h6>
			</div>
		</div>
	</div>
	<div class="col-md-2">
		<div class="panel panel-default ">
			<div class="panel-heading">
				<h3 class="panel-title">Flight Number</h3>
			</div>
			<div class="panel-body">
				<h6><?php echo $mission_page->FlightNumber;?></h6>
			</div>
		</div>
	</div>
	<div class="col-md-2">
		<div class="panel panel-default ">
			<div class="panel-heading">
				<h3 class="panel-title">Taxibot Number</h3>
			</div>
			<div class="panel-body">
				<h6><?php echo $mission_page->TaxibotNumber;?></h6>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default ">
			<div class="panel-heading">
				<h3 class="panel-title">BLF(Archive) Filename 
					<span class="glyphicon glyphicon-cloud-download" aria-hidden="true"></span>
				</h3>
			</div>
			<div class="panel-body">
				<a class="blf-download" >
					<h6 class="blf-name"><?php echo $mission_page->BlfName;?>
					</h6>
				</a>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div id="tables">
		<div id="operating_hours_table_container" class="col-md-4">
			<h5><?php echo "Mission Operating Hours"  ?></h5>
			<table class="data" id="operating_hours" border="1">
				<tbody>
					<tr>
						<td colspan="2" style="height: 30px; background-color: #777777;"></td>
					</tr>
					<tr>
						<th>DCM Time + Unloading, Loading</th>
						<td><?php echo $mission_page->DcmTotalTime;?></td>
					</tr>

					<tr>
						<td class="pcm-container">
							<table border="1" class="pcm-table">
								<tr>
									<th class="th-main"
										rowspan=" <?php
										
										$pcmCount = count ( $mission_page->PcmTimes );
										if ($pcmCount > 0) {
											
											echo $pcmCount + 1;
										} else {
											echo 2;
										}
										?> ">PCM</th>
									<th>Start</th>
									<th>End</th>
									<th>Total</th>
								</tr>
								<?php foreach ($mission_page->PcmTimes as $pcm){ ?>
								<tr>
									<td><?php echo $pcm['start'];?></td>
									<td><?php echo  $pcm['end'];?></td>
									<td><?php echo $pcm['total'];?></td>
								</tr>
								<?php
								}
								if ($pcmCount == 0) {
									?>
								<tr>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								 <?php } ?>
								 
							</table>
						</td>
						<td><?php echo $mission_page->PcmTotalTime;?></td>
					</tr>
					<tr>
						<th>Total Mission Time</th>
						<td><?php echo $mission_page->TotalMissionTime;?></td>
					</tr>
					
				</tbody>
				<tfoot>
					<tr>
						<th colspan="3" style="height: 40px"></th>

					</tr>
				</tfoot>
			</table>
			
			
			
			<br>
			<div class="mission-buttons">
				<div>  
					<a href="<?php echo "export?file=$exportFilename"?>"class="abfragebutton">Export Data</a>
				</div>
				<div >
					<a href="<?php echo "../fatigue_history/force?missionId=$missionId"?>"class="abfragebutton">Forces Analysis</a>
				</div>
				<div >
					<a href="<?php echo "../map/index"?>" class="abfragebutton">Show Map</a>
				</div>
			</div>
		</div>
		<div id="rtc_hours_table_container" class="col-md-2">
			<table class="data" id="rtc_hours_table" style="margin-top: 35px"
				border="1">
				<body>
				
				
				<tr>
					<th
						style="height: 30px; width: 50px; background-color: #777777; color: #FFFFFF">RTC</th>
				</tr>
				<tr>
					<td><?php echo '';?></td>
				</tr>
				<tr>
					<td><?php echo '';?></td>
				</tr>
				</body>
			</table>


		</div>
		<div id="driver_time_stamp_table_container" class="col-md-3">
			<h5><?php echo "Driver Time Stamp"  ?></h5>
			<table class="data" id="driver_time_stamp" border="1">
				<tbody>
					<tr>
						<th colspan="2"
							style="height: 30px; background-color: #777777; color: #FFFFFF">RTC</th>
					</tr>
					<tr>
						<th>Beginn Anfahrt (Start Of Mission)</th>
						<td><?php echo '';?></td>
					</tr>
					<tr>
						<th>AnkunftStart (Arrival at A/C)</th>
						<td><?php echo '';?></td>
					</tr>

					<tr>
						<th>Schleppklar (Ready for Push Back)</th>
						<td><?php echo '';?></td>
					</tr>
					<tr>
						<th>AbfahrtStart (Start Push Back)</th>
						<td><?php echo '';?></td>
					</tr>


					<tr>
						<th>AnkunftZeil (End Push Back)</th>
						<td><?php echo '';?></td>
					</tr>
					<tr>
						<th>BeginTaxiBoting (Start PCM)</th>
						<td><?php echo '';?></td>
					</tr>

					<tr>
						<th>Exit Hof (Exit Termina Area)</th>
						<td><?php echo '';?></td>
					</tr>
					<tr>
						<th>AnkunftZeilTaxiBoting (End PCM)</th>
						<td><?php echo '';?></td>
					</tr>

					<tr>
						<th>Beendet (End Of Mission)</th>
						<td><?php echo '';?></td>
					</tr>
					<tr>
						<th>TaxiBotRuckfahrtbereit (TaxiBot Ready to Return)</th>
						<td><?php echo '';?></td>
					</tr>

				</tbody>
				<tfoot>
					<tr>
						<th colspan="2" style="height: 40px"></th>

					</tr>
				</tfoot>
			</table>
		</div>
		<div id="fuel_consumption_table_container" class="col-md-3">
			<h5><?php echo "Mission Fuel Consumption"  ?></h5>
			<table class="data" id="fuel_consumption" border="1">
				<thead>
					<tr>
						<th colspan="3" style="height: 30px; background-color: #777777;"></th>
					</tr>
					<tr>
						<th></th>
						<th>Left Engine (Liter)</th>
						<th>Right Engine (Liter)</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th class="th-main">PCM</th>
						<td><?php echo $mission_page->LeftPcmFuel;?></td>
						<td><?php echo $mission_page->RightPcmFuel; ?>		</td>
					</tr>
					<tr>
						<th class="th-main">DCM</th>
						<td><?php echo $mission_page->LeftDcmFuel;?></td>
						<td><?php echo $mission_page->RightDcmFuel; ?>	</td>
					</tr>
					<tr>
						<th class="th-main">Total Engine</th>
						<td><?php echo $mission_page->LeftPcmFuel + $mission_page->LeftDcmFuel;?></td>
						<td><?php echo $mission_page->RightPcmFuel + $mission_page->RightDcmFuel; ?>		</td>
					</tr>

					<tr>
						<th class="th-main">Mission Both</th>
						<td colspan="2"> <?php echo $mission_page->LeftPcmFuel + $mission_page->LeftDcmFuel + $mission_page->RightPcmFuel + $mission_page->RightDcmFuel;?>  </td>
					</tr>
					<tr>
						<td colspan="3"></td>
					</tr>				
					<tr>
						<th class="th-main">Pushback</th>
						<td><?php echo $mission_page->LeftPushbackFuel;?></td>
						<td><?php echo $mission_page->RightPushbackFuel; ?>		</td>
					</tr>
					<tr>
						<th class="th-main">Pushback Both</th>
						<td colspan="2"><?php echo $mission_page->LeftPushbackFuel + $mission_page->RightPushbackFuel;?></td>
					</tr>

				</tbody>
				<tfoot>
					<tr>
						<th colspan="3" style="height: 40px"></th>

					</tr>
				</tfoot>

			</table>

		</div>
	</div>

</div>

<div class="row">
	<div class="mission-chart"></div>
</div>

<script type="text/javascript">


	window.Lahav = window.Lahav || {};
	Lahav.missionPage = {};
	Lahav.missionPage.items = <?php echo json_encode($mission_page->chartData);  ?>;
	

</script>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/highcharts-more.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
<?php use_javascript ( "app/taxibot/mission/show.js" );?>