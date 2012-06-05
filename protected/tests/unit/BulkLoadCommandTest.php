<?php
Yii::import('application.commands.BulkLoadCommand');
require_once 'vfsStream/vfsStream.php';

class BulkLoadCommandTest extends CDbTestCase {
	public function setUp() {
     	$this->structure = array('file1.pdf' => '', 
					'file2.pdf' => '', 
					'file3.pdf' => '', 
					'metadata.csv' => "'','file1.pdf'\n,'','file2.pdf'\n, '', 'file3.pdf',\n");
        $test = vfsStream::setup('test', NULL, $this->structure);
		
		$this->commandName = 'BulkLoad';
		$this->CCRunner = new CConsoleCommandRunner();			
		$this->bulk = new BulkLoadCommand($this->commandName,$this->CCRunner);
    }
	
	public function testactionLoad() {
		 $load = $this->bulk->actionLoad(vfsStream::url('test'));
		 
		 $this->assertEquals(0 , $load);
	}
	
	public function testactionDelete() {
		 $delete = $this->bulk->actionDelete();
		
		 $this->assertEquals('empty', $delete);
	}
}