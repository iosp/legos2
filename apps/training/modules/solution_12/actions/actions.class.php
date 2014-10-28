<?php
class solution_12Actions extends sfActions {
	public function executeIndex(sfWebRequest $request) {
		/*
		 * Number of activities per tractor
		 */
		$query = "SELECT taxibot_tractor.name, COUNT(*) FROM taxibot_activity " . "JOIN taxibot_tractor ON taxibot_tractor.ID=taxibot_activity.tractor_id " . "GROUP BY taxibot_activity.tractor_id;";
		
		$connection = Propel::getConnection ( TaxibotActivityPeer::DATABASE_NAME );
		$statement = $connection->prepare ( $query );
		$statement->execute ();
		
		// Retrieve results
		$tractor = array ();
		$activities = array ();
		while ( $result_set = $statement->fetch ( PDO::FETCH_NUM ) ) {
			$tractor [] = $result_set [0];
			$activities [] = ( int ) $result_set [1];
		}
		
		// Transform array data to JSON data
		$this->tractor = json_encode ( $tractor );
		$this->activities = json_encode ( $activities );
		
		/*
		 * Time series data
		 */
		$series_one = array ();
		$series_two = array ();
		
		// Create random walk-like numbers
		$series_one [] = 50;
		$series_two [] = 100;
		
		for($i = 1; $i < 1440; $i ++) {
			$series_one [$i] = $series_one [$i - 1] + mt_rand ( - 10, 10 );
			$series_two [$i] = $series_two [$i - 1] + mt_rand ( - 10, 10 );
		}
		
		$this->series_one = json_encode ( $series_one );
		$this->series_two = json_encode ( $series_two );
	}
	public function executeExcelExportXML() {
		// Simply use our already created Excel export
		$this->forward ( 'solution_11', 'index' );
	}
}
