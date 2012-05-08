<?php
// Requires PEAR packages Structures_LinkedList and File_MARC
// See link for documentation: http://pear.php.net/manual/en/package.fileformats.file-marc.reading.php
require_once 'File/MARCXML.php';

class MetadataCommand extends CConsoleCommand {
	protected $marc;
	protected $base_url = 'http://www.archive.org/download/';
	protected $metadata;
	
	public function __construct() {
		$this->metadata = array('marc.xml', 'meta.xml');
	//	$this->marc = new File_MARCXML($this->base_url . $file . '/' . $file . '_marc.xml', File_MARC::SOURCE_FILE);
	}
	
	protected function getPaths() {
		$sql = "SELECT id, base_id FROM identifiers WHERE ia_meta = 0";
		$query = Yii::app()->db->createCommand($sql)
			->queryAll();
		
		return $query;
	}
	
	protected function updateMetadata($id) {
		$sql = "UPDATE identifiers SET ia_meta = 1 WHERE id = ?";	
		Yii::app()->db->createCommand($sql)
			->execute(array($id));
	}
	
	protected function writeMetadata(array $fields) {
		$sql = "INSERT into ia_metadata(" . $this->formatQuery($fields) . ") 
			values(" . $this->formatValues($fields) . ")";
			
		$query = Yii::app()->db->createCommand($sql)
			->execute(array_values($fields));
			
		return $query;
	}
	
	protected function formatQuery(array $fields) {
		$query_fields = implode(',', array_keys($fields));
	
		return $query_fields;
	}
	
	protected function formatValues(array $fields) {
		$field_values = '';
		
		for($i=0; $i<count($fields); $i++) {
			$field_values .= '?,';
		}
		 
		return $this->commaReplace($field_values);
	}
	
	protected function commaReplace($string) {
		return substr_replace($string, '', -1);
	}
	
	/**
	* Pulls out Internet Archive Metadata
	* IA uses redirects which simplexml_load_file doesn't deal well with.
	* Hence the use of file_get_contents() and simplexml_load_string();
	*/
	protected function getIaMetadata($url, $file_id) {
		$subjects = '';
		
	
		$file = file_get_contents($url);
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
			'Date'          => $xml->date, 
			'Language'      => $xml->language, 
			'Sponsor'       => $xml->sponsor, 
			'Contributor'   => $xml->contributor, 
			'MediaType'     => $xml->mediatype,
			'Updatedate'    => $xml->updatedate,
			'identifier_id' => $file_id
		);
			
		$added = $this->writeMetadata($fields);
		if($added) { 
			$this->updateMetadata($file_id); 
			echo 'metadata added for ' . $file_id . "\r\n";
		}
	//	} else {
	//		return false;
	//	}
	}
	
	public function actionMarcMeta() {
	
	}
	
	public function actionIaMeta() {
		$files = $this->getPaths();
		if(empty($files)) { exit; }
		
		foreach($files as $file) {
			$url = $this->base_url . $file['base_id'] . '/' . $file['base_id'] . '_meta.xml';
			$this->getIaMetadata($url, $file['id']);
		}
	}
}