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

        $games = $gamesDb->getGames();
        $this->view->games = $games;
    }

    public function articleAction()
    {
        $gamesDb = new Application_Model_DbTable_Games();

        $game = $gamesDb->getGameWhereId($this->getRequest()->getParam('id'));

        if ($game['status'] != 1) $this->redirect('/games');
        $this->view->game = $game;
    }


}



