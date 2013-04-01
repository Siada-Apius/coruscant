<?php

class AdminController extends Zend_Controller_Action
{

    public function init()
    {
       /* $user = new Application_Model_DbTable_Magazine();
        $this->view->magazine = $user->getUsers();*/

        $this   ->_helper->AjaxContext()
                ->addActionContext('edit','json')
                ->initContext('json');
    }

    public function indexAction()
    {
        $articles = new Application_Model_DbTable_Articles();
        $this->view->articles = $articles->getArticles();
    }

    public function mediaAction()
    {

    }

    public function userAction()
    {
        // action body
    }

    public function addAction()
    {
        $addArticle = new Application_Form_Add();
        $addMovie = new Application_Form_Movies();

        $this->view->form = $addArticle;
        $this->view->movieForm = $addMovie;


        if ($this->getRequest()->isPost()) {

            $newData = $this->getRequest()->getPost();

            if ($addArticle->isValid($newData)){

                $user = new Application_Model_DbTable_Articles();
                $user       ->addArticles($newData); //$newData це масив, в який підставляється з Users.php дані форми

                if ($addArticle->isValid($newData)){

                    if(is_uploaded_file($_FILES["photo"]["tmp_name"])){

                        move_uploaded_file($_FILES["photo"]["tmp_name"], "img/miniImg/".$_FILES["photo"]["name"]);
                    }
                }
            }
        }
    }

    public function editAction()
    {

        $article = new Application_Model_DbTable_Articles();
        $editComments = new Application_Model_DbTable_Comments();



        if ($this->getRequest()->isXmlHttpRequest()){  // ЧИ ЦЕ Є AJAX

            if ($this->getRequest()->getParam('delId')) {

                $commentDel = new Application_Model_DbTable_Comments(); //виклик об'єкта класа
                $commentDel -> deleteComment($this->getRequest()->getParam('delId')); // виклик метода DELETE
                $this->view->id = $this->getRequest()->getParam('delId'); //вивід респонза з jquery, тобто в даному видадку це ксс
            }

        }else{

            #$article->getItem($id); ті методи доступні для всіх класів які його наслідуют, як бачиш
            #ше один з величезних плюсыв ооп

            $form = new Application_Form_Articles();

            if ($this->getRequest()->isPost()) {

                $editDate = $this->getRequest()->getPost(); #submit це значення лишне в масиві і не вийде з ним все зразу записати в бд тому його ансетим
                unset($editDate['submit']);

                $art = new Application_Model_DbTable_Articles();
                $art ->editArticles($editDate);

            }

            #то шо я казав, не видно змін бо вивід форми до того як ти вставив значення
            $this->view->articles = $article->getArticlesById($this->getRequest()->getParam('id')); //бере параметр ІД з метода getArticlesById
            $this->view->form = $form->populate($article->getArticlesById($this->getRequest()->getParam('id'))); //заповняє форму тими значеннями по ІД з getArticlesById

            /////////////////// КОМЕНТАРІ!!!!!

            $id = $this->getRequest()->getParam('id');

            $this->view->sukaID = $id; //Вивід коментраів по ід

            $this->view->articles = $article->getArticlesById($this->getRequest()->getParam('id'));


            //////////////////////////////////////

        }

    }

        /////////////////// КОМЕНТАРІ!!!!! КІНЕЦЬ

    public function commentsAction()
    {
        $wwc = new Application_Model_DbTable_Articles();
        $com = new Application_Model_DbTable_Comments();

        $this->view->articles = $wwc->workWithComments();
        $this->view->comments = $com->getAllComments();
    }


}











