<?php echo image_tag('/sf/sf_default/images/icons/cancel48.png', array('alt' => 'page not found', 'class' => 'sfTMessageIcon', 'size' => '48x48'))?>
<h1>Seite nicht gefunden (Fehler 404).</h1>

<h2>Haben Sie die URL selbst eingegeben?</h2>
<p>Wahrscheinlich haben Sie die Adresse (URL) einfach nur falsch
	geschrieben. Überprüfen Sie diese nocheinmal auf korrekte Schreibweise,
	Groß-/Kleinschreibung, usw.</p>

<h2>Sind Sie einem Link hierher gefolgt?</h2>
<p>Wenn Sie diese Seite über eine andere erreicht haben, geben bitte Sie
	einem Administrator Bescheid, damit der Fehler behoben werden kann.</p>
<p>Dazu kopieren Sie bitte die Adresszeile aus dem Browser und
	beschreiben Sie von welcher Seite aus Sie hier gelandet sind. Je mehr
	Informationen Sie angeben, um so einfacher gestaltet sich die
	Fehlersuche. Vielen Dank.</p>

<br />
<br />

<h2>Sie können nun:</h2>
<ul>
	<li><?php echo link_to('zur Portalseite gehen', sfConfig::get('app_url_portal'), array('class'=>'pfeil') ) ?></li>
	<li><a href="javascript:history.go(-1)" class="pfeil">zurück zur
			vorherigen Seite gehen</a></li>
</ul>