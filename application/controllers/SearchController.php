<?php

class SearchController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        Zend_Search_Lucene_Analysis_Analyzer::setDefault(new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8());
        #Zend_Search_Lucene_Analysis_Analyzer::setDefault(new Zend_Search_Lucene_Analysis_Analyzer_Common_TextNum_CaseInsensitive());

        $path = realpath(APPLICATION_PATH . '/../www/' . DIRECTORY_SEPARATOR . 'data');
        $index = Zend_Search_Lucene::open($path);

        $searchString = $this->getRequest()->getParam('query');

        $hits = $index->find($searchString);

        $in = array();

        foreach($hits as $value){

            $in[] = $value->ids;

        }


        $articleDb = new Application_Model_DbTable_Articles();
        $this->view->articles = $articleDb->getArticlesIn($in);

    }

    public function reindexAction()
    {
        $articleDb = new Application_Model_DbTable_Articles();

        Zend_Search_Lucene_Analysis_Analyzer::setDefault(new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8Num_CaseInsensitive());

        @mkdir(realpath(APPLICATION_PATH . '/../www/') . DIRECTORY_SEPARATOR . 'data');

        $index = Zend_Search_Lucene::create(realpath(APPLICATION_PATH . '/../www/' . DIRECTORY_SEPARATOR . 'data'));
        $data = $articleDb->getItemsList();

        foreach($data as $value)
        {
            $doc = new Zend_Search_Lucene_Document();

            $doc->addField(Zend_Search_Lucene_Field::Text('ids', $value['id'], 'UTF-8'));
            $doc->addField(Zend_Search_Lucene_Field::Text('titles', $value['title'], 'UTF-8'));
            $doc->addField(Zend_Search_Lucene_Field::Text('mini_imgs', $value['miniImg'], 'UTF-8'));
            $doc->addField(Zend_Search_Lucene_Field::Text('fulls', $value['full'], 'UTF-8'));

            $index->addDocument($doc);

        }

        echo count($data);
    }


}



