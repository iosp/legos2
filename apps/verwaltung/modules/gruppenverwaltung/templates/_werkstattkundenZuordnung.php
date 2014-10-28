<br /><?php // br, um aus dem Float der Applikationsblöcke raus zu kommen. ?>

<div style="display: inline-block; vertical-align: top;">
	<?php if( count( $gruppe_kunden ) > 0 ): ?>
		<table class="normal">
		<thead>
			<tr>
				<th colspan="2">Zugeordnete<br />Werkstatt-Kunden
				</th>
			</tr>
		</thead>
		<tbody>
				<?php $i=0; ?>
				<?php foreach( $gruppe_kunden as $gruppe_kunde ): ?>
					<tr
				class="<?php (($i % 2) == 0) ? print "ungerade" : print "gerade" ?>">
				<td><?php echo $gruppe_kunde->getWerkstattKunde() ?> </td>
				<td>
							<?php echo link_to( image_tag( 'delete' ), 'gruppenverwaltung/deleteWerkstattKunde', array( 'query_string' => 'gruppe_id='.$gruppe_id.'&kunde_id='.$gruppe_kunde->getWerkstattKundeId() ) ) ?><br />
				</td>
			</tr>
					<?php $i++?>
				<?php endforeach; ?>
			</tbody>
	</table>
	<?php endif; ?>
</div>

<div style="display: inline-block; vertical-align: top;">
	<?php if( count( $nicht_zugeordnet ) > 0 ): ?>
		<table class="normal">
		<thead>
			<tr>
				<th colspan="2">Nicht zugeordnete<br />Werkstatt-Kunden
				</th>
			</tr>
		</thead>
		<tbody>
				<?php $i=0; ?>
				<?php foreach( $nicht_zugeordnet as $kunde ): ?>
					<tr
				class="<?php (($i % 2) == 0) ? print "gerade" : print "ungerade" ?>">
				<td><?php echo $kunde ?></td>
				<td>
							<?php echo link_to( image_tag( 'add' ), 'gruppenverwaltung/addWerkstattKunde', array( 'query_string' => 'gruppe_id='.$gruppe_id.'&kunde_id='.$kunde->getId() ) ) ?><br />
				</td>
				</td>
					<?php $i++?>
				<?php endforeach; ?>
			
		
		</tbody>
	</table>
	<?php endif; ?>
</div>
