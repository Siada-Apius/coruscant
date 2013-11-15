<?php

class GamesController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $gamesDb = new Application_Model_DbTable_Games();
        $games = $gamesDb->getItemsList();
        $this->view->games = $games;
    }

    public function articleAction()
    {
        $gamesDb = new Application_Model_DbTable_Games();

        $id = $this->getRequest()->getParam('id');
        $games = $gamesDb->getItem($id);
        if ($games['status'] != 1) $this->redirect('/games');
    }


}



