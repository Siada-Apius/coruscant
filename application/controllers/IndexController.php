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
        $comment = new Application_Model_DbTable_Comments();
        $addCom = new Application_Form_Comment();


        /* -------------------------- AJAX -------------------- */
        if ($this->getRequest()->isXmlHttpRequest()){

            $articleId = $this->getRequest()->getPost('id');

            if ($this->getRequest()->getParam('article_id')){

                $comment->addComment($this->getRequest()->getParams(), $this->getRequest()->getParam('article_id'));

            }

            $this->getRequest()->getParam('siada');

            if($this->getRequest()->getParam('siada')){  #чи посланий аргумент siada  $this->getRequest()->getParam('siada') == 1

                if ($this->getRequest()->getParam('siada') == 1){
                    $data = $article->getItem($articleId); //масив із значеннями статті
                    $data['ratingGood'] = $data['ratingGood'] + 1;
                } else {
                    $data = $article->getItem($articleId); //масив із значеннями статті
                    $data['ratingBad'] = $data['ratingBad'] + 1;

                }

                $update = array(

                    'ratingGood' => $data['ratingGood'],
                    'ratingBad' => $data['ratingBad']

                );

                $article->updateItem($update, (int)$articleId);

                $this->view->good =  $data['ratingGood'];
                $this->view->bad =  $data['ratingBad'];
            }

        } else {

            $id = $this->getRequest()->getParam('id');

            if ($this->getRequest()->isPost()) {

                $data = $this->getRequest()->getPost();

                if ($addCom->isValid($data)){

                    $comment->addComment($data, $id);
                }

            }

            $this->view->sukaID = $id;
            $this->view->articles = $article->getItem($this->getRequest()->getParam('id'));
            $this->view->form = $addCom;

        }

    }

}