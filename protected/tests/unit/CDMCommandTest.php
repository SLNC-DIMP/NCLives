<?php
Yii::import('application.commands.CDMCommand');

class CDMCommandTest extends CDbTestCase {
	public function testShellCommand() {
		 $commandName = 'CDM';
		 $CCRunner = new CConsoleCommandRunner();			
		 $cdm = new CDMCommand($commandName,$CCRunner);
	}
}