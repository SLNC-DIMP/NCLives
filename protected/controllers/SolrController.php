<?php
class SolrController extends Controller {
	public function actionSearch() {
		if(($term = trim($_GET['q'])) !== '') {
			$criteria = new ASolrCriteria;
			$criteria->setLimit(5000);
			
			$term = filter_var($term, FILTER_SANITIZE_STRING);
			
			$data = ASolrDocument::model()->findAllByAttributes(array("Title" => $term, 'Contributor' => $term),  $criteria);
			
			$results=new CArrayDataProvider($data, array(
				'id'=>'search',
				'pagination'=>array(
					'pageSize'=>10,
				),
			));
			
			$item_count = $results->itemCount;
		} else {
			$results = array();
		}
		
		$this->render('search', compact('results', 'term', 'item_count'));
	}
}