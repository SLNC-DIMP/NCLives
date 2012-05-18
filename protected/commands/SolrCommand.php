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
		$ia_doc->title =  $doc['Title'];
		$ia_doc->volume = $doc['Volume'];
		$ia_doc->creator = $doc['Creator'];
		$ia_doc->subject = $doc['Subject'];
		$ia_doc->publisher = $doc['Publisher'];
		$ia_doc->pub_date = $doc['Pub_Date'];
		$ia_doc->language = $doc['Language'];
		$ia_doc->sponsor = $doc['Sponsor'];
		$ia_doc->contributor = $doc['Contributor'];
		$ia_doc->media_type = $doc['MediaType'];
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