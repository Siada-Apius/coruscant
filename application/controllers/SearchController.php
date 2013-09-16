<?php

class SearchController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }


    public function indexAction()
    {
        $articleDb  = new Application_Model_DbTable_Articles();
        $movieDb    = new Application_Model_DbTable_Movies();
        $gameDb     = new Application_Model_DbTable_Games();

        Zend_Search_Lucene_Analysis_Analyzer::setDefault(new Zend_Search_Lucene_Analysis_Analyzer_Common_TextNum_CaseInsensitive());

        $path = realpath(APPLICATION_PATH . '/../www/' . DIRECTORY_SEPARATOR . 'data');
        $index = Zend_Search_Lucene::open($path);

        $searchString = $this->getRequest()->getParam('query');

        $hits = $index->find($searchString);

        $art = array();
        $mov = array();
        $gam = array();

        foreach($hits as $value){

            if($value->type == "movie")     $mov[] = $value->ids;
            if($value->type == "article")   $art[] = $value->ids;
            if($value->type == 'game')      $gam[] = $value->ids;

        }

        $total = array();

        if($art) $total['articles']  = $articleDb->getArticlesIn($art);
        if($mov) $total['movies']    = $movieDb->getMoviesIn($mov);
        if($gam) $total['games']     = $gameDb->getGamesIn($gam);

        $this->view->total = $total;

    }


    public function reindexAction()
    {
        $articleDb  = new Application_Model_DbTable_Articles();
        $movieDb    = new Application_Model_DbTable_Movies();
        $gamesDb    = new Application_Model_DbTable_Games();

        Zend_Search_Lucene_Analysis_Analyzer::setDefault(new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8Num_CaseInsensitive());

        @mkdir(realpath(APPLICATION_PATH . '/../www/') . DIRECTORY_SEPARATOR . 'data');

        $index = Zend_Search_Lucene::create(realpath(APPLICATION_PATH . '/../www/' . DIRECTORY_SEPARATOR . 'data'));

        $total['movie']     = $movieDb->getItemsList();
        $total['article']   = $articleDb->getItemsList();
        $total['game']      = $gamesDb->getItemsList();

        foreach($total as $key => $value){

            $doc = new Zend_Search_Lucene_Document();

            foreach($value as $subVal){

                $doc->addField(Zend_Search_Lucene_Field::Text('type', $key, 'UTF-8'));
                $doc->addField(Zend_Search_Lucene_Field::Text('ids', $subVal['id'], 'UTF-8'));
                $doc->addField(Zend_Search_Lucene_Field::Text('titles', $subVal['title'], 'UTF-8'));
                $doc->addField(Zend_Search_Lucene_Field::Text('fulls', $subVal['full'], 'UTF-8'));

                $index->addDocument($doc);

            }

        }

        echo '
        <table border=1px>
            <tr>
                <td></td>
                <td>You have indexed</td>
            </tr>
            <tr>
                <td>Movies</td>
                <td>' . count($total['movie']) . '</td>
            </tr>
            <tr>
                <td>Articles</td>
                <td>' . count($total['article']) . '</td>
            </tr>
            <tr>
                <td>Games</td>
                <td>' . count($total['game']) . '</td>
            </tr>
            <tr>
                <td>TOTAL </td>
                <td>';
                    echo count($total['movie']) + count($total['article']) + count($total['game']) . '
                </td>
            </tr>
        </table>';

    }
}



