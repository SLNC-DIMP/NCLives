<?php
Yii::import('application.commands.IaOaiCommand');

class IaOaiCommandTest extends CDbTestCase {
	public function testShellCommand() {
		 $commandName = 'IaOai';
		 $CCRunner = new CConsoleCommandRunner();			
		 $ia_oai = new CdmOaiCommand($commandName,$CCRunner);
	}
}