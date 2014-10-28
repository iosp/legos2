<?php
/**
 *
 */
class StartseiteComponents extends sfComponents {
	/**
	 * Erzeugt die Hilfe-Funktion.
	 *
	 * @return void
	 */
	public function executeHilfe() {
		/*
		 * Name von Application und Modul und Action herausfinden, da darüber die Hilfedatei zugeordnet ist.
		 */
		$this->modul = $this->getController ()->getActionStack ()->getFirstEntry ()->getModuleName ();
		$this->app = sfConfig::get ( 'sf_app' );
		
		/*
		 * Prüfen, ob eine Hilfedatei zum entsprechenden Modul existiert. Wenn nicht, wird kein Hilfe-Symbol angezeigt.
		 */
		$pdfpath = sfConfig::get ( 'sf_web_dir' ) . DIRECTORY_SEPARATOR . 'hilfe' . DIRECTORY_SEPARATOR . 'pdf' . DIRECTORY_SEPARATOR . $this->app . '-' . $this->modul . '.pdf';
		$this->show_link = file_exists ( $pdfpath );
	}
}
?>
