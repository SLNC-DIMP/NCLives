<?php
class CDMCommand extends CConsoleCommand {
	protected $format;
	
	public function __construct() {
		$this->format = new Format;
	}
	
	protected function writeImage(array $values) {
		$sql = "INSERT into cdm_records(collection, pointer) VALUES(?, ?)";
		Yii::app()->db->createCommand($sql)
			->execute($values);
	}
	
	protected function getImages() {
		$sql = "SELECT * FROM cdm_records";
		$images = Yii::app()->db->createCommand($sql)
			->queryAll();
		
		return $images;
	}
	
	protected function updateImage(array $values) {
		$sql = "UPDATE cdm_records SET " . $this->format->formatQuery($values) . " WHERE id = ?";
		$updated = Yii::app()->db->createCommand($sql)
			->execute(array_values($values));
		
		return $updated;
	}
	
	/**
	* Format can be json or xml
	* getItemInfo
	*/
	protected function getImageInfo($record, $file_id) {
		$url = Yii::app()->params['baseCDMUrl'] . 'dmGetItemInfo' .  $record['collection'] . '/' . $record['pointer'] . '/json';
		
		if($results = file_get_contents($url)) {
			$file = json_decode($results, true);
			
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
	
	/**
	* query format http://CdmServer.com:port/dmwebservices/index.php?q=dmQuery/alias/searchstrings/fields/sortby/maxrecs/start/supress/docptr/suggest/facets/format
	*/
	public function actionGetImages() {
		$url = Yii::app()->params['baseCDMUrl'] . 'dmQuery/all/type^image^all^and/title/title/5000/0/0/0/0/json';
		if($results = file_get_contents($url)) {
			$files = json_decode($results, true);
	
			foreach($files as $file) {
				foreach($file as $entry) {
					if(isset($entry['collection'])) {
						$this->writeImage(array($entry['collection'],  $entry['pointer']));
						echo $entry['collection'] . ', ' . $entry['pointer'] . "\r\n";
					}
				}
			}  
		} else { 
			echo "Can't connect to CDM images url\n"; 
		} 
	} 
	
	public function actionGetImageMeta() {
		$images = $this->getImages();
		if(empty($images)) { echo "No images to grab\r\n"; exit; }
		
		foreach($images as $image) {
			$metadata = $this->getImageInfo($image, $image['id']);
			if($this->updateImage($metadata)) {
				echo $image['id'] . " updated\r\n";
			} else {
				echo "Couldn't update " . $image['id'] . "\r\n";
			}
		}
	}
}