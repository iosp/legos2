<?php
class solution_11Actions extends sfActions {
	public function executeIndex(sfWebRequest $request) {
		// Get some data
		$criteria = new Criteria ();
		$criteria->add ( TaxibotActivityPeer::DEPARTURE, "2013-02-02 12:00:00", Criteria::GREATER_THAN );
		$criteria->addAnd ( TaxibotActivityPeer::DEPARTURE, "2013-02-02 14:00:00", Criteria::LESS_THAN );
		$criteria->addAscendingOrderByColumn ( TaxibotActivityPeer::DEPARTURE );
		$activities = TaxibotActivityPeer::doSelect ( $criteria );
		
		// Create XML-object
		$xml = new LegosXmlWriter ();
		
		// Create styles
		$xml->createStyle ( 'ueberschrift', 'Font', 'ss:Bold', '1' );
		
		// Name Worksheet
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
		
		// Don't return any layout or template
		return sfView::NONE;
	}
}
