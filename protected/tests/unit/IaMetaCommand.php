<?php
Yii::import('application.commands.IaMetaCommand');

class IaMetaCommandTest extends CDbTestCase {
	public function testShellCommand() {
		 $commandName = 'IaMeta';
		 $CCRunner = new CConsoleCommandRunner();			
		 $ia_meta = new CdmOaiCommand($commandName,$CCRunner);
		 
		 $ia_meta->actionLoad();
	}
}