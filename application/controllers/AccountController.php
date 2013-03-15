<?php

class AccountController extends Zend_Controller_Action
{

    public function init()
    {
        $user = new Application_Model_DbTable_Magazine();
        $this->view->magazine = $user->getUsers();
    }

    public function indexAction()
    {
        // action body
    }


}