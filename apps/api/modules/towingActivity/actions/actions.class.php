<?php
//use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * towingActivity actions.
 *
 * @package    legos2
 * @subpackage api-towingActivity
 * @author     Benjamin Gembruch
 * @version    1.0
 */
class towingActivityActions extends sfActions
{
	/**
	* Executes index action
	*
	* @param sfRequest $request A request object
	*/
	public function executeIndex(sfWebRequest $request)
	{
		$this->forward('default', 'module');
	}
	

	/**
	* HTTP-Request: GET /towingActivity/oderId/timestamp  HTTP/1.1
	* 
	* @param      sfRequest $request A request object
	* @param      
	* @return     
	* @throws     
	*/
	public function executeShow(sfWebRequest $request) {
	
		// Response vorbereiten
		$response = $this->getResponse();
		$response->setContentType('text/json');
	
		try {
			// Schleppvorgang holen
			$towing = $this->getRoute()->getObject();
			
			// Antwort an Client
			$response->setStatusCode(200); // OK
			// HTTP Body kann nur als String übertragen werden
			$towingJsonString = json_encode($towing->toArray());
			$response->setContent($towingJsonString);
			
		} catch (Exception $e) {
			// Fehlermeldung an Client
			$response->setStatusCode(404); // Not Found
			$response->setContent('Schleppvorgang exitiert nicht');
		}
		
		// Response abschicken
		$response->send();
	}
	
	/**
	* HTTP-Request: POST /towingActivity HTTP/1.1
	* 
	* @param      sfRequest $request A request object
	* @param      
	* @return     
	* @throws     
	*/
	public function executeCreate(sfWebRequest $request) {
		
		// JSON, welches der Client geschickt hat aus dem HTTP Body auslesen. Wird in Array umgewandelt.
		$towingArrayFromClient = json_decode(ApiTools::getRequestBody(), true);
		
		$response = $this->getResponse();
		$response->setContentType('text/json');
		
		// ToDo: User allowed to edit Schleppvorgang? If not, stop execution, send HTTP-Statuscode 403
		// $this->checkPermission();
		
		// Prüfen, ob vom Client die Pflichtfelder (Auftragsnummer, SchleppvorgangVorgangsartId) übermittelt wurde
		if (!isset($towingArrayFromClient['OrderId']) || !isset($towingArrayFromClient['Timestamp'])) {
			$response->setStatusCode(400); // Bad Request
			$response->setContent("Fehlender Prameter (OrderId, Timestamp) im JSON Objekt oder Syntaxfehler.");
		} else {
			
			// Versuchen Schleppvorgang aus DB zu holen um prüfen zu können, ob ein Vorgang mit gleicher Auftragsnummer bereits exitiert.
			$criteria = new Criteria();
			$criteria->add( TowingActivityPeer::ORDER_ID, $towingArrayFromClient['OrderId']);
			$criteria->add( TowingActivityPeer::TIMESTAMP, $towingArrayFromClient['Timestamp']);
			$existingTowing = TowingActivityPeer::doSelect( $criteria );
			
			// Existiert Vorgang bereits? Dann Fehler werfen.
			// ToDo: Prüfen ob zu setzende Fremdschlüssel existieren, da der Vorgang sonst nicht gespeichert werfen kann
			if ($existingTowing){
				$response->setStatusCode(400); // Bad Request
				$response->setContent("Towing with this key (OrderId and Timestamp) already exists.");
			} 
			// Neuer Schleppvorgang kann angelegt werden
			else {
				$towing = new TowingActivity();
				
				// Vorgang in der Datenbank speichern
				$towing->fromArray( $towingArrayFromClient );
				$towing->save();
				
				// Response vorbereiten
				if($towing->getId() != NULL) {
					$response->setStatusCode(201); // 201=Created
					$response->setHttpHeader('Location', $request->getHost().'/towingActivity/'.$towing->getOrderId());
					$responseBody = (json_encode($towing->toArray()));
					$response->setContent($responseBody);
				} else {
					$response->setStatusCode(500); // 500=Internal Server Error
					$response->setContent("Neuer Schleppvorgang konnte nicht angelegt werden.");
				}
			}
		}
		// Antwort an Client schicken
		$response->send();
	}
	
	/**
	* HTTP-Request: PUT /towingActivity/oderId/timestamp HTTP/1.1
	* 
	* @param      sfRequest $request A request object
	* @param      
	* @return     
	* @throws     
	*/
	public function executeUpdate(sfWebRequest $request) {
		
		// ToDo: User allowed to edit Schleppvorgang? If not, stop execution, send HTTP-Statuscode 403
		// $this->checkPermission($schleppvorgang);
		
		// Response vorbereiten
		$response = $this->getResponse();
		$response->setContentType('text/json');
		$response->setStatusCode(400); // Initial: Bad request
		$responseBody = "Error";
		
		// JSON, welches der Client geschickt hat aus dem HTTP Body auslesen. Wird in Array umgewandelt.
		$towingArrayFromClient = json_decode(ApiTools::getRequestBody(), true);
		
		// JSON auf Syntaxfehler prüfen
		if (is_array($towingArrayFromClient)) {
		} else {
			// Fehlermeldung an Client
			$response->setStatusCode(400); // Bad request
				$responseBody ='Syntaxfehler im JSON Objekt.';
			$response->setContent(json_encode($responseBody));
			$response->send();
			exit();
		}
		
		// Schleppvorgang aus DB holen. Bei Nichtexistenz -> catch und Abbruch der Update-Funktion
		try {
			$towing = $this->getRoute()->getObject();
		} catch (Exception $e) {
			// Fehlermeldung an Client
			$response->setStatusCode(404); // Not Found
				$responseBody ='Schleppvorgang existiert nicht oder Verwendung eines nicht zulässigen Wertes (z.B. nicht existierende SchlepperID):  '.$e;
			$response->setContent(json_encode($responseBody));
			$response->send();
			exit();
		}
		
		// Unset der nicht überschreibbaren Identifikatoren des Schleppvorgangs
		if (isset($towingArrayFromClient['OrderId'])) {
			unset($towingArrayFromClient['OrderId']);
		}
		if (isset($towingArrayFromClient['Timestamp'])) {
			unset($towingArrayFromClient['Timestamp']);
		}
		
		// Schleppvorgang in DB speichern
		$towing->fromArray( $towingArrayFromClient );
		$towing->save();
		
		// HTTP
		$response->setStatusCode(200); // OK
		$responseBody = $towing->toArray();
				
		// Response abschicken
		$response->setContent(json_encode($responseBody));
		$response->send();
	}
		
	function setTimestamp($towing) {
		$date = new DateTime();
		$towing->setApiTimestamp($date->getTimestamp());
	}
	
}