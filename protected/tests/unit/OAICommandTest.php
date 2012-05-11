<?php
Yii::import('application.commands.OAICommand');

class OAICommandTest extends CDbTestCase {
	public function testShellCommand() {
		 $commandName = 'OAI';
		 $CCRunner = new CConsoleCommandRunner();			
		 $oai = new OAICommand($commandName,$CCRunner);
	}
}