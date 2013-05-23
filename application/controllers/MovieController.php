<?php

class MovieController extends Zend_Controller_Action
{

    public function init()
    {

        $this   ->_helper->AjaxContext()
                ->addActionContext('article','json')
                ->initContext('json');

    }

    public function indexAction()
    {
        $movieDb = new Application_Model_DbTable_Movies();

        $response = $movieDb->getAllMovie();
        $this->view->receive = $response;
    }

    public function articleAction()
    {
        $movieDb = new Application_Model_DbTable_Movies();

        $id = $this->getRequest()->getParam('id');

        $movie = $movieDb->getItem($id);
        $this->view->movie = $movie;

    }

}







