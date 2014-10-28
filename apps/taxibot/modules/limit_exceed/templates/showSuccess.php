<?php use_helper( 'Global', 'Javascript',  'Selection' );
echo selectionFilter ( array (
		'Tag' 
), null, $route, array (
		'Taxibot','LimitExceed'  
), '', true, false );

ini_set ( "memory_limit", "2048M" );
set_time_limit ( 1500 );
?>
<div id="content">
	<div id="table_container">
		<table class="daten" id="exceeds-table" border="1" >
			<thead>
				<tr>
					<th>Limit</th>
					<th>Tail Number</th>
					<th>Taxibot Number</th>
					<th>Flight Number</th>
					<th>AC Type</th>
					<th>Start Time</th>
					<th>Duration</th>
					<th>AC Weight (Ton)</th>
					<th>C.G. (%) </th>
					<th>Position Lat/Lon (Deg)</th>
				</tr>
			</thead>
		<tbody>
		
		
		<?php foreach ( $missionExceeds as $missionExceedEvents ) :
				foreach ( $missionExceedEvents ['exceeds'] as $exceed ) :?>				
				<tr style="background: #DDDDDD;" >					
					<td><?php echo $exceed->getExceedType(); ?></td>			
					<td><?php echo $missionExceedEvents['tailNumber']; ?></td>		  						
					<td><?php echo $missionExceedEvents['tractor']; ?> </td>								
					<td><?php echo $missionExceedEvents['flightnumber']; ?></td>					
					<td><?php echo $missionExceedEvents['AcType']; ?></td>											
					<td><?php echo $exceed->getStartTime(); ?></td>									
					<td><?php echo $exceed->getDuration(); ?></td>									
					<td><?php echo $missionExceedEvents['aircraftWeight']; ?></td>								
					<td><?php echo $missionExceedEvents['CG']; ?></td>											
					<td data-position-long="<?php echo $exceed->getLongitude()?>"
					 	data-position-lat="<?php echo $exceed->getLatitude()?>"
					 	class="position-exceed"><?php echo $exceed->getLatitude() . " \  " . $exceed->getLongitude() ; ?> </td>			
				</tr>
		<?php endforeach; 
			endforeach; ?>
		
		
		</tbody>



		</table>
		
	<!-- 	Export Button -->
	<div>
		<br /> 
		<?php echo link_to( 'Export Data' , "limit_exceed/export?file=$exportFilename")?>
	</div>
		
		
	</div>
</div>