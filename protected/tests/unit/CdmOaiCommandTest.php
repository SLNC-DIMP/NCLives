<?php
Yii::import('application.commands.CdmOaiCommand');

class CdmOaiCommandTest extends CDbTestCase {
	public function testShellCommand() {
		 $commandName = 'CdmOai';
		 $CCRunner = new CConsoleCommandRunner();			
		 $cdm_oai = new CdmOaiCommand($commandName,$CCRunner);
	}
}