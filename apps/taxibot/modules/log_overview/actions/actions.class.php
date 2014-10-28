<?php

/**
 * log_overview actions.
 *
 * @package    legos2
 * @subpackage log_overview
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class log_overviewActions extends sfActions {
	public function executeExport() {
		$xml = new LegosXmlWriter ();
		$xml->createStyle ( 'heading', 'Font', 'ss:Bold', '1' );
		
		// first line contains column headers
		$heading = array (
				'LogId',
				'LogFile',
				'Tractor_Id',
				'Load',
				'Date',
				'LoadValidity' 
		);
		for($i = 0; $i < count ( $heading ); $i ++) {
			$xml->writeData ( $heading [$i], 1, $i + 1, '', '', 'heading', 'String' );
		}
		/*
		 * // write all records to for xml export $i = 2; foreach ($this->activities as $activity) { $xml->writeData($activity->getLogId(), $i, 1); $xml->writeData($activity->getLogFile(), $i, 2); $xml->writeData($activity->getTractorId(), $i, 3); $xml->writeData($activity->getLoad(), $i, 4); $xml->writeData($activity->getDate(), $i, 5); $xml->writeData($activity->getLoadValidity(), $i, 6); $i++; }
		 */
		// Set content type to XLS although it is an xml-file
		$this->getResponse ()->setContentType ( 'application/msexcel' );
		$this->getResponse ()->setHttpHeader ( 'Content-Disposition', sprintf ( 'attachment; filename="%s"', 'Export_Taxibot_Logs' . date ( 'Y-m-d' ) . '.xls' ) );
		$this->getResponse ()->sendHttpHeaders ();
		$this->getResponse ()->setContent ( $xml->getFile () );
		
		// Don't return any layout or template
		return sfView::NONE;
	}
	
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request
	 *        	A request object
	 */
	public function executeIndex(sfWebRequest $request) {
		$criteria = new Criteria ();
		$this->activities = TaxibotLogPeer::doSelect ( $criteria );
	}
}
