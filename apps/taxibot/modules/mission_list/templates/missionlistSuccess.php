<?php

use_helper ( 'Global', 'Javascript', 'Selection' );
echo selectionFilter ( array (
		'Tag' 
), null, $route, array (
		'Taxibot',
		'MissionList' 
), '', true, false );
?>

<?php use_stylesheet("app/taxibot/mission_list/index.css" );?>

<div id="time_interval_table_container" >
	<div style="float: left; margin-right: 20px">
		<table class="time_interval" id="time_interval_table" border="1" style="height: 40px; width: 120px;">
			<tbody>
				<tr>
					<th style="font-size: 15px;">From</th>
				</tr>
				<tr>
					<th><?php echo $from_date == null ? "ALL" : $from_date?></th>
				</tr>
			</tbody>
		</table>
	</div>
	<div style="float: left; margin-right: 20px">
		<table class="time_interval" id="time_interval_table" border="1" style="height: 40px; width: 120px;">
			<tbody>
				<tr>
					<th style="font-size: 15px;">To</th>
				</tr>
				<tr>
					<th><?php echo $to_date == null ? "ALL" : $to_date?></th>
				</tr>
			</tbody>
		</table>
	</div>	
</div>

<div >
	<div id="mode_table_container" class="col-md-10">
		<table class="daten table" id="taxibot-missions_list"  cellpadding="5">
		 <col width="10"/>
		 <col width="10"/>
		 <col width="10"/>
		 <col width="10"/>
		 <col width="10"/>	
		 <col width="10"/>
		 <col width="10"/>		
		 
			<thead>
				<tr>
					<th class="th-operational">Operational Scenario <?php echo image_tag( 'edit1.png' , array('class' => 'th-edit-icon', 'size' => '15x15'))?></th>
					<th>Flight Number<?php echo image_tag( 'edit1.png' , array('class' => 'th-edit-icon', 'size' => '15x15'))?></th>
					<th>Starting Date & Time<?php echo image_tag( 'edit1.png' , array('class' => 'th-edit-icon', 'size' => '15x15'))?></th>
					<th>Taxibot Number</th>
					<th>A/C Type</th>
					<th>Mission Type</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($missions as $mission): ?>
			<tr data-mission-id="<?php echo $mission['id']; ?>">
					<td class="td-edit-select-operational" data-property-name="operationalType">
						<select class="operaional-select selectpicker">						
						<?php						
							if($user->isAuthenticated()){
								$selectFirstRow = '-- select operational scenario --';
							}
							else{
								 $selectFirstRow = '';
							}
							
							$options = array(
								'0' => ' value="0">'. $selectFirstRow, 
								'1' => ' value="1">Operational',
								'2' => 'value="2">Test',
								'3' => 'value="3">Train') ;
							$indeSelected = $mission['operationalType'];
							
							for ($i = 0; $i < 4; $i++) {
								echo '<option ';
							    if($i == $indeSelected){
							   		echo "selected ";
							    }
							    echo $options[$i] . '</option>';
							}
          				?>
        				</select>
        			</td>
					<td class="td-edit-text" data-property-name="flightNumber"><?php echo $mission['flightNumber']; ?></td>
					<td class="td-edit-text date-format" data-property-name="startDate"><?php echo $mission['startDateTime']; ?></td>
					<td><?php echo $mission['taxibotNumber']; ?></td>
					<td><?php echo $mission['acNumber']; ?></td>
					<td><?php echo $mission['missionType']; ?></td>
				</tr>
			<?php endforeach; ?>		
		</tbody>
		</table>
	</div> 

	<div id="buttons"  class=".col-md-2">		
		<div class="mission-button" id="mission-delete">
			<div class="yellow-button"></div>
			Delete
			<div id="delete-indicator" class="undisplay-indicator"><?php echo image_tag( 'indicator.gif' )?></div>
		</div>
		<div class="mission-button" id="mission-merge">
			<div class="yellow-button"></div>
			Merge
			<div id="merge-indicator" class="action-indicator undisplay-indicator"><?php echo image_tag( 'indicator.gif' )?></div>
		</div>
		<div class="mission-button" id="mission-split">
			<div class="yellow-button"></div>
			Split
		</div>
		<div class="mission-button" id="mission-mission-page">
			<div class="yellow-button"></div>
			Mission page
		</div>
		<div class="mission-button" id="mission-confirm">
			<div class="yellow-button"></div>
			Confirm
		</div>
	</div>

</div>

<?php 
	if($user->isAuthenticated()){
		use_javascript("app/taxibot/mission_list/indexa.js");	 
	}
	else{
		use_javascript("app/taxibot/mission_list/index.js");
	}
?>