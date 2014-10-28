<?php
class solution_03Actions extends sfActions {
	public function executeIndex(sfWebRequest $request) {
		$this->data = array (
				"Bonjour",
				"Hej",
				"Goedendag",
				"Guten Tag",
				"G'day",
				"Aloha" 
		);
	}
}
