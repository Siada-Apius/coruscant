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

        $page = (Zend_Controller_Front::getInstance()->getRequest()->getParam('page')) ? Zend_Controller_Front::getInstance()->getRequest()->getParam('page') : '1';
        $from = ($page - 1) * 5;

        $articles = new Application_Model_DbTable_Articles();
        $this->view->articles = $articles->getArticles($from);
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

    public function articleAction()
    {

        $article = new Application_Model_DbTable_Articles();
        #$addCom = new Application_Form_Comment();


        /* -------------------------- AJAX -------------------- */
        if ($this->getRequest()->isXmlHttpRequest()){

            $articleId = $this->getRequest()->getPost('id');


            if ($this->getRequest()->getParam('article_id')){

                $comment = new Application_Model_DbTable_Comments();
                $comment->addComment($this->getRequest()->getParams(), $this->getRequest()->getParam('article_id'));

            }


            $siada = $this->getRequest()->getParam('siada');

            if($this->getRequest()->getParam('siada')){  #чи посланий аргумент siada  $this->getRequest()->getParam('siada') == 1

                if($this->getRequest()->getParam('siada') == 1){
                    $data = $article->getItem($articleId); //масив із значеннями статті
                    $data['ratingGood'] = $data['ratingGood'] + 1;
                }else{
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

            ///////// AJAX FOR COMMENTS

            $request = $this->getRequest()->getPost();

        }
        /* -------------------------- AJAX -------------------- */

        else{

            $id = $this->getRequest()->getParam('id');

            $this->view->sukaID = $id; //Вивід коментраів по ід

            $this->view->articles = $article->getArticlesById($this->getRequest()->getParam('id'));


            $addCom = new Application_Form_Comment();
            $this->view->form = $addCom;

            if ($this->getRequest()->isPost()) {

                $data = $this->getRequest()->getPost();

                if ($addCom->isValid($data)){

                    $comment = new Application_Model_DbTable_Comments();
                    $comment->addComment($data, $id);
                }
            }

        }

    }


}











