<?php
class ViewFilter extends sfFilter {
	public function execute($filterChain) {
		if ($this->isFirstCall ()) {
			
			if ($_SERVER ['SERVER_NAME'] == "m.legos2") {
				// get context
				$context = $this->getContext ();
				// get module name
				$module = $context->getModuleName ();
				// get action name
				$action = $context->getActionName ();
				
				// get template file name for this request
				$templateFile = "m." . $action . "Success.php";
				
				// set physical path of that template
				$path = sfConfig::get ( 'sf_app_module_dir' ) . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . "templates" . DIRECTORY_SEPARATOR . $templateFile;
				
				// check if template exists
				if (file_exists ( $path )) {
					$this->getContext ()->getActionStack ()->getFirstEntry ()->getActionInstance ()->setLayout ( 'mobile' );
					$this->getContext ()->getActionStack ()->getFirstEntry ()->getActionInstance ()->setTemplate ( 'm.' . $action );
				}
			}
		}
		$filterChain->execute ();
	}
}

?>
