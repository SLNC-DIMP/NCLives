<?php
Yii::import('application.commands.OAI');

class CdmOaiCommand extends OAI {
	protected function writeSets(array $values) {
		$sql = "INSERT into oai_sets(set_id, set_name) VALUES(?, ?)";
		Yii::app()->db->createCommand($sql)
			->execute($values);
	}
	
	/**
	* Get all sets except Selections from Print Collections & State Publications
	* And writes them to the oai_sets table
	* @param $base_url
	*/
	protected function getSets($base_url) {
		$url = $base_url . 'verb=ListSets';
		$oai_records = simplexml_load_file($url);
		
		foreach($oai_records as $records) {
			foreach($records as $record) {
				if(isset($record->setSpec) && ($record->setSpec != 'p249901coll37' || $record->setSpec != 'p249901coll22')) {
					$this->writeSets(array($record->setSpec, $record->setName));
					echo $record->setSpec . ' - ' . $record->setName . "\n";
				}
			}
		}
	}
	
	protected function urlLink($base_id) {
		$id = explode('/', $base_id);
		return 'http://cdm16062.contentdm.oclc.org/cdm/ref/collection/' . $id[0] . '/id/'. $id[1];
	}
	
	public function actionSets() {
		$this->getSets($this->base_cdm_url);
	}
	
	public function actionIdentifiers() {
		$sets = $this->readSets('cdm');
		
		foreach($sets as $set) {
			$url = $this->base_cdm_url . "verb=ListIdentifiers&set=" . $set['set_id'] . "&metadataPrefix=oai_dc";
			$this->getIdentifiers($url, 'cdm_records');
		}		
	}
	
	/**
	* This command won't do anything if there aren't already some identifiers in the db.
	*/
	public function actionRecords() {
		$identifiers = $this->getIdentifiersList('cdm_records');
		if(empty($identifiers)) { echo "There are no records to retrieve or update\r\n"; exit; }
		
		foreach($identifiers as $identity) {
			$this->getRecord('cdm_records', $identity['id'], $identity['identifier'], $identity['base_id'], false);
		}
	}
}