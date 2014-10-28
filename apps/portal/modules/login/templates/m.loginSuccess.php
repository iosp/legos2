<div class="box-shadow" style="float: left"><?php echo image_tag('mobile.png', array( 'class' => 'shadow', 'border' => '0', 'alt' => 'Mobile' ))?></div>
<div class="table">
	<table id="login">
		<thead>
			<tr>
				<td colspan="2">LEGOS Mobile Log-in</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td id="zell_login"><?php include_partial( 'form', array( 'form' => $form ) ) ?></td>

			</tr>
		</tbody>
	</table>
</div>
<div style="clear: both"></div>