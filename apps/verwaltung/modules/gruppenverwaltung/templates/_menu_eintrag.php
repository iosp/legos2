<?php use_helper('Javascript')?>
<div class="modul_<?php echo $erlaubt ? "erlaubt" : "nicht_erlaubt" ?>">
	<?php
	
echo link_to_remote ( $mod_name, array (
			'url' => 'gruppenverwaltung/ToggleZuordnung' . '?credential=' . $credential . '&mod_name=' . $mod_name . '&gruppe=' . $gruppe . '&div=' . $divname,
			'update' => $divname 
	) )?>
</div>
