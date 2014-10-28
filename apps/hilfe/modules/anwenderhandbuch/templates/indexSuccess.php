<?php use_helper( 'Partial' )?>

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
				<div
					style="position: absolute; width: 500px; margin: 2px 0px 0px 300px; border: 2px solid red; padding: 5px;">
					<b>Vorsicht!</b> Dieses Testsystem ist mit der <u>Datenbank des
						aktuellen Legos-Systems</u> verknüpft. Alle Änderungen werden
					somit direkt ins aktuelle Legos übernommen.
				</div>
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
			<h1>LEGOS-Anwenderhandbuch</h1>
			Hier gibt es das komplette Anwenderhandbuch in der aktuellen Version zum Download: <?php echo link_to( image_tag( 'icons/page_white_acrobat.png', array( 'size' => '16x16', 'alt' => 'PDF-Export', 'title' => 'PDF-Export', 'border' => '0' ) ) . " LEGOS-Anwenderhandbuch", 'anwenderhandbuch/download', array( 'query_string' => 'pdf=LEGOS-Anwenderhandbuch.pdf' ) )?>
			<?php include_partial( 'handbuch', array( ) )?>
			
			<a name="changelog"><h1>Letzte Änderungen</h1></a>
			<?php include_partial( 'changelog' )?>
			
		</div>

		<div id="page_footer">
			<div class="links">&#169; Lufthansa LEOS 2012</div>
			<div class="rechts"><?php echo renderImpressum(); ?></div>
		</div>

	</div>
</body>
</html>
