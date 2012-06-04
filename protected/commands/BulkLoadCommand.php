<?php
class BulkLoadCommand extends CConsoleCommand {
	private $_uploads_path = '';
	
	protected function setList($file) {
		$sql = "INSERT INTO upload(file) VALUES(?)";
		Yii::app()->db->createCommand($sql)
			->execute(array_values($file));		
	}
	
	protected function updateList($file_id) {
		$sql = "UPDATE upload SET deleted = ? WHERE id = ?";
		Yii::app()->db->createCommand($sql)
			->execute(array_values(1, $file_id));	
	}
	
	protected function getList() {
		$sql = "SELECT id, file FROM upload WHERE deleted = 0 AND process_time > DATE_SUB(NOW(), INTERVAL 4 HOUR)";
		$files = Yii::app()->db->createCommand($sql)
			->queryAll();
		
		return $files;
	}
	
	protected function getKeys($path) {
		return file('/home4/statelib/keys.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	}
	
	protected function loadKeys() {
		return end($this->getKeys());
	}
	
	protected function exportKeys() {
		return shell_exec(escapeshellcmd('export ' . $this->loadKeys()));
	}
	
	protected function perlLoad() {
		return shell_exec(escapeshellcmd("chmod +x $this->_uploads_path/ias3upload.pl"));
	}
	
	/**
	* File name should always be the 3rd field in a file line.
	*/
	protected function readMetadata() {
		$file_list = array();
		$meta_files = file($this->_uploads_path . '/metadata.csv');
		
		foreach($meta_files as $meta_file) {
			$file_name = explode(',', $meta_file);
			$file_list[] = $file_name[2];
		}
		
		return $file_list;
	}
	
	protected function compareFileNamesMeta(array $db_files, array $file_names) {
		foreach($file_names as $disk_file) {
			if(!in_array($disk_file, $db_files)) {
				echo $disk_file . " is present in the metadata list but not on the filesystem.\n";
			}
		}
	}
	
	protected function compareFileNamesDisk(array $db_files, array $file_names) {
		foreach($db_files as $db_file) {
			if(!in_array($db_file, $file_names)) {
				echo $db_file . " is present on the filesytem but not in the metadata list.\n";
			}
		}
	}
	
	public function actionDelete() {
		$files = $this->getList();
		if(empty($files)) { echo "There are no files to delete"; exit; }
		
		foreach($files as $file) {
			$deleted = @unlink($file['file']);
			if($deleted) {
				$this->updateList($file['id']);
			}
		}
	}
	
	public function actionLoad() {
		$files = scandir($this->_uploads_path);
		if(empty($files)) { echo "There are no files to load"; exit; }
		
		$disk_files = array();
		foreach($files as $file) {
			if(preg_match('/pdf$/i', $file) && !is_dir($file)) {
				$this->setList($file);
				$disk_files[] = $file;
			}
		}
		
		if(!empty($disk_files)) {
			$meta_files = $this->readMetadata();
			$this->compareFileNamesMeta($disk_files, $meta_files);
			$this->compareFileNamesDisk($disk_files, $meta_files); 
			
			$this->exportKeys();
			$this->perlLoad();
			
			$process_files = shell_exec(escapeshellcmd("perl $this->_uploads_path/ias3upload.pl"));
			
			echo $process_files;
		}
	}
}