<?php
class LuceneController extends Controller {
	private $_indexFiles = 'runtime.search';
    
    public function init(){
        Yii::import('application.vendors.*');
        require_once('Zend/Search/Lucene.php');
        parent::init(); 
    }
	
	public function actionSearch() {
        if (($term = Yii::app()->getRequest()->getParam('q', NULL)) !== NULL) {
            $index = new Zend_Search_Lucene(Yii::getPathOfAlias('application.' . $this->_indexFiles));
            $data = $index->find(strip_tags(trim($term)));
			$count = count($data);
			$results=new CArrayDataProvider($data, array(
				'id'=>'search',
				'pagination'=>array(
					'pageSize'=>10,
				),
			));
         //   $query = Zend_Search_Lucene_Search_QueryParser::parse($term);       
        } else {
			$results = array();
			$count = 0;
		}
		
		$this->render('search', compact('results', 'term', 'count'));
    }
}