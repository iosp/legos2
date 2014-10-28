<?php
class activitiesActions extends sfActions {
	public function executeIndex(sfWebRequest $request) {
		// Set the URL to which form data of the selection box is sent
		$this->route = $this->getController ()->genUrl ( 'activities/content' );
	}
	public function executeContent(sfWebRequest $request) {
		$this->day_from = $request->getParameter ( 'auswahl[von]' );
		$this->day_to = $request->getParameter ( 'auswahl[bis]' );
		
		$criteria = new Criteria ();
		// TODO: Set criteria as soon as they are specified
		$criteria->add ( TaxibotActivityPeer::COMPLETED, date ( 'Y-m-d H:i:s', $this->day_from ), CRITERIA::GREATER_EQUAL );
		$criteria->addAnd ( TaxibotActivityPeer::COMPLETED, date ( 'Y-m-d H:i:s', $this->day_to ), CRITERIA::LESS_EQUAL );
		$this->activities = TaxibotActivityPeer::doSelect ( $criteria );
		
		// Daten in der Session zwischenspeichern, damit sie vom Excel-Export genutzt werden können.
		$this->getUser ()->setFlash ( 'activities', $this->activities );
	}
	
	/*
	 * Excel-Export
	 */
	public function executeExcelExportXML(sfWebRequest $request) {
		$this->setLayout ( false );
		
		// Retrieve data from session variable
		$activities = $this->getUser ()->getFlash ( 'activities' );
		
		// Create XML-object
		$xml = new LegosXmlWriter ();
		
		// Create styles
		$xml->createStyle ( 'ueberschrift', 'Font', 'ss:Bold', '1' );
		
		// Rename Worksheet
		$xml->setWorksheetName ( 'Overview Towing' );
		
		// Define headings
		$headings = array (
				'ID',
				'Trip',
				'Tractor',
				'Departure',
				'Ready',
				'Completed' 
		);
		
		// Write first row of excel-document (ueberschrift = heading)
		for($i = 0; $i < count ( $headings ); $i ++) {
			$xml->writeData ( $headings [$i], 1, $i + 1, '', '', 'ueberschrift', 'String' );
		}
		$i = 2;
		
		// Write data
		foreach ( $activities as $activity ) {
			$xml->writeData ( $activity->getId (), $i, 1 );
			$xml->writeData ( $activity->getTrip (), $i, 2 );
			$xml->writeData ( $activity->getTaxibotTractor (), $i, 3 );
			$xml->writeData ( $activity->getDeparture (), $i, 4 );
			$xml->writeData ( $activity->getReady (), $i, 5 );
			$xml->writeData ( $activity->getCompleted (), $i, 6 );
			$i ++;
		}
		
		// Set content type to XLS although it is an xml-file
		$this->getResponse ()->setContentType ( 'application/msexcel' );
		$this->getResponse ()->setHttpHeader ( 'Content-Disposition', sprintf ( 'attachment; filename="%s"', 'Export_Towing_Activities' . date ( 'Y-m-d' ) . '.xls' ) );
		$this->getResponse ()->sendHttpHeaders ();
		$this->getResponse ()->setContent ( $xml->getFile () );
		
		return sfView::NONE;
	}
}
