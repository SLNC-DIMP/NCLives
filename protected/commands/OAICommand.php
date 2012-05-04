<?php
class OAICommand extends CConsoleCommand {
	protected $sets;
	private $base_oai_url = 'http://archive.org/services/oai.php?';
	
	public function __construct() {
		$this->sets = array('ncgovdocs', 'asgii', 'statelibrarynorthcarolina');
	}
	
	protected function writeIdentifier(array $values) {
		$sql = "INSERT into identifiers(ia_identifier, datestamp) VALUES(?, ?)";
		Yii::app()->db->createCommand($sql)
			->execute($values);
	}
	
	protected function updateIdentifier(array $values) {
		$sql = "UPDATE identifiers SET url_link = ? WHERE id = ?";
		Yii::app()->db->createCommand($sql)
			->execute($values);
	}
	
	protected function getIdentifiersList() {
		$sql = "SELECT id, ia_identifier FROM identifiers";
		$query = Yii::app()->db->createCommand($sql)
			->queryAll();
		
		return $query;
	}
	
	/**
	* Checks to see if a OAI resumption token was sent.
	* If so it is appended to the base url or overwrites the previous token depending on the context
	* Then makes a call to grab the next batch of identifiers
	* @param $token
	* @param $url 
	*/
	protected function resume($token, $url) {
		if($token) {
			if(!preg_match('/resumptionToken/i', $url)) {
				$url = $url . '&resumptionToken=' . $token;
			} else {
				$url = preg_replace('/Token=.*$/i', 'Token=' . $token, $url);
			}
			
			return $url;
		}
		
		return false;
	}
	
	/**
	* @param $url
	*/
	protected function getIdentifiers($url) {
		if($url) {
			$oai_records = simplexml_load_file($url);
			
			foreach($oai_records as $records) {
				foreach($records as $record) {
					if(!empty($record)) {
						$this->writeIdentifier(array($record->identifier, $record->datestamp));
					}
				} 
				
			}
			$token = ($records->resumptionToken) ? $records->resumptionToken : false;
			$new_url = $this->resume($token, $url);
			$this->getIdentifiers($new_url);
		}
	} 
	
	/**
	* IA uses namepaced Dublin Core XML for individual records.  So php simple_xml won't work here.
	* See http://www.itsalif.info/content/php-5-xmlreader-reading-xml-namespace-part-2
	* @param $id_string IA identifier for a particular record
	*/
	protected function getRecord($db_id, $id_string) {
		$request_url = $this->base_oai_url . "verb=GetRecord&metadataPrefix=oai_dc&identifier=$id_string";
		$xml = new XMLReader();
		$xml->open($request_url);
		
		while($xml->read()) {
			if($xml->nodeType == XMLREADER::ELEMENT && $xml->localName === 'identifier') {
				$xml->read();
				if(preg_match('/^http/i', $xml->value)) {
					$this->updateIdentifier(array($xml->value, $db_id));
				}
			}
		}
	}
	
	public function actionIdentifiers() {
		foreach($this->sets as $set) {
			$url = $this->base_oai_url . "verb=ListIdentifiers&set=collection:asgii&metadataPrefix=oai_dc";
			$this->getIdentifiers($url);
		}		
	}
	
	/**
	* Thi command won't do anything if there aren't already some identifiers in the db.
	*/
	public function actionRecords() {
		$identifiers = $this->getIdentifiersList();
		if(empty($identifiers)) { echo "There are no records to retrieve or update\r\n"; exit; }
		
		foreach($identifiers as $identity) {
			$this->getRecord($identity['id'], $identity['ia_identifier']);
		}
	}
}