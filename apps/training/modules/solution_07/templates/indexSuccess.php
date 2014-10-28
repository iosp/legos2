<div id="auswahlfilter" style="margin-left: -282px;">
	<div id="inhalt"
		style="width: 281px; height: 200px; background-color: yellow">
		Selection Box Content</div>
	<div id="fahne">
		<?php echo image_tag( 'pin_fahne_optionen_geschlossen.png', array( 'width' => '25', 'id' => 'pin_geschlossen' ) ); ?>
		<?php echo image_tag( 'pin_fahne_optionen_offen.png', array( 'width' => '25', 'id' => 'pin_offen' ) ); ?>
	</div>
</div>

<script type="text/javascript">
	jQuery(document).ready( function() {
		jQuery("#pin_offen").hide();
		auswahlfilter_einblenden();
	});

	/**
	 * Hide Selection Box
	 */
	function auswahlfilter_ausblenden() {

		jQuery('#pin_offen').hide();
		jQuery('#pin_geschlossen').show();
		
		jQuery('#auswahlfilter').animate({
			'marginLeft': '-' + (jQuery('#inhalt').width() + 2) + 'px'
			}, 500, function() {
				jQuery('#pin_geschlossen').one('click', auswahlfilter_einblenden);
			}
		);
	}

	/*
	 * Show Selection Box
	 */
	function auswahlfilter_einblenden() {

		jQuery('#pin_geschlossen').hide();
		jQuery('#pin_offen').show();
	
		jQuery('#auswahlfilter').animate({
			'marginLeft': '0px'
			}, 500, function() {
				jQuery('#pin_offen').one('click', auswahlfilter_ausblenden);
			}
		);
	}
</script>