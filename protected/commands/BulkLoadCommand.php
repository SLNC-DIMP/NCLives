<?php
yii::import('application.models.Upload');

class BulkLoadCommand extends CConsoleCommand {
	/**
	* Path to files to upload to IA
	*/
	private $_uploads_path = '/home4/statelib/public_html/ajaxplorer/data/files';
	protected $upload;
	
	public function __construct() {
		$this->upload = new Upload;
	}
	
	public function actionDelete() {
		$files = $this->upload->getList();
		
		if(!empty($files)) { 
			foreach($files as $file) {
				$deleted = @unlink($file['file']);
				if($deleted) {
					$this->upload->updateList($file['id']);
				}
			}
			
			return 0;
		}
		
		return 'empty';
	}
	
	public function actionLoad($path = "") {
		$path = (empty($path)) ? $this->_uploads_path : $path;
		$files = preg_grep('/pdf$/i', scandir($path));                    
		
		if(!empty($files)) {
			$meta_files = $this->upload->readMetadata($path);
			
			foreach($meta_files as $file) {
				$this->upload->setList($file);
			}
			
			$this->upload->compareFileNamesMeta($meta_files, $files);
			$this->upload->compareFileNamesDisk($meta_files, $files); 
			
			$this->upload->perlLoad();
			$process_files = shell_exec(escapeshellcmd("perl $this->_uploads_path/ias3upload.pl -k -n " . 
									$this->upload->loadKeys() . " -l $path/metadata.csv"));
			
			echo $process_files;
			
			return 0;
		} 
		
		return 'empty';
	} 
}