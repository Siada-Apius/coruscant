<?php

class GamesController extends Zend_Controller_Action
{

    const SIADA = 'apius';

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $gamesDb = new Application_Model_DbTable_Games();

        $games = $gamesDb->getItemsList();
        $this->view->games = $games;

        self::SIADA;
    }


}

