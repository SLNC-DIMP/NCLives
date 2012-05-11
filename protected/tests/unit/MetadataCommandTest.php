<?php
Yii::import('application.commands.MetadataCommand');

class MetadataCommandTest extends CDbTestCase {
	public function testShellCommand() {
		 $commandName = 'Metadata';
		 $CCRunner = new CConsoleCommandRunner();			
		 $meta = new MetadataCommand($commandName,$CCRunner);
	}
}