<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {

    }

    public function indexAction()
    {
        $articles = new Application_Model_DbTable_Articles();

        $page = (Zend_Controller_Front::getInstance()->getRequest()->getParam('page')) ? Zend_Controller_Front::getInstance()->getRequest()->getParam('page') : '1';
        $from = ($page - 1) * 5;

        $this->view->articles = $articles->getArticles($from);
    }

    public function mailAction()
    {
        $email      = new Application_Form_Mail();
        $sendMail   = new Application_Model_Users();


        if ($this->getRequest()->isPost()){

            $param = $this->getRequest()->isPost();
            $sendMail->justSendSimpleEmil();

        }

        $this->view->mailForm = $email;

    }

    public function articleAction()
    {
        $article = new Application_Model_DbTable_Articles();

        $this->view->articles = $article->getArticleWhereId($this->getRequest()->getParam('id'));

    }

}