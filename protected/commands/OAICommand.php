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
		$sql = "UPDATE identifiers SET WHERE id = ?";
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
	* @param $records
	* @param $url 
	*/
	protected function resume(SimpleXMLElement $records, $url) {
		if(isset($records->resumptionToken)) {
			if(!preg_match('/resumptionToken/i', $url)) {
				$url = $url . '&resumptionToken=' . $records->resumptionToken;
			} else {
				$url = preg_replace('/Token=.*$/i', 'Token=' . $records->resumptionToken, $url);
			}
			$this->getIdentifiers($url);
		}
	}
	
	/**
	* @param $url
	*/
	protected function getIdentifiers($url) {
		$oai_records = simplexml_load_file($url);
		
		foreach($oai_records as $records) {
			foreach($records as $record) {
				$this->writeIdentifier(array($record->identifier, $record->datestamp));
			}
		}
		
		$this->resume($records, $url);
	} 
	
	/**
	* IA uses namepaced Dublin Core XML for individual records.  So php simple_xml won't work here.
	* See http://www.itsalif.info/content/php-5-xmlreader-reading-xml-namespace-part-2
	* @param $id_string IA identifier for a particular record
	*/
	protected function getRecord($id_string) {
		$request_url = $this->base_oai_url . "verb=GetRecord&metadataPrefix=oai_dc&identifier=$id_string";
		$xml = new XMLReader();
		$xml->open($request_url);
		
		while($xml->read()) {
			if($xml->nodeType == XMLREADER::ELEMENT && $xml->localName === 'identifier') {
				$xml->read();
				if(preg_match('/^http/i', $xml->value)) {
					$xml->value;
				}
			}
		}
	}
	
	public function actionIdentifiers() {
		foreach($this->sets as $set) {
			$url = $this->base_oai_url . "verb=ListIdentifiers&set=collection:$set&metadataPrefix=oai_dc";
			$this->getIdentifiers($url);
		}		
	}
	
	public function actionRecords() {
		$identifiers = $this->getIdentifiersList();
		foreach($identifiers as $identity) {
			$this->getRecords($identity['identifier']);
		}
	}
}