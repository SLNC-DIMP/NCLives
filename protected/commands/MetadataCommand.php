<?php
// Requires PEAR packages Structures_LinkedList and File_MARC
// See link for documentation: http://pear.php.net/manual/en/package.fileformats.file-marc.reading.php
require_once 'File/MARCXML.php';

class MetadataCommand extends CConsoleCommand {
	protected $marc;
	protected $meta_url = 'http://www.archive.org/download/';
	protected $text_url = 'http://archive.org/details/';
//	protected $metadata;
	
	public function __construct() {
//		$this->metadata = array('marc.xml', 'meta.xml');
	//	$this->marc = new File_MARCXML($this->base_url . $file . '/' . $file . '_marc.xml', File_MARC::SOURCE_FILE);
	}
	
	protected function getPaths($field) {
		$sql = "SELECT id, base_id FROM identifiers WHERE $field IS NULL";
		$query = Yii::app()->db->createCommand($sql)
			->queryAll();
		
		return $query;
	}
	
	protected function writeText(array $fields) {
		$sql = "UPDATE identifiers SET item_text = ? WHERE id = ?";
		Yii::app()->db->createCommand($sql)
			->execute($fields);
	}
	
	protected function writeMetadata(array $fields) {
		$sql = "UPDATE identifiers SET " . $this->formatQuery($fields) . " WHERE id = ?";
			
		$query = Yii::app()->db->createCommand($sql)
			->execute(array_values($fields));
			
		return $query;
	}
	
	protected function formatQuery(array $fields) {
		array_pop($fields);
		$field_values = '';
		foreach($fields as $key => $field) {
			$field_values .= "$key = ?,";
		}
		 
		return $this->commaReplace($field_values);
	}
	
	protected function commaReplace($string) {
		return substr_replace($string, '', -1);
	}
	
	protected function downloadText($identifier) {
		$url = 'http://archive.org/download/' . $identifier . '/' . $identifier . '_djvu.txt';
		
		if($ch = @curl_init($url)) {
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$text = curl_exec($ch);
		
		curl_close($ch);
		} else {
			echo 'Could not find ' . $url . "\r\n";
			return false;
		}
		
		return trim($text);
	}
	
	/**
	* Pulls out Internet Archive Metadata
	* IA uses redirects which simplexml_load_file doesn't deal well with.
	* Hence the use of file_get_contents() and simplexml_load_string();
	*/
	protected function getIaMetadata($url, $file_id) {
		$subjects = '';
		
		try {
			if(!$file = @file_get_contents($url)) { throw new Exception("File $url can't be found."); }
			$xml = simplexml_load_string($file);
				
			foreach($xml->subject as $subject) {
				$subjects .= $subject. ",";
			}
			$fields = array(
				'Title'         => $xml->title, 
				'Volume'        => $xml->volume, 
				'Creator'       => $xml->creator, 
				'Subject'       => $this->commaReplace($subjects), 
				'Publisher'     => $xml->publisher, 
				'Pub_Date'      => $xml->date, 
				'Language'      => $xml->language, 
				'Sponsor'       => $xml->sponsor, 
				'Contributor'   => $xml->contributor, 
				'MediaType'     => $xml->mediatype,
				'Updatedate'    => $xml->updatedate,
				'identifier_id' => $file_id
			);
				
			$added = $this->writeMetadata($fields);
			if($added) { 
				echo 'metadata added for ' . $file_id . "\r\n";
			}
		} catch(Exception $e) {
			echo $e->getMessage() . "\r\n";
		}
	}
	
	public function actionMarcMeta() {
	
	}
	
	public function actionIaMeta() {
		$files = $this->getPaths('Title');
		if(empty($files)) { exit; }
		
		foreach($files as $file) {
			$url = $this->meta_url . $file['base_id'] . '/' . $file['base_id'] . '_meta.xml';
			$this->getIaMetadata($url, $file['id']);
		}
	}
	
	public function actionIaText() {
		$texts = $this->getPaths('item_text');
		if(empty($texts)) { exit; }
		
		foreach($texts as $text) {
			$full_text = $this->downloadText($text['base_id']);
			if($full_text) {
				$this->writeText(array($full_text, $text['id']));
				echo "Text file for: " . $text['id'] . " downloaded\r\n";
			} else {
				echo "Couldn't get text file for: " . $text['id'] . "\r\n";
			}
		}
	}
}