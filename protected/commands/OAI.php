<?php
abstract class OAI extends CConsoleCommand {
	protected $base_ai_url = 'http://archive.org/services/oai.php?';
	protected $base_cdm_url = 'http://cdm16062.contentdm.oclc.org/oai/oai.php?';
	
	protected function readSets($resource) {
		$sql = "SELECT set_id FROM oai_sets WHERE resource = :resource";
		$query = Yii::app()->db->createCommand($sql)
			->bindParam(":resource", $resource)
			->queryAll();
		
		return $query;
	}
	
	protected function writeIdentifier(array $values, $table) {
		$sql = "INSERT into $table(identifier, base_id, datestamp) VALUES(?, ?, ?)";
		Yii::app()->db->createCommand($sql)
			->execute($values);
	}
	
	protected function getIdentifiersList($table) {
		$sql = "SELECT id, identifier, base_id FROM $table WHERE url_link IS NULL";
		$query = Yii::app()->db->createCommand($sql)
			->queryAll();
		
		return $query;
	}
	
	protected function updateIdentifier(array $values, $table) {
		$sql = "UPDATE $table SET url_link = ? WHERE id = ?";
		Yii::app()->db->createCommand($sql)
			->execute($values);
	}
	
	protected function emptyTable($table) {
		$sql = "TRUNCATE TABLE $table";
		Yii::app()->db->createCommand($sql)
			->execute();
	}
	
	protected function identfierBase($identifier) {
		return substr_replace(strrchr($identifier, ':'), '', 0, 1);
	}
	
	/**
	* Checks to see if a OAI resumption token was sent.
	* If so it is appended to the base url or overwrites the previous token depending on the context
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
	
	protected function getIdentifiers($url, $table) {
		if($oai_records = @simplexml_load_file($url)) {
			foreach($oai_records as $records) {
				foreach($records as $record) {
					if($record->identifier && $records->header['status'] != 'deleted') {
						$cdm_base = $this->identfierBase($record->identifier);
						$this->writeIdentifier(array($record->identifier, $cdm_base, $record->datestamp), $table);
						echo $record->identifier . "\n";
					}
				} 
					
			}
			$token = ($records->resumptionToken) ? $records->resumptionToken : false;
			$new_url = $this->resume($token, $url);
			$this->getIdentifiers($new_url, $table);
		} else {
			echo "Couldn't find $url\r\n";
		}
	}
	
	/**
	* IA uses namepaced Dublin Core XML for individual records.  So php simple_xml won't work here.
	* See http://www.itsalif.info/content/php-5-xmlreader-reading-xml-namespace-part-2
	* @param $id_string IA identifier for a particular record
	*/
	protected function getRecord($table, $db_id, $id_string, $base_id, $ia = true) {
		$base_url = ($ia) ? $this->base_ai_url : $this->base_cdm_url;
		$request_url = $base_url . "verb=GetRecord&metadataPrefix=oai_dc&identifier=$id_string";
		
		try {
			$errors = $this->findErrorXML($request_url);
			if($errors) { throw new Exception('Invalid characters in dc:description field'); }
			
			$xml = new XMLReader();
			$xml->open($request_url);
			
			while($xml->read()) {
				if($xml->nodeType == XMLREADER::ELEMENT && $xml->localName === 'identifier') {
					$xml->read();
					if(preg_match('/^http/i', $xml->value)) {
						$this->updateIdentifier(array($xml->value, $db_id), $table);
					}
				}
			}
		} catch(Exception $e) {
			$fh = fopen('xml_errors.csv', 'ab');
			fputcsv($fh, array($request_url, $e->getMessage(), date('c')));
			$presumed_url = $this->urlLink($base_id);
			echo $presumed_url; exit;
			$this->updateIdentifier(array($presumed_url, $db_id), $table);
			fclose($fh);
		}
		
	}
	
	protected function findErrorXML($url) {
		$contents = file_get_contents($url);		
		
		return preg_match('/<dc:description.*<.*<.dc:description>/i', $contents);
	}
	
	abstract protected function urlLink($base_id);
	abstract public function actionSets();
	abstract public function actionIdentifiers();
}