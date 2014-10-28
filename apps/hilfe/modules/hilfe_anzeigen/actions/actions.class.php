<?php

/**
 * hilfe_anzeigen actions.
 *
 * @package    legos2
 * @subpackage hilfe_anzeigen
 * @author     jan
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class hilfe_anzeigenActions extends sfActions {
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request
	 *        	A request object
	 */
	public function executeIndex(sfWebRequest $request) {
		$this->forward ( 'show', 'hilfe_anzeigen' );
	}
	
	/**
	 * Zeigt die Hilfe zur aktuellen Seite an.
	 */
	public function executeShow() {
		$this->setLayout ( false );
		sfConfig::set ( 'sf_web_debug', false );
		
		$pdfpath = sfConfig::get ( 'sf_web_dir' ) . DIRECTORY_SEPARATOR . 'hilfe' . DIRECTORY_SEPARATOR . 'pdf' . DIRECTORY_SEPARATOR . $this->getRequestParameter ( 'seite' ) . '.pdf';
		
		// check if the file exists
		$this->forward404Unless ( file_exists ( $pdfpath ) );
		
		// Adding the file to the Response object
		$this->getResponse ()->clearHttpHeaders ();
		$this->getResponse ()->setHttpHeader ( 'Pragma: public', true );
		$this->getResponse ()->setContentType ( 'application/pdf' );
		$this->getResponse ()->sendHttpHeaders ();
		$this->getResponse ()->setContent ( readfile ( $pdfpath ) );
		
		return sfView::NONE;
	}
}