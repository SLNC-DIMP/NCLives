<?php
class SolrController extends Controller {
	public function actionSearch() {
		$this->layout = 'column2';
		
		if (($term = Yii::app()->getRequest()->getParam('q', NULL)) !== NULL) {
			$term = strip_tags(trim($term));
		//	$results = ASolrDocument::model()->findAllByAttributes(array("title" => $term));
			$dataProvider = new ASolrDataProvider(ASolrDocument::model());
			$dataProvider->criteria->query = "*";
			$results = $dataProvider->getData();
		} 
		
		$this->render('search', compact('results', 'term'));
	}
}