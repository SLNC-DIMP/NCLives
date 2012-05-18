<?php
class SolrController extends Controller {
	public function actionSearch() {
		if(($term = trim(Yii::app()->getRequest()->getParam('q'))) !== '') {
			$criteria = new ASolrCriteria;
			$criteria->setLimit(5000);
			
			$term = strip_tags(trim($term));
			
			$results = ASolrDocument::model()->findAllByAttributes(array("Title" => $term, 'Contributor' => $term),  $criteria);
		} else {
			$results = 0;
		}
		
		$this->render('search', compact('results', 'term'));
	}
}