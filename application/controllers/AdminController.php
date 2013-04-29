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

    public function mediaAction(){

        $addMovie = new Application_Form_Movies();

    }

    public function userAction()
    {
        // action body
    }

    public function addAction()
    {
        $addArticleForm = new Application_Form_Articles();
        $addMovieForm = new Application_Form_Movies();

        $folderModel = new Application_Model_Folder();

        $articleDb = new Application_Model_DbTable_Articles();

        $response = $this->getRequest()->getParam('name');

        if ($response == 'article') {

            if( $this->getRequest()->isPost() ) {

                $params = $this->getRequest()->getPost();

                if ( $addArticleForm->isValid($params) ) {

                    $elem = $addArticleForm->getElement('miniImg');
                    $fileInfo = $elem->getFileInfo();

                    $params['miniImg'] = $fileInfo['miniImg']['name'];

                    $basePath = '/img/miniImg/';
                    $folderModel->createFolderChain($basePath, '/');
                    $imageDir = realpath(APPLICATION_PATH . '/../www/') . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'miniImg' . DIRECTORY_SEPARATOR;

                    $elem->setDestination($imageDir);
                    $elem->receive();

                    $articleDb->addArticles($params);

                    $this->redirect('/admin');
                }

                #if(is_uploaded_file($_FILES["photo"]["tmp_name"])){

                    #move_uploaded_file($_FILES["photo"]["tmp_name"], "img/miniImg/".$_FILES["photo"]["name"]);
                #}

            }

            $this->view->form = $addArticleForm;

        } else if ($response == 'movie') {

            $this->view->movie = $addMovieForm;
        }

    }

    public function editAction()
    {

        $article = new Application_Model_DbTable_Articles();
        $editComments = new Application_Model_DbTable_Comments();
        $form = new Application_Form_Articles();

        if ($this->getRequest()->isXmlHttpRequest()){  // ЧИ ЦЕ Є AJAX

            if ($this->getRequest()->getParam('delId')) {

                $commentDel = new Application_Model_DbTable_Comments(); //виклик об'єкта класа
                $commentDel -> deleteComment($this->getRequest()->getParam('delId')); // виклик метода DELETE
                $this->view->id = $this->getRequest()->getParam('delId'); //вивід респонза з jquery, тобто в даному видадку це ксс
            }

        }else{

            #$article->getItem($id); ті методи доступні для всіх класів які його наслідуют, як бачиш
            #ше один з величезних плюсыв ооп



            if ($this->getRequest()->isPost()) {

                $editDate = $this->getRequest()->getPost(); #submit це значення лишне в масиві і не вийде з ним все зразу записати в бд тому його ансетим
                unset($editDate['submit']);

                #die('i kill u');
                $article ->editArticles($editDate);

            }

            #то шо я казав, не видно змін бо вивід форми до того як ти вставив значення
            $this->view->articles = $article->getArticlesById($this->getRequest()->getParam('id')); //бере параметр ІД з метода getArticlesById
            $this->view->form = $form->populate($article->getArticlesById($this->getRequest()->getParam('id'))); //заповняє форму тими значеннями по ІД з getArticlesById

            /////////////////// КОМЕНТАРІ!!!!!

            #$id = $this->getRequest()->getParam('id');

            #$this->view->sukaID = $id; //Вивід коментраів по ід

            #$this->view->articles = $article->getArticlesById($this->getRequest()->getParam('id'));


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











