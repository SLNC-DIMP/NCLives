<?php
class CdmMetaCommand extends CConsoleCommand {
	protected $format;
	
	public function __construct() {
		$this->format = new Format;
	}
	
	protected function getCdm() {
		$sql = "SELECT * FROM cdm_records WHERE Title IS NULL";
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
	
	/**
	* Format can be json or xml
	* getItemInfo
	*/
	protected function getCdmInfo($record, $file_id) {
		$url_suffix = explode('/', $record['base_id']);
		$url = Yii::app()->params['baseCDMUrl'] . 'dmGetItemInfo/' .  $url_suffix[0] . '/' . $url_suffix[1] . '/json';
		
		if($results = @file_get_contents($url)) {
			$file = json_decode($results, true);
			
			if(is_null($file)) { return false; }
			
			foreach($file as &$value) { // passes value by reference
				$value = (!empty($value)) ? $value : NULL; 
			}
			
			$metadata = array(
				'Title'                 => $file['title'],
				'Creator'               => $file['creata'],
				'Item_Date'             => $file['date'],
				'Time_Period'           => $file['coverab'],
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
				'Url'                   => $file['url'],
				'Created'               => $file['dmcreated'], 
				'Modified'              => $file['dmmodified'],
				'file_id'               => $file_id
			);
			
		} else {
			return false;
		}

		return $metadata;
	}
	
	public function actionGetCdmMeta() {
		$records = $this->getCdm();
		if(empty($records)) { echo "No records to grab\r\n"; exit; }
		
		foreach($records as $record) {
			$metadata = $this->getCdmInfo($record, $record['id']);
			if(is_array($metadata) && $this->updateCdm($metadata)) {
				echo $record['id'] . " updated\r\n";
			} else {
				echo "Couldn't update " . $record['id'] . "\r\n";
			}
		}
	}
}