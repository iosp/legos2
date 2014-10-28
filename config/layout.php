<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<?php include_http_metas() ?>
	<?php include_metas() ?>
	<?php include_title() ?>
	<link rel="shortcut icon" href="/favicon.ico" />
</head>

<body>
	<div id="page">
		
		<div id="page_header">
		
			<div id="blauer_balken"></div>
			
			<div id="logo_menu_zeile">
				<div class="links"><?php echo image_tag( 'LEOS-Logo_claim.png' )?></div>
				<div id="anmeldestatus" class="rechts"><?php  include_partial( 'global/anmeldeStatus' ) ?></div>
				<div id="menu" class="links">
					<?php echo renderMenu(); // Läuft über den Helper /lib/helper/MenuHelper ?>
				</div>
			</div>
			
			<div id="legos_logo_zeile" class="rechts">
				<?php echo image_tag('logo_legos.png')?>
			</div>
			
			<div id="legos_logo_text_zeile" class="rechts">
				LEOS Ground Operational Statistics For <b><i>Taxibot</i></b> Vehicles
			</div>
			
		</div>
		
		
		
		<div id="page_content">
			<?php echo $sf_content ?>
			
			<?php // Hier landet der Inhalt der Templates und  das wird auch per Ajax aktualisiert ?>
			<div id="container-modulinhalt"></div>
			
			<?php // Animiertes Bild, das während Ajax-Reloads gezeigt wird ?>
			<div id="ajax_loading" style="display:none; text-align: center; margin-top: 30px">
				<?php echo image_tag('ajax_loading.gif',array( 'alt'=>'Laden...') ) ?>
			</div>
		</div>
		
		
		<br /><br />

	
		<hr>
	
		<br /><br />
		
		<div id="page_taxibot_header">
			<div id="iai_logo_zeile" class="links" style="margin-left: 30px">
				<?php echo image_tag('iaiLogo.gif', 'size=128x64') ?>
			</div>
			<div id="taxibot_logo_zeile" class="rechts" style="margin-right: 30px">
				<?php echo image_tag('taxibotLogo.png', 'size=128x64') ?>
			</div>
		     
		</div>
		<br /><br />
	
		<hr>
	
		<br /><br />
		
		<div id="page_footer">
			<div class="links">&#169; Lufthansa LEOS <?php echo date("Y");?></div>
			<div class="rechts"><?php // echo renderImpressum(); ?></div>													
		</div>
		
	</div>
</body>
</html>
