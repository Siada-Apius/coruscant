<?php

class AdminController extends Zend_Controller_Action
{

    public function init()
    {
        /* $user = new Application_Model_DbTable_Magazine();
         $this->view->magazine = $user->getUsers();*/

        $this   ->_helper->AjaxContext()
                ->addActionContext('index','json')
                ->addActionContext('edit','json')
                ->initContext('json');
    }

    public function indexAction()
    {

        $article = new Application_Model_DbTable_Articles();

        if ($this->getRequest()->isXmlHttpRequest()){  // ЧИ ЦЕ Є AJAX

            if ($this->getRequest()->getParam('delId')) {

                $article -> deleteArticle($this->getRequest()->getParam('delId')); // виклик метода DELETE
                $this->view->id = $this->getRequest()->getParam('delId'); //вивід респонза з jquery, тобто в даному видадку це ксс
            }
        }

        $this->view->articles = $article->getArticles();

    }

    public function mediaAction(){

        $movieDb = new Application_Model_DbTable_Movies();

        $response = $movieDb->getAllMovie();
        $this->view->receive = $response;

    }

    public function userAction()
    {
        // action body
    }

    public function addAction()
    {
        $addArticleForm = new Application_Form_Articles();
        $addMovieForm = new Application_Form_Movies();
        $articleDb = new Application_Model_DbTable_Articles();
        $movieDb = new Application_Model_DbTable_Movies();
        $folderModel = new Application_Model_Folder();

        $response = $this->getRequest()->getParam('name');

        if ($response == 'article') {

            if( $this->getRequest()->isPost() ) {

                $params = $this->getRequest()->getPost();


                if ( $addArticleForm->isValid($params) ) {

                    $elem = $addArticleForm->getElement('miniImg');
                    $fileInfo = $elem->getFileInfo();
                    $params['miniImg'] = $fileInfo['miniImg']['name'];
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

            if( $this->getRequest()->isPost() ) {

                $data = $this->getRequest()->getPost();

                if ( $addMovieForm->isValid($data) ) {

                    unset($data['submit']);
                    unset($data['MAX_FILE_SIZE']);

                    $last_id = $movieDb->addMovie($data);

                    $elem = $addArticleForm->getElement('miniImg');
                    #$fileInfo = $elem->getFileInfo();
                    $basePath = '/img/movie/' . $last_id . '/miniImg/';
                    $folderModel->createFolderChain($basePath, '/');
                    $imageDir = realpath(APPLICATION_PATH . '/../www/') . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'movie' . DIRECTORY_SEPARATOR . $last_id . DIRECTORY_SEPARATOR . 'miniImg/';

                    $elem->setDestination($imageDir);
                    $elem->receive();

                    $this->redirect('/admin/media');
                }

            }

            $this->view->movie = $addMovieForm;
        }
    }


    public function editAction()
    {

        $article = new Application_Model_DbTable_Articles();
        $editComments = new Application_Model_DbTable_Comments();
        $commentDel = new Application_Model_DbTable_Comments(); //виклик об'єкта класа
        $addMovieForm = new Application_Form_Movies();
        $addArticleForm = new Application_Form_Articles();
        $folderModel = new Application_Model_Folder();

        if ($this->getRequest()->isXmlHttpRequest()){  // ЧИ ЦЕ Є AJAX

            if ($this->getRequest()->getParam('delId')) {

                $commentDel -> deleteComment($this->getRequest()->getParam('delId')); // виклик метода DELETE
                $this->view->id = $this->getRequest()->getParam('delId'); //вивід респонза з jquery, тобто в даному видадку це ксс
            }

        }else{

            #$article->getItem($id); ті методи доступні для всіх класів які його наслідуют, як бачиш
            #ше один з величезних плюсыв ооп



            if ($this->getRequest()->isPost()) {

                $editDate = $this->getRequest()->getPost(); #submit це значення лишне в масиві і не вийде з ним все зразу записати в бд тому його ансетим

                $elem = $addMovieForm->getElement('miniImg');
                $fileInfo = $elem->getFileInfo();
                $editDate['miniImg'] = $fileInfo['miniImg']['name'];
                $elem->receive();

                unset($editDate['submit']);
                unset($editDate['MAX_FILE_SIZE']);

                $article ->editArticles($editDate);

            }

            #то шо я казав, не видно змін бо вивід форми до того як ти вставив значення
            $this->view->articles = $article->getArticlesById($this->getRequest()->getParam('id')); //бере параметр ІД з метода getArticlesById
            $this->view->form = $addArticleForm->populate($article->getArticlesById($this->getRequest()->getParam('id'))); //заповняє форму тими значеннями по ІД з getArticlesById

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











