<?php use_stylesheet("app/portal/homePage.css"); ?>
<div class="container">
	<div class="row">
		<h3>Welcome to LEGOS IAI!</h3>
		<p>
			You are in the statistical analysis portal of Lufthansa LEOS for
			Taxibot activities. <br> The following modules are available:
		</p>
	</div>

	<div class="row">
		<div class="col-md-6">
<?php foreach( $erlaubteModule as $applikation ): ?>
<div class="appblock">
				<ul class="bildheader">
					<li>
				<?php echo image_tag(str_replace(' ','',strtolower($applikation['applikation_link'])).'_header.png',array( 'alt' => 'Foto LEOS', 'title' => 'Foto LEOS', 'width' => '170', 'height' => '39', 'border' => '0' ))?>
			</li>
				</ul>
				<ul class="applikation">
					<li>
				<?php echo $applikation['applikation']?>
			</li>
				</ul>
				<ul class="modul">
				<?php foreach( $applikation['module'] as $modul ): ?>
				<li>
					<?php echo link_to( current($modul), sfConfig::get( 'app_url_' . $applikation['applikation_link'] ) . '/' . key($modul) . '/index', array('class' => 'pfeil') )?>
				</li>
				<?php endforeach; ?>
			</ul>
			</div>
	<?php endforeach; ?>
		</div>
		
<?php if($sf_user->getUserGroup() == USER_GROUP::ADMIN || $sf_user->getUserGroup() == USER_GROUP::EDITOR){ ?>
		<div id="homePageLimitExceed" class="col-md-6">			
			<div id="table_container">
				<table class="daten" id="taxibot-towing" border="1" titel="Recent Limit Exceed">
					<thead>
						<tr>
							<th>Limit Type</th>
							<th>Tail Number</th>
							<th>Taxibot Number</th>
							<th>Flight Number</th>
							<th>AC Type</th>
						</tr>
					</thead>
					<tbody>
			
			<?php
			foreach ( $limitExceeds as $limitExceed ) :
				?>
				<tr style="background: #DDDDDD;">
							<td><?php echo $limitExceed["EXCEED_TYPE"]; ?></td>
							<td><?php echo $limitExceed['AIRCRAFT_TAIL_NUMBER']; ?></td>
							<td><?php echo $limitExceed['TRACTOR_NAME']; ?></td>
							<td><?php echo $limitExceed['FLIGHT_NUMBER']; ?></td>
							<td><?php echo $limitExceed['AIRCRAFT_TYPE']; ?></td>
						</tr>
					<?php
			endforeach;
			?>
			</tbody>
				</table>
			</div>
		</div>
<?php }?>
		</div>
</div> 