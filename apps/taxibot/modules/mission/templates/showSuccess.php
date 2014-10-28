<?php use_helper( 'Global', 'Javascript',  'Selection' )?>
<?php

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

?>

<style>
<!--
style for table
-->table.data {
	clear: both;
	width: 100%;
	font-size: 10px;
	border: 0;
	border-spacing: 0px;
}

table.data th {
	width: 250px;
	height: 20px
}

table.data td {
	width: 100px;
	height: 20px;
	border-right: 1px solid #CCCCCC;
	border-bottom: 1px solid #CCCCCC;
	text-align: center;
}

table.data tr,table.data tr:nth-child(even) td,table.data tr:nth-child(even) th
	{
	background-color: #EEEEEE;
}

table.data tr:nth-child(odd) td,table.data tr:nth-child(odd) th {
	background-color: #FFFFFF;
}

$
from_str
	table.data tr:hover td,table.data tr:hover th {
	background-color: #FFBA17;
}
</style>

<div id="content">

	<div id="filter-data" style="height: 80px;" >
		<div id="time_interval_table_container"
			style="float: left; margin-right: 20px">
			<table class="time_interval" id="time_interval_table" border="1"
				style="height: 40px">
				<tbody>
					<tr>
						<th style="font-size: 15px;">Start Date </th>
					</tr>
					<tr>
						<th><?php echo $startTime;?></th>
					</tr>
				</tbody>
			</table>
		</div>
		
		<div id="time_interval_table_container"
			style="float: left; margin-right: 20px">
			<table class="time_interval" id="time_interval_table" border="1"
				style="height: 40px">
				<tbody>
					<tr>
						<th style="font-size: 15px;">Flight Number </th>

					</tr>
					<tr>
						<th><?php echo $Selected_flight_number;?></th>
					</tr>
				</tbody>
			</table>
		</div>

		<div id="taxibot_number_table_container">
			<table id="taxibot_number_table" border="1"
				style="float: left; margin-right: 20px; height: 40px">
				<tbody>
					<tr>
						<th style="font-size: 15px;">Taxibot Number</th>
					</tr>
					<tr>
						<th>  <?php echo $tractorName;?> </th>
					</tr>
				</tbody>
			</table>
		</div>

		<div id="blf_number_table_container">
			<table id="blf_number_table" border="1" style="height: 40px">
				<tbody>
					<tr>
						<th style="font-size: 15px;">BLF(Archive) Filename</th>
					</tr>
					<tr>
						<th><?php echo $blfName;?></th>
					</tr>
				</tbody>
			</table>
		</div>
	</div>	
	
	<div id="tables">
		<div id="operating_hours_table_container" class="col-md-4" >
			<h5><?php echo "Mission Operating Hours"  ?></h5>
			<table class="data" id="operating_hours" border="1">
				<tbody>
					<tr>
						<td colspan="2" style="height: 30px; background-color: #777777;"></td>
					</tr>
					<tr>
						<th>DCM Time + Unloading, Loading</th>
						<td><?php echo $dcmTime;?></td>
					</tr>
					<tr>
						<th>PCM Start</th>
						<td><?php echo $pcmStart;?></td>
					</tr>
					<tr>
						<th>PCM End</th>
						<td><?php echo $pcmEnd;?></td>
					</tr>
					<tr>
						<th>PCM Time</th>
						<td><?php echo $pcmTime;?></td>
					</tr>
					<tr>
						<th>Total Mission Time</th>
						<td><?php echo $totalTime;?></td>
					</tr>
					<tr>
						<th></th>
						<td></td>
	
					</tr>
					<tr>
						<th>Pushback Start</th>
						<td> <?php echo $pushbackStart ; ?> </td>
					</tr>
					<tr>
						<th>Pushback End</th>
						<td><?php echo $pushbackEnd;?></td>
					</tr>
					<tr>
						<th>Pushback Time</th>
						<td><?php echo $pushbackTime;?></td>
					</tr>
					<tr>
						<th></th>
						<td></td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<th colspan="3" style="height: 40px"></th>
	
					</tr>
				</tfoot>
			</table>
	
			<!-- 	Export Button -->
			<div>
				<br /> 
				<?php echo link_to( 'Export Data' , "mission/export?file=$exportFilename")?>
			</div>
	
	
		</div>
		<div id="rtc_hours_table_container" class="col-md-2" > 
			<table class="data" id="rtc_hours_table" style="margin-top: 35px"
				border="1">
				<body>
				
				
				<tr>
					<th
						style="height: 30px; width: 50px; background-color: #777777; color: #FFFFFF">RTC</th>
				</tr>
				<tr style="height: 15px"></tr>
				<tr style="height: 15px"></tr>
				<tr style="height: 16px"></tr>
				<tr>
					<td><?php echo '';?></td>
				</tr>
				<tr>
					<td><?php echo '';?></td>
				</tr>
				</body>
			</table>
	
	
		</div>
		<div id="driver_time_stamp_table_container" class="col-md-3" >
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
						<th>PCM</th>
						<td><?php echo $fuelLeftPcm;?></td>
						<td><?php echo $fuelRightPcm; ?>		</td>
					</tr>
					<tr>
						<th>DCM</th>
						<td><?php echo $fuelLeftDcm;?></td>
						<td><?php echo $fuelRightDcm; ?>	</td>
					</tr>
					<tr>
						<th>Total Engine</th>
						<td><?php echo $fuelLeftTotal;?></td>
						<td><?php echo $fuelRightTotal ; ?>		</td>
					</tr>
	
					<tr>
						<th>Mission Both</th>
						<td colspan="2"> <?php echo $fuelMissionBoth;?>  </td>
					</tr>
	
					<tr>
	
						<td colspan="3"></td>
	
					</tr>
					<tr>
	
						<td colspan="3"></td>
					</tr>
	
	
	
					<tr>
	
						<td colspan="3"></td>
					</tr>
					<tr>
						<th>Pushback</th>
						<td><?php echo $fuelLeftPushback;?></td>
						<td><?php echo $fuelRightPushback; ?>		</td>
					</tr>
					<tr>
						<th>Pushback Both</th>
						<td colspan="2"><?php echo $fuelBothPushback;?></td>
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


<script type="text/javascript">

	

	
	var mission_id = <?php if (isset($missionId)) echo $missionId; else echo -1;?>;

	if(mission_id == -1){
		
		$('#content').empty();
		
		$('<p style="font-size: 16px;font-weight: bolder;color: black;">No Missions at given values</p><br/>').appendTo('#content'); 

	}

	

</script>