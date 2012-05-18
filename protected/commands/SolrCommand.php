<?php

class SolrCommand extends CConsoleCommand {
	protected function getDocuments($table) {
		$sql = "SELECT * FROM $table";
		
		$documents = Yii::app()->db->createCommand($sql)
			->queryAll();
		
		return $documents;
	}
	
	protected function addIaDoc($doc) {
		$ia_doc = new ASolrDocument();
		
		$ia_doc->id = $doc['id'];
		$ia_doc->Title =  $doc['Title'];
		$ia_doc->Volume = $doc['Volume'];
		$ia_doc->Creator = $doc['Creator'];
		$ia_doc->Subject = $doc['Subject'];
		$ia_doc->Publisher = $doc['Publisher'];
		$ia_doc->Pub_Date = $doc['Pub_Date'];
		$ia_doc->Language = $doc['Language'];
		$ia_doc->Sponsor = $doc['Sponsor'];
		$ia_doc->Contributor = $doc['Contributor'];
		$ia_doc->MediaType = $doc['MediaType'];
		$ia_doc->item_text = $doc['item_text'];
		$ia_doc->image_path = $doc['image_path'];
		$ia_doc->base_id = $doc['base_id'];
	
		$ia_doc->save();
		$ia_doc->getSolrConnection()->commit();
	}
	
	public function actionAddIaDocs() {
		$docs = $this->getDocuments('ia_records');
		
		foreach($docs as $doc) {
			$this->addIaDoc($doc);
		}
	}
}