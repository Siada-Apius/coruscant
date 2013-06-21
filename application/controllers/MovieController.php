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

        $movieDb        = new Application_Model_DbTable_Movies();
        $movieImgDb     = new Application_Model_DbTable_MovieImg();
        $movieImgOstDb  = new Application_Model_DbTable_MovieImgOst();

        $movie          = $movieDb->getItem($id);
        $movieImg       = $movieImgDb->getItemsWhere($id);
        $movieImgOst    = $movieImgOstDb->getItemsWhere($id);

        $this->view->movie = $movie;
        $this->view->movieImg = $movieImg;
        $this->view->movieImgOst = $movieImgOst;

    }

}







