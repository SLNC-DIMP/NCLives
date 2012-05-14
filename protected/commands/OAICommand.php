<?php
class OAICommand extends CConsoleCommand {
	private $ai_sets = array('ncgovdocs', 'asgii', 'statelibrarynorthcarolina');
	private $base_ai_url = 'http://archive.org/services/oai.php?';
	private $base_cdm_url = 'http://cdm16062.contentdm.oclc.org/oai/oai.php?';
	
	protected function writeSets(array $values) {
		$sql = "INSERT into oai_sets(set_id, set_name) VALUES(?, ?)";
		Yii::app()->db->createCommand($sql)
			->execute($values);
	}
	
	protected function writeIdentifier(array $values) {
		$sql = "INSERT into ia_records(ia_identifier, base_id, datestamp) VALUES(?, ?, ?)";
		Yii::app()->db->createCommand($sql)
			->execute($values);
	}
	
	protected function updateIdentifier(array $values) {
		$sql = "UPDATE ia_records SET url_link = ? WHERE id = ?";
		Yii::app()->db->createCommand($sql)
			->execute($values);
	}
	
	protected function getIdentifiersList() {
		$sql = "SELECT id, ia_identifier FROM ia_records WHERE url_link IS NULL";
		$query = Yii::app()->db->createCommand($sql)
			->queryAll();
		
		return $query;
	}
	
	protected function identfierBase($identifier) {
		return substr_replace(strrchr($identifier, ':'), '', -1);
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
				$resume_url = preg_replace('/&set=collection.*$/i', '', $url);
				$url = $resume_url . '&resumptionToken=' . $token;
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
					if($record->identifier) {
						$ia_base = $this->identfierBase($record->identifier);
						$this->writeIdentifier(array($record->identifier, $ia_base, $record->datestamp));
						echo $record->identifier . "\n";
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
		$fh = fopen('xml_errors.csv', 'ab');
		try {
			$errors = $this->findErrorXML($request_url);
			if($errors) { throw new Exception('Invalid characters in dc:description field'); }
			
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
		} catch(Exception $e) {
			fputcsv($fh, array($request_url, $e->getMessage()));
			$presumed_url = 'http://archive.org/details/' . $id_string;
			$this->updateIdentifier(array($presumed_url, $db_id, date('Y-m-d')));
		}
		fclose($fh);
	}
	
	protected function findErrorXML($url) {
		$contents = file_get_contents($url);		
		
		return preg_match('/<dc:description.*<.*<.dc:description>/i', $contents);
	}
	
	protected function getSets($base_url) {
		$url = $base_url . 'verb=ListSets';
		$oai_records = simplexml_load_file($url);
		
		foreach($oai_records as $records) {
			foreach($records as $record) {
				if(isset($record->setSpec) && ($record->setName != 'Selections from Print Collections' || $record->setName != 'State Publications')) {
					$this->writeSets(array($record->setSpec, $record->setName));
					echo $record->setSpec . "\n";
				}
			}
		}
	}
	
	public function actionSets() {
		// cdm sets
		$this->getSets($this->base_cdm_url);
		
		// ai sets
		foreach($this->ai_sets as $set) {
			 $this->writeSets(array($set, $set));
		}
	}
	
	public function actionIdentifiers() {
		$sets = $this->readSets('ia');
		foreach($this->ai_sets as $set) {
			$url = $this->base_oai_url . "verb=ListIdentifiers&set=collection:$set&metadataPrefix=oai_dc";
			$this->getIdentifiers($url); // oai:archive.org:illustratedhandb00sepa
		}		
	}
	
	/**
	* This command won't do anything if there aren't already some identifiers in the db.
	*/
	public function actionRecords() {
		$identifiers = $this->getIdentifiersList();
		if(empty($identifiers)) { echo "There are no records to retrieve or update\r\n"; exit; }
		
		foreach($identifiers as $identity) {
			$this->getRecord($identity['id'], $identity['ia_identifier']);
		}
	}	
}