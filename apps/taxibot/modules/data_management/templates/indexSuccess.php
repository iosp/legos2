<style>
.cub {
	padding: 3px;
	float: left;
	background: gainsboro;
	width: 300px;	
	margin: 0 40px; 
}

.title-cub {
	font-size: 15px;	
	color: white;
	font-weight: bold;
	background-color: #FFBA17;
}

.th-edit-icon{
	cursor: pointer;
	text-align: center;
}

.th-edit-icon:active{
	width: 20px;
	height: 20px;
}

.content-cub {
	padding: 20px;
}

.internal-cubs {
	margin-bottom: 25px;
}

.first-cell + td{
	width: 44%;
}

table,th,td {
	border: 1px solid black;
	border-collapse: collapse;
	padding: 3px;
}

.internal-cub-title {
	text-align: center;
	color: white;
	background: #4a4a4a;
}

.first-cell {
	background: gray;
	color: #FFBA17;
	width:44%;
}

.rects {
	font-size: 13px;
}
</style>


<h1>Settings</h1>
<br />

<div class="rects">	 

	<div id="settingCub" class="cub">
		<div class="title-cub">Setting</div>
		<div class="content-cub">
			<div class="internal-cubs">
				<table style="width: 100%" border="1">
					<tr class="internal-cub-title">
						<td colspan="3">Limit Exceed Definitions</td>
					</tr>
					<tr>
						<td colspan="3">Fatigue:</td>
					</tr>					 
					<tr data-force="f" data-aircraft="b" data-angle="long">
						<th class="first-cell">Long Boeing</th>
						<td><span class="limit-value"><?php echo $boeing->getLongFatigueLimitValue(); ?> </span><span> kN</span></td>
						<?php  if ($sf_user->getUserGroup() == USER_GROUP::ADMIN || $sf_user->getUserGroup() == USER_GROUP::EDITOR) { 
							echo '<td class="edit-icon-td">'. image_tag( 'edit1.png' , array('class' => 'long-fatg-boeing-edit th-edit-icon', 'size' => '15x15')). '</td>'; 
						}?>
					</tr>
					<tr data-force="f" data-aircraft="a" data-angle="long">
						<th class="first-cell">Long Airbus</th>						
						<td > <span class="limit-value"><?php echo $airbus->getLongFatigueLimitValue() ?> </span><span> kN</span></td>
						<?php  if ($sf_user->getUserGroup() == USER_GROUP::ADMIN || $sf_user->getUserGroup() == USER_GROUP::EDITOR) {
							echo '<td class="edit-icon-td">'. image_tag( 'edit1.png' , array('class' => 'long-fatg-airbus-edit th-edit-icon', 'size' => '15x15')). '</td>'; }?>
					</tr>
					<tr>
						<td colspan="3">Safe:</td>
					</tr>
					<tr data-force="s" data-aircraft="b" data-angle="lat">
						<th class="first-cell">Lat Boeing</th> 
						<td><span class="limit-value"><?php echo $boeing->getLatStaticLimitValue(); ?> </span><span> kN</span></td>
						<?php  if ($sf_user->getUserGroup() == USER_GROUP::ADMIN || $sf_user->getUserGroup() == USER_GROUP::EDITOR) {
							echo '<td class="edit-icon-td">'. image_tag( 'edit1.png' , array('class' => 'lat-safe-boeing-edit th-edit-icon', 'size' => '15x15')). '</td>'; }?>
					</tr>
					<tr data-force="s" data-aircraft="a" data-angle="lat">
						<th class="first-cell">Lat Airbus</th>
						<td><span class="limit-value"><?php echo $airbus->getLatStaticLimitValue(); ?> </span><span> kN</span></td>						
						<?php  if ($sf_user->getUserGroup() == USER_GROUP::ADMIN || $sf_user->getUserGroup() == USER_GROUP::EDITOR) { 
							echo '<td class="edit-icon-td">'. image_tag( 'edit1.png' , array('class' => 'lat-safe-airbus-edit th-edit-icon', 'size' => '15x15')). '</td>'; }?>
					</tr>
					<tr data-force="s" data-aircraft="b" data-angle="long">
						<th class="first-cell">Long Boeing</th> 
						<td><span class="limit-value"><?php echo $boeing->getLongStaticLimitValue(); ?> </span><span> kN</span></td>
						<?php  if ($sf_user->getUserGroup() == USER_GROUP::ADMIN || $sf_user->getUserGroup() == USER_GROUP::EDITOR) {
							echo '<td class="edit-icon-td">'. image_tag( 'edit1.png' , array('class' => 'long-safe-boeing-edit th-edit-icon', 'size' => '15x15')). '</td>'; }?>
					</tr>
					<tr data-force="s" data-aircraft="a" data-angle="long" >
						<th class="first-cell">Long Airbus</th>
						<td><span class="limit-value"><?php echo $airbus->getLongStaticLimitValue(); ?> </span><span> kN</span></td>
						<?php  if ($sf_user->getUserGroup() == USER_GROUP::ADMIN || $sf_user->getUserGroup() == USER_GROUP::EDITOR) { 
							echo '<td class="edit-icon-td">'. image_tag( 'edit1.png' , array('class' => 'long-safe-airbus-edit th-edit-icon', 'size' => '15x15')). '</td>'; }?>
					</tr>
				</table>
			</div>
			<div class="internal-cubs">

				<table style="width: 100%" border="1">
					<tr class="internal-cub-title">
						<td colspan="2">Versions</td>
					</tr>
					<tr>
						<th class="first-cell">AC Data</th>
						<td>XXXXXXX</td>
					</tr>
					<tr>
						<th class="first-cell">Air field data</th>
						<td>XXXXXXX</td>
					</tr>
					<tr>
						<th class="first-cell">Application</th>
						<td>1.1.2</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>

<?php 
if ($sf_user->getUserGroup() == USER_GROUP::ADMIN || $sf_user->getUserGroup() == USER_GROUP::EDITOR) {
	use_javascript ( "app/taxibot/setting/index.js" );
}
?>