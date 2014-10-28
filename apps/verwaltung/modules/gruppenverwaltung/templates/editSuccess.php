<?php use_helper('Javascript')?>

<h1>Grupppenverwaltung</h1>

<p><?php echo link_to( 'Zurück zur Übersicht', 'gruppenverwaltung/index', array( 'class' => 'pfeil' ) ) ?></p>

<h2>Einstellungen der Gruppe "<?php echo $gruppenname?>"</h2>

<?php $modulcounter = 0;?>	
<?php foreach( $erlaubteModule as $topmenu_entry ): ?>
<div class="appblock gruppenverwaltung">
	<ul class="bildheader">
		<li>
				<?php echo image_tag(str_replace(' ','',strtolower($topmenu_entry['applikation_link'])).'_header.png',array( 'alt' => 'Foto LEOS', 'title' => 'Foto LEOS', 'width' => '170', 'height' => '39', 'border' => '0' ))?>
			</li>
	</ul>
	<ul class="applikation">
		<li>
				<?php echo $topmenu_entry['applikation']?>
			</li>
	</ul>
	<ul class="modul">
			<?php foreach( $topmenu_entry['module'] as $modul ): ?>
				<?php $modulname = str_replace( " ", "_", strtolower( $topmenu_entry['applikation'] . "-" . key($modul) ) )?>
				<?php $erlaubt = in_array( $modulname, $zugeordnete_modulename ) // true, wenn Gruppe Rechte für das Modul hat ?>				<?php $credential= $topmenu_entry['applikation_link'] . "-" . key($modul)?>
				<li id="modul_<?php echo $modulcounter; ?>">
					<?php
		
include_partial ( 'menu_eintrag', array (
				'mod_name' => current ( $modul ),
				'erlaubt' => $erlaubt,
				'credential' => $credential,
				'divname' => "modul_" . $modulcounter,
				'gruppe' => $gruppeId 
		) )?>
				</li>
				<?php $modulcounter++;?>
			<?php endforeach; ?>
		</ul>
</div>
<?php endforeach; ?>

<?php

include_partial ( 'werkstattkundenZuordnung', array (
		'gruppe_id' => $gruppeId,
		'gruppe_kunden' => $gruppe_kunden,
		'nicht_zugeordnet' => $nicht_zugeordnete_kunden 
) );
