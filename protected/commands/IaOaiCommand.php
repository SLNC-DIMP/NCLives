<?php
Yii::import('application.commands.OAI');

class IaOAICommand extends OAI {
	private $ai_sets = array('ncgovdocs', 'asgii', 'statelibrarynorthcarolina');
	
	protected function urlLink($base_id) {
		return 'http://archive.org/details/' . $base_id;
	}
	
	protected function updateIdentifier(array $values) {
		$sql = "UPDATE ia_records SET url_link = ? WHERE id = ?";
		Yii::app()->db->createCommand($sql)
			->execute($values);
	}
	
	protected function actionSets() {
		foreach($this->ai_sets as $set) {
			 $this->writeSets(array($set, $set));
		}
	}
	
	protected function actionIdentifiers() {
		$sets = $this->readSets('ia');
		foreach($sets as $set) {
			$url = $this->base_ai_url . "verb=ListIdentifiers&set=collection:$set&metadataPrefix=oai_dc";
			$this->getIdentifiers($url, 'ia_records'); // oai:archive.org:illustratedhandb00sepa
		}		
	}
	
	/**
	* This command won't do anything if there aren't already some identifiers in the db.
	*/
	public function actionRecords() {
		$identifiers = $this->getIdentifiersList('ia_records');
		if(empty($identifiers)) { echo "There are no records to retrieve or update\r\n"; exit; }
		
		foreach($identifiers as $identity) {
			$this->getRecord('ia_records', $identity['id'], $identity['identifier'], $identity['base_id']);
		}
	}	
}