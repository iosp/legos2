<?php
/*
 * Dies ist das Template für einen Fehler 500 (internal Server Error), der entsteht wenn wir z.B. einen Fehler im php-Code haben.
 */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="title" content="Legos" />
<meta name="robots" content="index, follow" />
<meta name="description" content="symfony project" />
<meta name="keywords" content="symfony, project" />
<meta name="language" content="en" />
<title>Legos</title>
<link rel="shortcut icon" href="/favicon.ico" />
<link rel="stylesheet" type="text/css" media="screen"
	href="/css/screen.css" />
<link rel="stylesheet" type="text/css" media="screen"
	href="/css/menu.css" />
</head>

<body>
	<div class="header">
		<a href="http://legos2/portal.php"><img border="0"
			src="/images/dlh_leos_logo_transparent.png"
			alt="Dlh_leos_logo_transparent" /></a>
	</div>
	<div class="menu">
		<ul>
			<li><a href="http://legos2/portal.php">Login<!--[if IE 7]><!--></a>
			<!--<![endif]--> <!--[if lte IE 6]><table><tr><td><![endif]-->
				<ul></ul> <!--[if lte IE 6]></td></tr></table></a><![endif]--></li>
		</ul>
	</div>

	<div class="anmeldestatus">
		<a href="http://legos2/portal.php/login">Anmelden <img border="0"
			style="vertical-align: baseline;" src="/images/login.gif" alt="Login" /></a>
	</div>

	<div class="content">
		<img src="/sf/sf_default/images/icons/cancel48.png" alt="Fehler"
			width="48" height="48" />
		<h1>Fehler im Legos2-System ("<?php echo $code ?> | <?php echo $text ?> | <?php echo $name ?>")</h1>

		<h2>So helfen Sie bei der Fehlerbehebung</h2>
		<p>Kopieren Sie die Adresszeile des Browsers und senden Sie diese mit
			einer möglichst genauen Beschreibung als E-Mail an den Administrator.</p>
		<p>Die Beschreibung könnte folgendes beinhalten:
		
		
		<ul>
			<li>In welchem Modul haben Sie gearbeitet?</li>
			<li>Welche Eingaben haben zum Fehler geführt?</li>
		</ul>
		</p>

		<hr />
		<h2>Sie können nun...</h2>
		<ul>
			<li><a href="/index.php">...zur Startseite zurück gehen.</a></li>
		</ul>

	</div>

</body>
</html>
