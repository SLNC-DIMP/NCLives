<?php
class LuceneCommand extends CConsoleCommand {
	private $_indexFiles = 'runtime.search';
  
    public function init(){
        Yii::import('application.vendors.*');
        require_once('Zend/Search/Lucene.php');
        parent::init(); 
    }
	
	protected function getContent($table) {
		$sql = "SELECT * FROM $table";
		$data = Yii::app()->db->createCommand($sql)
			->queryAll();
		
		return $data;
	}
	
	 public function actionCreate() {
        $index = new Zend_Search_Lucene(Yii::getPathOfAlias('application.' . $this->_indexFiles), true);
 		$tables = array('ia_records', 'cdm_records');
		
		foreach($tables as $table) {
        $pages = $this->getContent($table);
        foreach($pages as $page){
            $doc = new Zend_Search_Lucene_Document();
			
			$doc->addField(Zend_Search_Lucene_Field::UnIndexed('table',
                                          CHtml::encode($table), 'utf-8'));
			
			$doc->addField(Zend_Search_Lucene_Field::UnIndexed('page_id',
                                          CHtml::encode($page['id']), 'utf-8'));

		/*	$doc->addField(Zend_Search_Lucene_Field::UnIndexed('identifier',
                                                   CHtml::encode($page['identifier']), 'utf-8'));  */
												   
			$doc->addField(Zend_Search_Lucene_Field::UnIndexed('base_id',
                                                   CHtml::encode($page['base_id']), 'utf-8'));
			$doc->addField(Zend_Search_Lucene_Field::UnIndexed('image_path',
                                                   CHtml::encode($page['image_path']), 'utf-8'));
			
			$doc->addField(Zend_Search_Lucene_Field::UnIndexed('url_link',
                                                   CHtml::encode($page['url_link']), 'utf-8'));
			
			$doc->addField(Zend_Search_Lucene_Field::UnIndexed('Url',
                                                   CHtml::encode($page['Url']), 'utf-8'));
            
			$doc->addField(Zend_Search_Lucene_Field::Text('Title',
                                          CHtml::encode($page['Title']), 'utf-8')
            );
    
            $doc->addField(Zend_Search_Lucene_Field::Text('Creator',
                                          CHtml::encode($page['Creator']), 'utf-8')
            );
			$doc->addField(Zend_Search_Lucene_Field::Text('Subjects',
                                          CHtml::encode($page['Subjects']), 'utf-8')
            );
			
            $index->addDocument($doc);
        }}
        
		$index->commit();
		$index->optimize();
        echo "Lucene index created\r\n";
    }
}