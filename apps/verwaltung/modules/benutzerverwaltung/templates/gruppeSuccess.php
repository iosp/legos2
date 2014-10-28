<?php use_helper( 'Javascript' )?>

<h1>Benutzer <?php echo $benutzer ?> (Login: "<?php echo $benutzer->getLogin() ?>")</h1>

<div id="gruppe" style="float: left; width: 400px;">
	<h2>Gruppenzugehörigkeiten des Benutzers</h2>
	<?php if( isset( $zugeordnete_gruppen ) ): ?>
		<?php
		
include_partial ( 'benutzerverwaltung/list_gruppen', array (
				'titel' => 'Zugeordnete Gruppen',
				'gruppen' => $zugeordnete_gruppen,
				'benutzerID' => $benutzer->getID (),
				'zugeordnete' => true 
		) )?>
	<?php endif; ?>
	<?php if ( isset( $nicht_zugeordnete_gruppen ) ): ?>
		<?php
		
include_partial ( 'benutzerverwaltung/list_gruppen', array (
				'titel' => 'Nicht zugeordnete Gruppen',
				'gruppen' => $nicht_zugeordnete_gruppen,
				'benutzerID' => $benutzer->getID (),
				'zugeordnete' => false 
		) )?>
	<?php endif; ?>
</div>

<div id="module" style="float: left; width: 400px;">
	<h2>Individuell freigeschaltete Module des Benutzers</h2>
	<?php if ( isset( $zugeordnete_module ) ): ?>
		<?php
		
include_partial ( 'benutzerverwaltung/list_module', array (
				'titel' => 'Zugeordnete Module',
				'module' => $zugeordnete_module,
				'benutzerID' => $benutzer->getID (),
				'zugeordnete' => true 
		) )?>
	<?php endif; ?>
	<?php if ( isset( $nicht_zugeordnete_module ) ): ?>
		<?php
		
include_partial ( 'benutzerverwaltung/list_module', array (
				'titel' => 'Nicht zugeordnete Module',
				'module' => $nicht_zugeordnete_module,
				'benutzerID' => $benutzer->getID (),
				'zugeordnete' => false 
		) )?>
	<?php endif; ?>
</div>
<div style="clear: both;"></div>

<br />
<?php echo link_to( 'Zurück', 'benutzerverwaltung/list', array( 'class' => 'pfeil' ) )?>
<div style="clear: both;"></div>
