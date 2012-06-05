<?php
Yii::import('application.commands.CdmMetaCommand');

class CdmMetaCommandTest extends CDbTestCase {
	public function testShellCommand() {
		 $commandName = 'CdmMeta';
		 $CCRunner = new CConsoleCommandRunner();			
		 $cdm_meta = new CdmMetaCommand($commandName,$CCRunner);
	}
}