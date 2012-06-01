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
		
		$this->exportKeys();
		$this->perlLoad();
		
		foreach($files as $file) {
			if(preg_match('/pdf$/i', $file)) {
				$this->setList($file);
				echo $file . "\n";
			}
		}
	}
}