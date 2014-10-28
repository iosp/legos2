<?php

/**
 * Erstellt html-Code des Menüs entsprechend den Rechten des Nutzers
 * 
 * @return Array
 */
function renderMenu() {
	// Symfony's User-Objekt holen
	$user = sfContext::getInstance ()->getUser ();
	$aktiveApplikation = sfContext::getInstance ()->getConfiguration ()->getApplication ();
	
	// YAML-Datei mit Menüstruktur laden
	$menu = sfYaml::load ( sfConfig::get ( 'sf_root_dir' ) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'menu.yml' );
	/*print "<pre>";
	print_r($topmenu_entry);
	print "</pre>"; die();*/
	/*
	 * Menü je nach Berechtigungen der Nutzers kürzen
	 */
	if (! $user->isAuthenticated ()) {
		// Leeres Array ans Template übergeben.
		$menu = array ();
	} else {
		foreach ( $menu as $topmenu_key => $topmenu_entry ) {			
			if (array_key_exists ( "modules", $topmenu_entry )) {
				/*
				 * Es gibt keine Submenüs
				 */
				// User hat keine Berechtigung für die Applikation
				if (! in_array ( $topmenu_entry ['applikation'], $user->getAttribute ( 'applikationen', null, 'benutzer' ) )) {										
					unset ( $menu [$topmenu_key] );
				} else {
					// Module durchgehen
					foreach ( $topmenu_entry ['modules'] as $modul => $name ) {

						// Prüfen, ob Nutzer Rechte für das Modul hat
						if (! $user->hasCredential ( $topmenu_entry ['applikation'] . '-' . $modul )) {
							unset ( $menu [$topmenu_key] ['modules'] [$modul] );
						}
					}
				}
			} else {
				/*
				 * Es gibt Submenüs
				 */
				// Prüfen, ob der User Rechte für irgendeins der Sub-Applikationen hat
				$rechte_passen = false;
				foreach ( $topmenu_entry as $submenu_key => $submenu_entry ) {
					if ($submenu_key == 'top') {
						continue;
					}
					// User hat keine Berechtigung für die Applikation
					if (! in_array ( $submenu_entry ['applikation'], $user->getAttribute ( 'applikationen', null, 'benutzer' ) )) {
						unset ( $menu [$topmenu_key] [$submenu_key] );
					} else {
						// Module durchgehen
						foreach ( $submenu_entry ['modules'] as $modul => $name ) {
							// Prüfen, ob der User Rechte für das Modul hat
							if (! $user->hasCredential ( $submenu_entry ['applikation'] . '-' . $modul )) {
								unset ( $menu [$topmenu_key] [$submenu_key] ['modules'] [$modul] );
							}
							// Prüfen, ob wir aktuell in einer Subapplikation sind. Wenn ja, wird der Eintrag
							// im Template dann hervorgehoben.
							if ($aktiveApplikation == $submenu_entry ['applikation']) {
								$menu [$topmenu_key] ['aktiv'] = true;
							}
						}
					}
				}
				// Prüfen, ob es überhaupt noch einen Submenüeintrag gibt. Wenn nicht, dann brauchen wir den Hauptmenüeintrag nicht
				// Wenn ein Modul aktiv ist, gibt es zusätzlich den Array-Eintrag "aktiv". Wenn dieser gesetzt ist, ist der count()
				// natürlich eins höher. Das wird mit der Variable $aktiv berücksichtigt.
				$aktiv = isset ( $menu [$topmenu_key] ['aktiv'] ) ? 1 : 0;
				if (count ( $menu [$topmenu_key] ) == 1 + $aktiv) 				// 1, weil es den key "top" immer gibt
				{
					unset ( $menu [$topmenu_key] );
				}				// Prüfen, ob es nur noch ein Submenüeintrag gibt. Wenn ja, dann machen wir diesen zu einem Topmenü-Eintrag.
				elseif (count ( $menu [$topmenu_key] ) == 2 + $aktiv) 				// 2, weil es die keys "top" und "<Subapp-Nr>" gibt.
				{
					$submenu_key = array_keys ( $menu [$topmenu_key] ); // Gibt ein Array mit Keys zurück. der zweite Key (index 1) ist immer die
					                                                  // Applikation, weil der erste Key 'top' ist.
					$menu [$topmenu_key] ['top'] = $menu [$topmenu_key] [$submenu_key [1]] ['sub'];
					$menu [$topmenu_key] ['applikation'] = $menu [$topmenu_key] [$submenu_key [1]] ['applikation'];
					$menu [$topmenu_key] ['modules'] = $menu [$topmenu_key] [$submenu_key [1]] ['modules'];
					unset ( $menu [$topmenu_key] [$submenu_key [1]] );
				}
			}
		}
	}
	
	
	// return $menu;
	
	/*
	 * Jetzt den html-Code des Menüs erstellen
	 */
	$class_portal = $aktiveApplikation == 'portal' ? 'active' : null;
	
	$html = "<ul id=\"mega_menu\">
				<li class=\"$class_portal\">
					<a href=\"" . sfConfig::get ( 'app_url_portal' ) . "\">" . image_tag ( 'home.png' ) . "</a>
				</li>";
	
	foreach ( $menu as $topmenu_entry ) {
		
		// Es gibt keine Submenüs
		if (array_key_exists ( "modules", $topmenu_entry )) {
			// Top-Menü Eintrag
			$class_active = $aktiveApplikation == $topmenu_entry ['applikation'] ? "active" : null;
			$app = $topmenu_entry ['top'];
			
			$html .= "<li class=\"$class_active\"><a href='#' class=\"drop\">$app</a>
						<div class=\"dropdown_1column\">
							<div class=\"col_1\">
								<ul>";
			// Module durchgehen
			foreach ( $topmenu_entry ['modules'] as $modul => $name ) {				
				$link = link_to ( $name, sfConfig::get ( 'app_url_' . $topmenu_entry ['applikation'] ) . '/' . $modul . '/index' );
				$html .= "<li>$link</li>";
			}
			$html .= "</ul>
							</div>
						</div>
					</li>";
		} 		// Submenüs vorhanden
		else {
			$class_active = isset ( $topmenu_entry ['aktiv'] ) ? "active" : null;
			$app = $topmenu_entry ['top'];
			
			$html .= "<li class=\"$class_active\">
						<a href='#' class=\"drop\">$app</a>";
			
			// Zähler initialisieren und Topmenü-Name sowie 'aktiv'-Flag entfernen
			$i = 1;
			unset ( $topmenu_entry ['top'] );
			unset ( $topmenu_entry ['aktiv'] );
			
			$html .= "<div class=\"dropdown_" . count ( $topmenu_entry ) . "columns\">";
			foreach ( $topmenu_entry as $submenu_entry ) {
				$app = $submenu_entry ['sub'];
				$html .= "<div class=\"col_1\">
							<h2>$app</h2>
							<ul>";
				foreach ( $submenu_entry ['modules'] as $modul => $name ) {
					$link = link_to ( $name, sfConfig::get ( 'app_url_' . $submenu_entry ['applikation'] ) . '/' . $modul . '/index' );
					$html .= "<li>$link</li>";
				}
				$html .= "</ul>
						</div>";
				$i ++;
			}
			$html .= "</li>";
		}
	}
	$html .= "</ul>";
	
	return $html;
}

