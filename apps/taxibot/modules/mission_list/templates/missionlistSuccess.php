<?php  
use_helper ( 'Global', 'Javascript', 'Selection' );
echo selectionFilter ( array (
		'Tag' 
), null, $route, array (
		'Taxibot',
		'MissionList' 
), '', true, false );

use_stylesheet("app/taxibot/mission_list/index.css" );

if($from_date != null){ ?>

<div id="time_interval_table_container">
	<div style="float: left; margin-right: 20px">
		<table class="time_interval" id="time_interval_table" border="1"
			style="height: 40px; width: 120px;">
			<tbody>
				<tr>
					<th style="font-size: 15px;">From</th>
				</tr>
				<tr>
					<th><?php echo $from_date . " " . $fromTime. ":00"; ?></th>
				</tr>
			</tbody>
		</table>
	</div>
	<div style="float: left; margin-right: 20px">
		<table class="time_interval" id="time_interval_table" border="1"
			style="height: 40px; width: 120px;">
			<tbody>
				<tr>
					<th style="font-size: 15px;">To</th>
				</tr>
				<tr>
					<th><?php echo $to_date ." ". $toTime. ":00";?></th>
				</tr>
			</tbody>
		</table>
	</div>
	<?php  dd($flightNumber); if($flightNumber != ''){?>
	<div style="float: left; margin-right: 20px">
		<table class="time_interval" id="time_interval_table" border="1"
			style="height: 40px; width: 120px;">
			<tbody>
				<tr>
					<th style="font-size: 15px;">Flight Number</th>
				</tr>
				<tr>
					<th><?php echo $flightNumber;?></th>
				</tr>
			</tbody>
		</table>
	</div>
	<?php }?>
</div>

<?php } ?>

<div class="row">
	<div class="col-md-10">
		<div id="mode_table_container">
			<table class="daten table" id="taxibot-missions-list" cellpadding="5"
				data-order="3" data-order-type="desc">
				<thead>
					<tr>
						<th><input title="Reset all checkboxes" class="reset-checkboxes" type="checkbox"/></th>
						<th class="th-operational">Operational Scenario <?php if ($group == USER_GROUP::ADMIN || $group == USER_GROUP::EDITOR) { echo image_tag( 'edit1.png' , array('class' => 'th-edit-icon', 'size' => '15x15')); }?></th>
						<th>Flight Number<?php  if ($group == USER_GROUP::ADMIN || $group == USER_GROUP::EDITOR) { echo image_tag( 'edit1.png' , array('class' => 'th-edit-icon', 'size' => '15x15')); }?></th>
						<th>Starting Date Time<?php if ($group == USER_GROUP::ADMIN || $group == USER_GROUP::EDITOR) { echo image_tag( 'edit1.png' , array('class' => 'th-edit-icon', 'size' => '15x15')); } ?></th>
						<th>Taxibot Number</th>
						<th>Tail Number</th>
						<th>Mission Type</th>
					</tr>
				</thead>
				<tbody>
			<?php foreach($missions as $mission): ?>
			<tr data-mission-id="<?php echo $mission['id']; ?>" data-is-approved="<?php echo $mission['isApproved'];  ?>"
				<?php if($mission['isApproved'] == "0"){
					echo "title='Un-Approved' ";
				} 
				
				?>
			
			>
						<td class="checkbox-row"><input type="checkbox"></td>
						<td class="td-edit-select-operational"
							data-property-name="operationalType">
							
							<?php
								$operationals = array ('0' => "", '1' => "Operational",'2' => 'Test', '3' => 'Train');
							
								if ($group == USER_GROUP::ADMIN || $group == USER_GROUP::EDITOR) {
									$operationals['0'] = '-- select operational scenario --';
									?>
									<select class="operaional-select selectpicker" data-selected="<?php echo $mission ['operationalType']; ?>">
										<?php										
										foreach ($operationals as $key => $value){
											echo "<option value='$key' ";
											if ($key == $mission ['operationalType']) {
												echo " selected ";
											}
												echo ">$value</option>" ;
											}
										?>
		        					</select>
								<?php	
								} else {
									echo $operationals[ $mission ['operationalType']];
								} 
							?>							
        				</td>
						<td class="td-edit-text" data-property-name="flightNumber"><?php echo $mission['flightNumber']; ?></td>
						<td class="td-edit-text date-format"
							data-property-name="startDate"><?php echo $mission['startDateTime']; ?></td>
						<td><?php echo $mission['taxibotNumber']; ?></td>
						<td><?php echo $mission['tailNumber']; ?></td>
						<td><?php echo $mission['missionType']; ?></td>
					</tr>
			<?php endforeach; ?>		
		</tbody>
			</table>
		</div>

	</div>

	<div class="col-md-2">
		<div id="buttons">
		<div class="mission-button disabled" id="mission-page">
				<div class="yellow-button disabled"></div>
				Mission page
			</div>
			<div class="mission-button disabled" id="mission-delete">
				<div class="yellow-button disabled"></div>
				Delete
				<div id="delete-indicator" class="undisplay-indicator"><?php echo image_tag( 'indicator.gif' )?></div>
			</div>
			<div class="mission-button disabled" id="mission-merge">
				<div class="yellow-button disabled"></div>
				Merge
				<div id="merge-indicator disabled"
					class="action-indicator undisplay-indicator"><?php echo image_tag( 'indicator.gif' )?></div>
			</div>
			<div class="mission-button disabled" id="mission-split">
				<div class="yellow-button disabled"></div>
				Split
			</div>			
		<?php if($isafterUploading){?>
			<div class="mission-button disabled" id="mission-confirm">
				<div class="yellow-button disabled"></div>
				Approve
				<div id="cofirm-indicator disabled"
					class="action-indicator undisplay-indicator"><?php echo image_tag( 'indicator.gif' )?></div>
			</div>
		<?php } ?>
	</div>
	</div>
</div>

<?php
use_javascript ( "app/taxibot/mission_list/index.js" );
if ($group == USER_GROUP::ADMIN || $group == USER_GROUP::EDITOR) {
	use_javascript ( "app/taxibot/mission_list/edit.js" );
}
?>