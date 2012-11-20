<?php
class IaMetaCommand extends CConsoleCommand {
	protected $meta_url = 'http://www.archive.org/download/';
	protected $text_url = 'http://archive.org/details/';
	protected $format;
	
	public function __construct() {
		$this->format = new Format;
	}
	
	protected function getPaths($field) {
		$sql = "SELECT id, base_id FROM ia_records WHERE $field IS NULL OR $field = 0";
		$query = Yii::app()->db->createCommand($sql)
			->queryAll();
		
		return $query;
	}
	
	protected function writeText(array $fields) {
		$sql = "INSERT INTO ia_text(item_text, ia_record_id) VALUES(?, ?)";
		Yii::app()->db->createCommand($sql)
			->execute($fields);
		
		return Yii::app()->db->lastInsertID;
	}
	
	protected function writeMetadata(array $fields) {
		$sql = "UPDATE ia_records SET " . $this->format->formatQuery($fields) . " WHERE id = ?";
			
		$query = Yii::app()->db->createCommand($sql)
			->execute(array_values($fields));
			
		return $query;
	}
	
	protected function updateText($file_id) {
		$sql = "UPDATE ia_records SET fulltext_available = ? WHERE id = ?";
		Yii::app()->db->createCommand($sql)
			->execute(array(1, $file_id));
	}
	
	protected function updateImage(array $values) {
		$sql = "UPDATE ia_records SET image_path = ? WHERE id = ?";
		Yii::app()->db->createCommand($sql)
			->execute($values);
	}
	
	
	/**
	* Grabs IA file full text for processing
	* Files too big to grab with file_get_contents()
	* @param $identifier
	* @return string
	*/
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
				'Subjects'      => $this->format->commaReplace($subjects), 
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
	
	/**
	* Converts IA animated gifs into a static png
	* See comment by max lloyd http://mx.php.net/imagecreatefromgif
	*/
	protected function getGif($file, $base_id, $file_id) {
		$gif = @imagecreatefromgif($file);
		if($gif) {
			$path = 'images/' . $base_id . '.png';
			$png = @imagepng($gif, '../'.$path);
			if($png) {
				$this->updateImage(array($path, $file_id));
				echo $path . " created\r\n";
			}
			@imagedestroy($gif);
		}
	}
	
	public function actionIaMeta() {
		$files = $this->getPaths('Title');
		if(empty($files)) { exit; }
		
		foreach($files as $file) {
			$url = $this->meta_url . $file['base_id'] . '/' . $file['base_id'] . '_meta.xml';
			$this->getIaMetadata($url, $file['id']);
		}
	}
	
	/**
	* Grabs the full text for each pdf from the Internet Archive
	*/
	public function actionIaText() {
		$texts = $this->getPaths('fulltext_available');
		if(empty($texts)) { exit; }
		
		foreach($texts as $text) {
			$full_text = $this->downloadText($text['base_id']);
			if($full_text) {
				$insert_id = $this->writeText(array($full_text, $text['id']));
				$this->updateText($insert_id);
				echo "Text file for: " . $text['id'] . " downloaded\r\n";
			} else {
				echo "Couldn't get text file for: " . $text['id'] . "\r\n";
			}
		}
	}
	
	/**
	* Generates a png thumbnail from the animated gifs used by the Internet Archive.
	*/
	public function actionIaGif() {
		$images = $this->getPaths('image_path');
		if(empty($images)) { exit; }
		
		foreach($images as $image) {
			$path = 'http://archive.org/download/' . $image['base_id'] . '/' . $image['base_id'] . '.gif';
			$gif = $this->getGif($path, $image['base_id'], $image['id']);
		}
	}
}