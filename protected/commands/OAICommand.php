<?php
class OAICommand extends CConsoleCommand {
	private $base_oai_url = 'http://archive.org/services/oai.php?';
	private $base_cdm_url;
	
	public function __construct() {
		$this->sets = array('ncgovdocs', 'asgii', 'statelibrarynorthcarolina');
	}
	
	protected function getIdentifiersList() {
		$sql = "SELECT id, identifier FROM identifiers WHERE processed = ?";
		$query = Yii::app()->db->createCommand($sql)
			->queryAll();
		
		return $query;
	}
	
	protected function writeIdentifier($identifier) {
		$sql = "INSERT into identifiers(identifier, datestamp) VALUES(?, ?)";
		Yii::app()->db->createCommand($sql)
			->execute(array($identifier));
	}
	
	/**
	* Checks to see if a OAI resumption token was sent.
	* If so it is appended to the base url or overwrites the previous token depending on the context
	* Then makes a call to grab the next batch of identifiers
	* @param $records
	*/
	protected function resume($records) {
		$url = $this->base_oai_url . "verb=ListIdentifiers";
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
	* @param $set IA collection set name
	*/
	protected function getIdentifiers($set) {
		$url = $this->base_oai_url . "verb=ListIdentifiers&set=collection:$set&metadataPrefix=oai_dc";
		$oai_records = simplexml_load_file($url);
		
		foreach($oai_records as $records) {
			foreach($records as $record) {
				$set_info = array();
				foreach($record->setSpec as $set) {
					$set_info[] = $set;
				}
				$sets = implode(',', $set_info); 
				fputcsv($fh, array($record->identifier, $record->datestamp, $sets));
			}
		}
		fclose($fh);
		
		$this->resume($records);
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
			$this->getIdentifiers($set);
		}		
	}
	
	public function actionRecords() {
		foreach($identifiers as $identity) {
			$this->getRecords($identity['identifier']);
		}
	}
}