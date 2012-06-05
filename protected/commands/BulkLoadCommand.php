<?php
class BulkLoadCommand extends CConsoleCommand {
	private $_uploads_path = '/home4/statelib/public_html/ajaxplorer/data/files';
	
	protected function setList($file) {
		$sql = "INSERT INTO upload(file) VALUES(?)";
		Yii::app()->db->createCommand($sql)
			->execute(array($file));		
	}
	
	protected function updateList($file_id) {
		$sql = "UPDATE upload SET deleted = ? WHERE id = ?";
		Yii::app()->db->createCommand($sql)
			->execute(array(1, $file_id));	
	}
	
	protected function updateList2($file_name) {
		$sql = "UPDATE upload SET missing = ? WHERE filename = ?";
		Yii::app()->db->createCommand($sql)
			->execute(array(1, $file_name));	
	}
	
	protected function getList() {
		$sql = "SELECT id, file FROM upload WHERE deleted = 0 AND process_time > DATE_SUB(NOW(), INTERVAL 4 HOUR)";
		$files = Yii::app()->db->createCommand($sql)
			->queryAll();
		
		return $files;
	}
	
	protected function getKeys() {
		return file('/home4/statelib/keys.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	}
	
	protected function loadKeys() {
		return end($this->getKeys());
	}
	
	protected function perlLoad() {
		return shell_exec(escapeshellcmd("chmod +x $this->_uploads_path/ias3upload.pl"));
	}
	
	/**
	* File name should always be the 2nd field in a file line.
	*/
	protected function readMetadata() {
		ini_set("auto_detect_line_endings", true); // added as Mac line endings freak out Windows and Linux
		$file_list = array();
		$meta_files = file($this->_uploads_path . '/metadata.csv');
		unset($meta_files[0]);
		
		foreach($meta_files as $meta_file) {
			$file_name = explode(',', $meta_file);
			$file_list[] = $file_name[1];
		}
		
		return $file_list;
	}
	
	protected function compareFileNamesDisk(array $meta_files, array $file_names) {
		foreach($file_names as $key => $disk_file) {
			if(!in_array($disk_file, $meta_files) && !is_dir($meta_file)) {
				echo $disk_file . " is present on the filesystem list but not in the metadata.\n";
			}
		}
	}
	
	protected function compareFileNamesMeta(array $meta_files, array $file_names) {
		foreach($meta_files as $key => $meta_file) {
			if(!in_array($meta_file, $file_names) && !is_dir($meta_file)) {
				echo $disk_file . " is present in the metadata list but not on the filesystem.\n";
			}
		}
		if($error > 0) { echo "Please correct the error(s) above and try again.\n"; exit; }
	}
	
	protected function csvEdit() {
		$fh = fopen($this->_uploads_path . '/metadata.csv', 'rw');
		
		fclose($fh);
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
		$files = preg_grep('/pdf$/i', scandir($this->_uploads_path));                    
		if(empty($files)) { echo "There are no files to load"; exit; }
		
		if(!empty($files)) {
			$meta_files = $this->readMetadata();
			$this->compareFileNamesMeta($meta_files, $files);
			$this->compareFileNamesDisk($meta_files, $files); 
			
			$this->perlLoad();
			$process_files = shell_exec(escapeshellcmd("perl $this->_uploads_path/ias3upload.pl -k " . $this->loadKeys() . " -l $this->_uploads_path/metadata.csv"));
			
			echo $process_files;
		} 
	} 
}