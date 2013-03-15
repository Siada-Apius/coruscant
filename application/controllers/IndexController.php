<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        #$user = new Application_Model_DbTable_Magazine();
        #$this->view->magazine = $user->getUsers();

    }

    public function indexAction()
    {

        $articles = new Application_Model_DbTable_Articles();
        $this->view->articles = $articles->getArticles();
    }

    public function mailAction()
    {
        $email = new Application_Form_Mail();
        $this->view->mailForm = $email;

        if ($this->getRequest()->isPost()){

            $param = $this->getRequest()->isPost();

            $sendMail = new Application_Model_Users();
            $sendMail->justSendSimpleEmil();

        }

    }

}









