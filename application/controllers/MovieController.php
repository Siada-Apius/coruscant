<?php

class MovieController extends Zend_Controller_Action
{

    public function init()
    {

        $this   ->_helper->AjaxContext()
                ->addActionContext('article','json')
                ->initContext('json')
        ;

    }

    public function indexAction()
    {
        $movieDb = new Application_Model_DbTable_Movies();

        $this->view->receive = $movieDb->getItemsList();
    }

    public function articleAction()
    {
        $id = $this->getRequest()->getParam('id');
        $type = array('slider', 'ost', 'text');

        $movieDb    = new Application_Model_DbTable_Movies();
        $movieImgDb = new Application_Model_DbTable_MovieImg();

        $movie = $movieDb->getItem($id);
        $movieImg  = $movieImgDb->getItemsWhere($id, $type);

        $this->view->movie = $movie;
        $this->view->movieImg = $movieImg;



    }

}







