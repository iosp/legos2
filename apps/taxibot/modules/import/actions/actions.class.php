<?php

/**
 * import actions.
 *
 * @package    legos2
 * @subpackage import
 * @author     Moshe Beutel
 */
class importActions extends sfActions {
	/**
	 * Executes index action
	 *
	 * @param sfWebRequest $request
	 *        	A request object
	 */
	public function executeIndex(sfWebRequest $request) {		
		// die ( "import task allow just via http://taxibotupload.azurewebsites.net/Home/UploadFile " );
		
		// phpinfo();
		$this->our_string = "Import";
		$this->route = $this->getController ()->genUrl ( 'import/import' );
	}
	
	/**
	 * Executes upload action - Upload the selected file to server and perform an Import of the data.
	 */
	public function executeUpload(sfWebRequest $request) {
		$date = date ( "Y-m-d", $request->getParameter ( 'auswahl[von]' ) );
		$this->getUser ()->setFlash ( 'date', $date );
		
		/*
		 * $this->year = '2013'; $this->month = '06'; $this->day = '30'; // create a directory: app_import_path_stack_log/year/month/day $path = sfConfig::get( 'app_import_path_stack_log' ) . DIRECTORY_SEPARATOR . $this->year ; if(!file_exists($path)){ if(mkdir($path) == false){ die("error imporing"); } } // create a directory: app_import_path_stack_log/year/month/day $path .= DIRECTORY_SEPARATOR . $this->month ; if(!file_exists($path)){ if(mkdir($path) == false){ die("error imporing"); } } // create a directory: app_import_path_stack_log/year/month/day $path .= DIRECTORY_SEPARATOR . $this->day ; if(!file_exists($path)){ if(mkdir($path) == false){ die("error imporing"); } } $this->getRequest()->moveFile('file', $path.DIRECTORY_SEPARATOR .$fileName);
		 */
	}
	
	/**
	 * Executes import action - import selected file
	 * This controller is not associated with a view
	 * because we don't want to see all import's output
	 *
	 * @param sfWebRequest $request
	 *        	A request object
	 */
	public function executeImport(sfWebRequest $request) {	
	
		if ($this->getRequest ()->hasFiles ()) {
			
			foreach ( $this->getRequest ()->getFileNames () as $fileName ) {
				$fileSize = $this->getRequest ()->getFileSize ( $fileName );
				$fileType = $this->getRequest ()->getFileType ( $fileName );
				$fileError = $this->getRequest ()->hasFileError ( $fileName );
				$fileRealName = $this->getRequest ()->getFileName ( $fileName );
				$uploadDir = sfConfig::get ( 'sf_upload_dir' );
				
				$filename = $fileRealName ['file'];
				
				$isMoveFileSuccess = $this->getRequest ()->moveFile ( 'auswahl[file]', $uploadDir . '/' . $filename );
				
				if ($isMoveFileSuccess) {
				} else {
					die ( 'save ' . $filename . ' file to local error' );
				}
				
				// echo "file uploaded to - $uploadDir " . $fileRealName ['file'];
				
				$import = new ImportVectorLog ( '2013', '02', '02', true );
				$mission = $import->import ( $filename );
				if ($mission == null) {
					die ( "No Nission upload" );
				}
				
				$missionIdImported = $mission->getId ();
				unlink ( $uploadDir . '/' . $filename );
				
				$this->redirect ( 'import/show?missionId=' . $missionIdImported . '&fileName=' . $filename );
				
				// die("size - $fileSize[file] type - $fileType[file] has error - $fileError filename - $fileRealName[file] uploadedirectory - $uploadDir");
			}
		} else {
			var_dump ( $this->getRequest () );
			die ( "no file uploaded" );
		}
	}
	public function executeImportcsv(sfWebRequest $request) {
		$blfName = $request->getParameter ( "blfName" );
		
		$this->logMessage("Start Upload -  Blf Name " . $blfName);	
		
		$uploadDir = sfConfig::get ( 'sf_upload_dir' );
		if ($this->getRequest ()->hasFiles ()) {
			foreach ( $request->getFiles () as $file ) {
				
				if(end(explode('FTG.csv', $file ['name'])) == ''){
					$this->logMessage($blfName ." File name is bad");
					return $this->renderText ( json_encode ( array (
							'IsError' => "true",
							'Message' => "File name is bad."
					) ) );
				}
				
				if (move_uploaded_file ( $file ["tmp_name"], $uploadDir . "/" . $file ['name'] )) {
					chmod ( $uploadDir . "/" . $file ['name'], 0666 );
					
					$import = new ImportVectorLog ( '2013', '02', '02', true );
					
					$mission = $import->import ( $file ['name'] , $blfName);
					
					if ($mission == null) {
						$this->logMessage($blfName ." Import file to legos feild: no mission uploaded");
						return $this->renderText ( json_encode ( array (
								'IsError' => "true",
								'Message' => "Import file to legos feild: no mission uploaded." 
						) ) );
					}
					
					$missionIdImported = $mission->getMissionId ();
					
					unlink ( $uploadDir . '/' . $file ['name'] );
					
					$this->logMessage($blfName ." Import file to legos is success");
					
					return $this->renderText ( json_encode ( array (
							'IsError' => "false",
							'Message' => "Import file to legos is success.",
							'MissionIdImported' => $missionIdImported,
							'RedirectUrl' => 'import/show?missionId=' . $missionIdImported . '&fileName=' . $blfName. ".blf" 
					) ) );
				} else {
					$this->logMessage($blfName ." Error: Legos system canot save csv file to local files");
					return $this->renderText ( json_encode ( array (
							'IsError' => "true",
							'Message' => "Legos system canot save csv file to local files." 
					) ) );
					
				}
			}
		} else {
			$this->logMessage($blfName ." Error: no file uploaded");
			return $this->renderText ( json_encode ( array (
					'IsError' => "true",
					'Message' => "no file uploaded" 
			) ) );
		}
	}
	
	public function logMessage($message){
		$handle = fopen ( sfConfig::get ( 'app_import_taxibot_logfile' ), 'a' );
		if ($handle) {
				
			fwrite ( $handle, "[" . date ( 'Y-m-d H:i:s' ) . "] " . $message . "\n\r" );
			fclose ( $handle );
		}
	}
	
	/**
	 * Executes show action - show imported file's content
	 *
	 * @param sfWebRequest $request
	 *        	A request object
	 */
	public function executeShow(sfWebRequest $request) {
		
		// TODO: Deal with no Exceeds! => Upload to Legos is done. No overload events registered
		$this->missionId = $request->getParameter ( 'missionId' );
		
		$this->filename = $request->getParameter ( 'fileName' );
		
		$this->date = $this->getUser ()->getFlash ( 'date' );
		
		$this->records = array ();
		
		$this->exceeds = array ();
		
		if ($this->missionId > 0) {
			
			$criteria = new Criteria ();
			
			$criteria->add ( TaxibotExceedEventPeer::MISSION_ID, $this->missionId );
			
			$exceeds = TaxibotExceedEventPeer::doSelectOne ( $criteria );
			
			if ($exceeds != null) {
				// exceeds occured in the imported mission. query only current mission
				$this->redirect ( 'limit_exceed/show?missionId=' . $this->missionId );
			}
		}
	}
}
