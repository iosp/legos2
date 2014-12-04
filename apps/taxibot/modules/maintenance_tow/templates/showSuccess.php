<?php use_helper( 'Global', 'Javascript',  'Selection' );
echo selectionFilter ( array (
		'Einzeltag' 
), null, $route, array (
		'Taxibot',
		'Maintenance' 
), '' ,true, false);
?>
<?php
ini_set ( "memory_limit", "2048M" );
set_time_limit ( 1500 );
use_helper ( 'Global', 'Javascript' );
use_javascript ( 'jquery.min.js' );

?>

<style>
	
	table{
		text-align: center;
		border-collapse:collapse;
	}
	
	table td {
		padding: 2px
	}
	
	table.data {
		clear: both;
		width: auto;
		font-size: 10px;
		
		border: 4px solid #111111;
	}


	table.data tbody th {
		width: 250px;
		height: 20px;
	
		border-right: 2px solid #111111;
		border-bottom: 1px solid #111111;

	}
	table.data tbody td {
		width: 100px;
		height: 20px;
		border-left: 2px solid #111111;
		border-right: 4px solid #111111;
		border-bottom: 1px solid #111111;
		text-align: center;

	}
	
	table.data  tbody tr:nth-child(5n+1) td, table.data  tbody tr:nth-child(5n+1) th{
		border-Top: 4px solid #111111;
	}

	table.data  tbody tr:nth-child(5n+5) td, table.data  tbody tr:nth-child(5n+5) th{
		border-bottom: 4px solid #111111;
	}
	
	table.data  tbody tr:nth-child(even) td, table.data tbody  tr:nth-child(even) th{
		background-color: #EEEEEE;
	}

	table.data tbody  tr:nth-child(odd) td, table.data  tbody tr:nth-child(odd) th{
		background-color: #FFFFFF;
	}

	table.data  tbody  tr:hover td, table.data tbody   tr:hover th {
		background-color: #FFBA17;
	}
	

	
	

</style>

<div id="content">	
<h1 style="font-size: x-large;">Maintenance Tow</h1>

	<div id="time_interval_table_container" style="float:left;margin-right: 17px">
		<table class="time_interval" id="time_interval_table" border="1" style="height: 40px; width: 150px">
			<tbody>
				<tr>
					<th>Date</th>
					<td><?php echo $from_str;?> </td>
				</tr>
			</tbody>
		</table>
	</div>
	
	<div id="tail_number_table_container">
		<table  id="tail_number_table" border="1" style="float:left;margin-right: 17px; height: 40px; width: 150px">
			<tbody>
				<tr>
					<th>Tail Number</th>
					<td>  <?php echo $tailNumber;?> </td>
				</tr>		
			</tbody>
		</table>
	</div>
	
	<div id="taxibot_number_table_container">
		<table  id="taxibot_number_table" border="1" style="height: 40px; width: 150px">
			<tbody>
				<tr>
					<th>Taxibot number</th>
					<td>  <?php echo $selected_taxibot_name;?> </td>
				</tr>		
			</tbody>
		</table>
	</div>
	
	
	<div id="hours_per_fuel_table_container">
			<h2 style="font-size: large;">Hours/Fuel</h2>
			
			<table class="daten" id="taxibot-towing" border="1">
			<thead>
				<tr>
				 	<th>Maint-Tow Start</th>
				 	<th>Maint-Tow End</th> 
				 	<th>Maint Time </th>
				 	<th>Left Engine Fuel</th>
				 	<th>Right Engine Fuel</th>
				</tr>
			</thead>
			<tbody>		
			
			<?php foreach ($mainTows as $maint) : ?>
					<tr style="background: #DDDDDD;">						 
						<td><?php echo $maint->maintStartDate;?></td>				 
						<td><?php echo $maint->maintEndDate;?></td>				 
						<td><?php echo $maint->maintTotalTime;?></td>				 
						<td><?php echo $maint->leftEngineFuel;?></td>
						<td><?php echo $maint->rightEngineFuel;?></td>
					</tr>
				<?php endforeach;?>		
			</tbody>
		</table>
		
	<!-- 	Export Button -->
	<div>
		<br /> 
		<?php echo link_to( 'Export Data' , "maintenance_tow/export?file=$exportFilename")?>
	</div>
	</div>		
</div>

<script type="text/javascript">
if( <?php echo count($mainTows) > 0 ? 'false': 'true' ?>){
	$('#content').empty();
	$('<p style="font-size: 16px;font-weight: bolder;color: black;">No Missions at given values</p><br/>').appendTo('#content');
}
</script>

<!-- <script  type="text/javascript"
 /* <?php use_javascript("app/taxibot/maintenanceShow.js");?> */ 
 <!-- /> -->