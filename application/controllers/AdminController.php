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
        $articleForm = new Application_Form_Articles();
        $movieForm = new Application_Form_Movies();
        $articleDb = new Application_Model_DbTable_Articles();
        $movieDb = new Application_Model_DbTable_Movies();
        $folderModel = new Application_Model_Folder();

        $response = $this->getRequest()->getParam('name');

        if ($response == 'article') {

            if( $this->getRequest()->isPost() ) {

                $data = $this->getRequest()->getPost();

                if ( $articleForm->isValid($data) ) {

                    $elem = $articleForm->getElement('miniImg');
                    $fileInfo = $elem->getFileInfo();
                    $data['miniImg'] = $fileInfo['miniImg']['name'];

                    $last_id = $articleDb->addArticles($data);

                    $basePath = '/img/article/' . $last_id . '/';
                    $folderModel->createFolderChain($basePath, '/');
                    $imageDir = realpath(APPLICATION_PATH . '/../www/') . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'article' . DIRECTORY_SEPARATOR . $last_id . DIRECTORY_SEPARATOR;

                    $elem->setDestination($imageDir);
                    $elem->receive();

                    $this->redirect('/admin');
                }

                #if(is_uploaded_file($_FILES["photo"]["tmp_name"])){

                    #move_uploaded_file($_FILES["photo"]["tmp_name"], "img/miniImg/".$_FILES["photo"]["name"]);
                #}

            }

            $this->view->form = $articleForm;

        } else if ($response == 'movie') {

            if( $this->getRequest()->isPost() ) {

                $data = $this->getRequest()->getPost();

                if ( $movieForm->isValid($data) ) {

                    unset($data['submit']);
                    unset($data['MAX_FILE_SIZE']);

                    $elem = $movieForm->getElement('miniImg');
                    $fileInfo = $elem->getFileInfo();
                    $data['miniImg'] = $fileInfo['miniImg']['name'];

                    $last_id = $movieDb->addMovie($data);

                    $basePath = '/img/movie/' . $last_id . '/';
                    $folderModel->createFolderChain($basePath, '/');
                    $imageDir = realpath(APPLICATION_PATH . '/../www/') . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'movie' . DIRECTORY_SEPARATOR . $last_id . DIRECTORY_SEPARATOR;

                    $elem->setDestination($imageDir);
                    $elem->receive();

                    $this->redirect('/admin/media');
                }

            }

            $this->view->movie = $movieForm;
        }
    }


    public function editAction()
    {
        $editComments = new Application_Model_DbTable_Comments();
        $commentDel = new Application_Model_DbTable_Comments(); //виклик об'єкта класа
        $articleDb = new Application_Model_DbTable_Articles();
        $movieDb = new Application_Model_DbTable_Movies();
        $movieForm = new Application_Form_Movies();
        $articleForm = new Application_Form_Articles();
        $folderModel = new Application_Model_Folder();

        if ($this->getRequest()->isXmlHttpRequest()){  // ЧИ ЦЕ Є AJAX

            if ($this->getRequest()->getParam('delId')) {

                $commentDel -> deleteComment($this->getRequest()->getParam('delId')); // виклик метода DELETE
                $this->view->id = $this->getRequest()->getParam('delId'); //вивід респонза з jquery, тобто в даному видадку це ксс
            }

        }else{

            #$article->getItem($id); ті методи доступні для всіх класів які його наслідуют, як бачиш
            #ше один з величезних плюсыв ооп
            $response = $this->getRequest()->getParam('name');
#Zend_Debug::dump($this->getRequest()->getParam('name'));die;
            if ($response == 'article') {

                if ($this->getRequest()->isPost()) {

                    $editData = $this->getRequest()->getPost(); #submit це значення лишне в масиві і не вийде з ним все зразу записати в бд тому його ансетим

                    $elem = $movieForm->getElement('miniImg');
                    $fileInfo = $elem->getFileInfo();
                    $editData['miniImg'] = $fileInfo['miniImg']['name'];


                    unset($editData['submit']);
                    unset($editData['MAX_FILE_SIZE']);
#Zend_Debug::dump($editDate);die;
                    $articleDb ->editArticles($editData);

                    $basePath = '/img/article/' . $editData['id'] . '/';
                    $folderModel->createFolderChain($basePath, '/');
                    $imageDir = realpath(APPLICATION_PATH . '/../www/') . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'article' . DIRECTORY_SEPARATOR . $editData['id'] . DIRECTORY_SEPARATOR;

                    $elem->setDestination($imageDir);
                    $elem->receive();

                }

                #то шо я казав, не видно змін бо вивід форми до того як ти вставив значення
                $res = $articleDb->getArticlesById($this->getRequest()->getParam('id'));
                $this->view->articles = $res; //бере параметр ІД з метода getArticlesById
                $this->view->form = $articleForm->populate($res); //заповняє форму тими значеннями по ІД з getArticlesById

                /////////////////// КОМЕНТАРІ!!!!!

                #$id = $this->getRequest()->getParam('id');

                #$this->view->sukaID = $id; //Вивід коментраів по ід

                #$this->view->articles = $article->getArticlesById($this->getRequest()->getParam('id'));


                //////////////////////////////////////
            } else if ($response == 'media') {

                if ($this->getRequest()->isPost()) {

                    $editData = $this->getRequest()->getPost(); #submit це значення лишне в масиві і не вийде з ним все зразу записати в бд тому його ансетим

                    unset($editData['submit']);
                    unset($editData['MAX_FILE_SIZE']);

                    $elem = $movieForm->getElement('miniImg');
                    $fileInfo = $elem->getFileInfo();
                    $editData['miniImg'] = $fileInfo['miniImg']['name'];

                    $movieDb->editMovie($editData);

                    $basePath = '/img/movie/' . $editData['id'] . '/';
                    $folderModel->createFolderChain($basePath, '/');
                    $imageDir = realpath(APPLICATION_PATH . '/../www/') . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'movie' . DIRECTORY_SEPARATOR . $editData['id'] . DIRECTORY_SEPARATOR;

                    $elem->setDestination($imageDir);
                    $elem->receive();

                }

                $receive = $movieDb->getMovieById($this->getRequest()->getParam('id'));

                $this->view->movie = $receive;
                $this->view->formMovie = $movieForm->populate($receive);

            }


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











