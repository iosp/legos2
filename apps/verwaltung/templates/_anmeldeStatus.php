<div class="anmeldestatus">
	<?php if ( $sf_user->isAuthenticated() ): ?>
		Angemeldet als: <?php echo $sf_user->getAttribute( 'name', '', 'benutzer' ); ?> &nbsp
		<?php include_component_slot( 'hilfe' ) ?> 
		<?php echo link_to( 'Abmelden ', sfConfig::get('app_url_portal'). "/logout", array( 'class' => 'pfeil' ) ); ?>
	<?php else: ?>
		<?php echo link_to( 'Anmelden ', sfConfig::get('app_url_portal'). "/login", array( 'class' => 'pfeil' ) ); ?>
	<?php endif; ?>
</div>
