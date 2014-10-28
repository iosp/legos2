<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<?php include_http_metas()?>
	<?php include_metas()?>
	<?php include_title()?>
	<link rel="shortcut icon" href="/favicon.ico" />
</head>

<body>
	<div id="page">

		<div id="page_header">
			<div id="blauer_balken"></div>
			<div id="logo_menu_zeile">
				<div class="links"><?php echo image_tag( 'LEOS-Logo_claim.png' ) ?></div>
				<div id="anmeldestatus" class="rechts"><?php include_partial( 'global/anmeldeStatus' ) ?></div>
				<div id="menu" class="links">
					<?php echo renderMenu(); // Läuft über den Helper /lib/helper/MenuHelper ?>
				</div>
			</div>
			<div id="legos_logo_zeile" class="rechts">
				<?php echo image_tag('logo_legos.png')?>
			</div>

			<div id="legos_logo_text_zeile" class="rechts">LEOS Ground
				Operational Statistics</div>
		</div>

		<div id="page_content">
			<?php echo $sf_content?>
		</div>
		<div id="page_footer" style="height: 8px;">
			<div style="width: 15%; float: left; text-align: left;">&#169; Lufthansa LEOS <?php echo date("Y");?></div>
			<div
				style="width: 70%; float: left; text-align: center; color: #AA0000;"><?php	if ( preg_match('/MSIE 7.0/', $_SERVER['HTTP_USER_AGENT']) ){ echo "Das LEGOS-System ist für Internet Explorer ab Version 8 optimiert. Bitte nutzen Sie wenn möglich IE 8 oder höher bzw. Firefox oder Google Chrome.";} else{ echo "&nbsp;";} ?></div>
			<div style="width: 15%; float: left; text-align: right;"><?php echo renderImpressum(); ?></div>
		</div>

	</div>
</body>
</html>
