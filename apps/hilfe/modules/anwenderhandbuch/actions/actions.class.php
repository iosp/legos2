<?php

/**
 * anwenderhandbuch actions.
 *
 * @package    legos2
 * @subpackage anwenderhandbuch
 */
class anwenderhandbuchActions extends sfActions {
	/**
	 * Es werden nur pdf-Dateien für die Module angezeigt, zu denen der Nutzer Zugriff hat.
	 * Diese werden analog zur
	 * Erstellung des Menüs geprüft.
	 */
	public function executeIndex(sfWebRequest $request) {
		// Layout der index-Seite ist im Template hinterlegt, daher kein Layout wählen
		$this->setLayout ( false );
		$this->content = $this->getRequestParameter ( 'content' );
	}
	public function executeDownload() {
		$this->setLayout ( false );
		
		$filename = $this->getRequestParameter ( 'pdf' );
		$pdfpath = sfConfig::get ( 'sf_web_dir' ) . DIRECTORY_SEPARATOR . 'hilfe' . DIRECTORY_SEPARATOR . 'pdf' . DIRECTORY_SEPARATOR . $filename;
		
		if (file_exists ( $pdfpath )) {
			$this->getResponse ()->clearHttpHeaders ();
			$this->getResponse ()->addCacheControlHttpHeader ( 'Cache-control', 'must-revalidate, post-check=0, pre-check=0' );
			$this->getResponse ()->setContentType ( 'application/pdf' );
			$this->getResponse ()->setHttpHeader ( 'Content-Disposition', 'attachment; filename=' . $filename, TRUE );
			$this->getResponse ()->setHttpHeader ( 'Content-Length', filesize ( $pdfpath ) );
			$this->getResponse ()->sendHttpHeaders ();
			$this->getResponse ()->setContent ( readfile ( $pdfpath ) );
			return sfView::NONE;
		}
		$this->forward ( 'anwenderhandbuch', 'index' );
	}
}
