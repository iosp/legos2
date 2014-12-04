<?php
class IdentificationFilter extends sfFilter {
	public function execute($filterChain) {
		
		
		//dd($this->getContext());
		//Kint::trace();
		
		
		//$this->getContext()->getController()->forward("mission_list", "index");
		//die("dd");
		// execute this filter only once
		
		// execute next filter
		$filterChain->execute ();
	}
}

?>