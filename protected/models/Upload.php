<?php
class Upload {
	/**
	* Load files to upload into database.
	* @param $file
	*/
	public function setList($file) {
		$sql = "INSERT INTO upload(file) VALUES(?)";
		Yii::app()->db->createCommand($sql)
			->execute(array($file));		
	}
	
	public function updateDelete($file_id) {
		$sql = "UPDATE upload SET deleted = ? WHERE id = ?";
		Yii::app()->db->createCommand($sql)
			->execute(array(1, $file_id));	
	}
	
	public function updateMissing($file_name) {
		$sql = "UPDATE upload SET missing = ? WHERE file = ?";
		Yii::app()->db->createCommand($sql)
			->execute(array(1, $file_name));	
	}
	
	public function getList() {
		$sql = "SELECT id, file FROM upload WHERE deleted = 0 AND process_time > DATE_SUB(NOW(), INTERVAL 4 HOUR)";
		$files = Yii::app()->db->createCommand($sql)
			->queryAll();
		
		return $files;
	}
	
	/**
	* Grabs text from IA key file.
	* @return array
	*/
	public function getKeys() {
		return file('/home4/statelib/keys.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	}
	
	/**
	* Gets the actual key line needed for IA perl script to login to IA.
	* @return string
	*/
	public function loadKeys() {
		return end($this->getKeys());
	}
	
	/**
	* Converts IA perl script to an executable file.
	*/
	public function perlLoad() {
		return shell_exec(escapeshellcmd("chmod +x $this->_uploads_path/ias3upload.pl"));
	}
	
	/**
	* Reads metadata file and yanks out filenames for files to upload
	* File name should always be the 2nd field in a file line.
	* @return array
	*/
	public function readMetadata($path) {
		ini_set("auto_detect_line_endings", true); // added as Mac line endings freak out Windows and Linux
		$file_list = array();
		$meta_files = file($path . '/metadata.csv');
		unset($meta_files[0]);
		
		foreach($meta_files as $meta_file) {
			$file_name = explode(',', $meta_file);
			$file_list[] = $file_name[1];
		}
		
		return $file_list;
	}
	
	public function compareFileNamesDisk(array $meta_files, array $file_names) {
		foreach($file_names as $key => $disk_file) {
			if(!in_array($disk_file, $meta_files) && !is_dir($meta_file)) {
				echo $disk_file . " is present on the filesystem list but not in the metadata.\r\n";
			}
		}
	}
	
	public function compareFileNamesMeta(array $meta_files, array $file_names) {
		foreach($meta_files as $key => $meta_file) {
			if(!in_array($meta_file, $file_names) && !is_dir($meta_file)) {
				$this->updateMissing($meta_file);
				echo $disk_file . " is present in the metadata list but not on the filesystem.\r\n";
			}
		}
	}
}