/**
 * Erstellt html-Code des Impressum bzw.
 * die dazugehöri<a href=\"#\" onclick=\"$('#impressum').dialog({
 * 'open': function() { $('#impressum_link').blur(); }
 * });
 * return false;\" class=\"pfeil\">	<!-- return false vermeidet den Sprung zum Seitenanfang -->
 * Impressum</a>ge Dialog-Box
 * Funktion wird in den einzelnen layout.php's aufgerufen
 * 
 * @return Array
 */
function renderImpressum() {
	use_javascript ( 'jquery.min.js' );
	use_javascript ( "jquery-ui.custom.min.js" );
	use_stylesheet ( "jquery-ui-1.8.16.custom.css" );
	
	$html = "<div style=\"display:none;\" id=\"impressum\" title=\"Impressum\">
			<p align=\"center\">Lufthansa LEOS GmbH
				<br/>FRA UN IT
	 		</p>
	 		<p align=\"center\">Technische Realisierung:
	 			<br/>FGH GbR<br/>
	 			vermittelt von<br/>
	 				<a href=\"http://www.junior-comtec.de\" class=\"pfeil\" target=\"_blank\" id=\"impressum_link\">Junior Comtec Darmstadt</a>
	 			<br/><br/>
	 			&copy; " . date ( "Y" ) . "
	 		</p>				
		</div>
		
		<a href=\"#\" onclick=\"jQuery('#impressum').dialog({ 
					modal: true,
					// blur, um Fokus vom Link zu nehmen (das sieht sonst blöd aus)
					open: function() { jQuery('#impressum_link').blur(); },
					closeOnEscape: true,
					draggable: false
			 	});
			 	return false;\" class=\"pfeil\"><!-- return false vermeidet den Sprung zum Seitenanfang -->
		Impressum</a>";
	return $html;
}
