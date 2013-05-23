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


}

