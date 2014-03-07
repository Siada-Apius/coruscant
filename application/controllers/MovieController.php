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

        $this->view->receive = $movieDb->getMovies();
    }

    public function articleAction()
    {
        $id = $this->getRequest()->getParam('id');
        $type = array('slider', 'ost', 'text');

        $movieDb    = new Application_Model_DbTable_Movies();
        $movieImgDb = new Application_Model_DbTable_MovieImg();

        $movie = $movieDb->getMovieWhereId($id);
        $movieImg  = $movieImgDb->getMovieImageWhere($id, $type);

        if ($movie['status'] != 1) $this->redirect('/movie');

        $this->view->movie = $movie;
        $this->view->movieImg = $movieImg;

    }
}







