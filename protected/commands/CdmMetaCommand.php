<?php
class CdmMetaCommand extends CConsoleCommand {
	protected $format;
	
	public function __construct() {
		$this->format = new Format;
	}
	
	protected function getCdm() {
		$sql = "SELECT * FROM cdm_records";
		$images = Yii::app()->db->createCommand($sql)
			->queryAll();
		
		return $images;
	}
	
	protected function updateCdm(array $values) {
		$sql = "UPDATE cdm_records SET " . $this->format->formatQuery($values) . " WHERE id = ?";
		$updated = Yii::app()->db->createCommand($sql)
			->execute(array_values($values));
		
		return $updated;
	}
	
	protected function deleteRecord(array $values) {
		$sql = "DELETE FROM cdm_records SET WHERE id = ?";
		Yii::app()->db->createCommand($sql)
			->execute(array_values($values));
	}
	
	/**
	* See http://stackoverflow.com/questions/854128/find-duplicate-records-in-mysql for query to find duplicates.
	* Finds all pages for compound objects
	* @return object
	*/
	protected function getDups() {
		$sql = "SELECT id, cdm_records.Url FROM cdm_records
			INNER JOIN (SELECT Url FROM cdm_records
			GROUP BY Url HAVING count(id) > 1) dup ON cdm_records.Url = dup.Url";
		
		$dups = Yii::app()->db->createCommand($sql)
			->queryAll();
		
		return $dups;
	}
	
	protected function getJson($url) {
		if($results = @file_get_contents($url)) {
			return json_decode($results, true);
		}
		
		return false;
	}
	
	protected function buildUrl($record, $verb) {
		$url_suffix = explode('/', $record['base_id']);
		
		return Yii::app()->params['baseCDMUrl'] . $verb . '/' .  $url_suffix[0] . '/' . $url_suffix[1] . '/json';
	}
	
	/**
	* Format can be json or xml
	* getItemInfo
	*/
	protected function getCdmInfo($record, $file_id) {
		$url = $this->buildUrl($record, 'dmGetItemInfo');
		$file = $this->getJson($url);
		
		if(!$file) { return false; }
			
		foreach($file as &$value) { // passes value by reference
			$value = (!empty($value)) ? $value : NULL; 
		}
			
		$collection = explode('/', $record['base_id']);
		$perm_url = 'http://digital.ncdcr.gov/u?/' . $collection[0] . ',' . $collection[1];
			
		$metadata = array(
			'Title'                 => $file['title'],
			'Creator'               => $file['creato'],
			'Item_Date'             => $file['dated'],
			'Time_Period'           => $file['time'],
			'Subjects'              => $file['subjec'],
			'Description'           => $file['descri'],
			'Rights'                => $file['rights'], 
			'Characteristics'       => $file['physic'],
			'Formats'               => $file['publia'],
			'DCR_Collection'        => $file['source'], 
			'Digital_Collection'    => $file['digita'],
			'Format'                => $file['format'],
			'Audience'              => $file['audien'],
			'Archival_Coll_Creator' => $file['hosted'],
			'Local'                 => $file['local'],
			'Type'                  => $file['type'],
			'Language'              => $file['langua'],
			'Themes'                => $file['themes'],
			'Url'                   => $perm_url,
			'Created'               => $file['dmcreated'], 
			'Modified'              => $file['dmmodified'],
			'file_id'               => $file_id
		);
			
		return $metadata;
	}
	
	public function actionGetCdmMeta() {
		$records = $this->getCdm();
		if(empty($records)) { echo "No records to grab\r\n"; exit; }
		
		foreach($records as $record) {
			$metadata = $this->getCdmInfo($record, $record['id']);
			
			if(!empty($metadata['Title']) && $this->updateCdm($metadata)) {
				echo $record['id'] . " updated\r\n";
			} else {
				$this->removeRecord(array($record['id']));
				echo "Couldn't update " . $record['id'] . "\r\n";
			}
		}
	}
}

/*
SELECT id, cdm_records.Url FROM cdm_records
INNER JOIN (SELECT Url FROM cdm_records
GROUP BY Url HAVING count(id) > 1) dup ON cdm_records.Url = dup.Url
*/