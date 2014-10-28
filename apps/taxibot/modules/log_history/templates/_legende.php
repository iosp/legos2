<div class="legende">
	<table>
		<?php foreach ( $vorgangsarten as $vorgangsart ): ?>
			<tr>
			<td style="width: 1.2em; background-color:<?php echo ermittleFarbe( $vorgangsart ) ?>">&nbsp;</td>
			<td style=""><?php echo $vorgangsart ?></td>
		</tr>
		<?php endforeach ?>
			<tr>
			<td style="width: 1.2em; background-color:<?php echo ermittleFarbe( "Werkstatt" ) ?>">&nbsp;</td>
			<td style="">Nicht fahrbereit</td>
		</tr>
	</table>
</div>
