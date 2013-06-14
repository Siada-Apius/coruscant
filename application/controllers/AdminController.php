<?php

class AdminController extends Zend_Controller_Action
{

    public function init()
    {
        $this   ->_helper->AjaxContext()
                ->addActionContext('index','json')
                ->addActionContext('edit','json')
                ->initContext('json')
        ;
    }

    public function indexAction()
    {
        $article = new Application_Model_DbTable_Articles();

        if ($this->getRequest()->isXmlHttpRequest()){

            if ($this->getRequest()->getParam('delId')) {

                $article->deleteItem($this->getRequest()->getParam('delId'));
                $this->view->id = $this->getRequest()->getParam('delId');

            }
        }

        $this->view->articles = $article->getArticles();

    }

    public function movieAction()
    {
        $movieDb = new Application_Model_DbTable_Movies();

        $this->view->movie = $movieDb->getItemsList();

    }


    public function gamesAction()
    {
        $gamesDb = new Application_Model_DbTable_Games();

        $this->view->games = $gamesDb->getItemsList();

    }


    public function userAction()
    {
        // action body
    }

    public function addAction()
    {
        $articleForm    = new Application_Form_Articles();
        $movieForm      = new Application_Form_Movies();

        $articleDb      = new Application_Model_DbTable_Articles();
        $movieDb        = new Application_Model_DbTable_Movies();
        $movieImgDb     = new Application_Model_DbTable_MovieImg();
        $movieImgOstDb  = new Application_Model_DbTable_MovieImgOst();

        $folderModel    = new Application_Model_Folder();

        $response = $this->getRequest()->getParam('name');

        if ($response == 'article') {

            if ($this->getRequest()->isPost()){

                $data = $this->getRequest()->getPost();

                if ($articleForm->isValid($data)){

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

        } else if ($response == 'movie'){

            if($this->getRequest()->isPost()){

                $db = 'articles';
                $data = $this->getRequest()->getPost();

                if ($movieForm->isValid($data)){

                    unset($data['submit']);
                    unset($data['MAX_FILE_SIZE']);




                    if ($elem = $movieForm->getElement('miniImg'))

                    $fileInfo = $elem->getFileInfo();
                    $data['miniImg'] = $fileInfo['miniImg']['name'];
                    $last_id =  $movieDb->addMovie($data);

                    $basePath = '/img/movie/' . $last_id . '/';
                    $folderModel->createFolderChain($basePath, '/');
                    $imageDir = realpath(APPLICATION_PATH . '/../www/') . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'movie' . DIRECTORY_SEPARATOR . $last_id . DIRECTORY_SEPARATOR;

                    $elem->setDestination($imageDir);
                    $elem->receive();

                    if ($elem1 = $movieForm->getElement('addImg')){

                        $fileInfo1 = $elem1->getFileInfo();

                        foreach ($fileInfo1 as $key => $value){

                            $movieImgDb->addMore($value['name'], $last_id);

                            $elem1->setDestination($imageDir);
                            $elem1->receive();

                        }

                    }

                    if ($elem2 = $movieForm->getElement('ostImg')) {

                        $fileInfo2 = $elem2->getFileInfo();

                        foreach ($fileInfo2  as $key => $value){

                            $movieImgOstDb->addOstPic($value['name'], $last_id);

                            $elem2->setDestination($imageDir);
                            $elem2->receive();

                        }
                    }

                    $this->redirect('/admin/movie');

                }

            }

            $this->view->movie = $movieForm;

        } else if ($response == 'games'){

            echo 'games add';

        }

    }

    public function editAction()
    {
        $commentDel     = new Application_Model_DbTable_Comments();
        $articleDb      = new Application_Model_DbTable_Articles();
        $movieDb        = new Application_Model_DbTable_Movies();
        $movieImgDb     = new Application_Model_DbTable_MovieImg();
        $movieImgOstDb  = new Application_Model_DbTable_MovieImgOst();

        $movieForm      = new Application_Form_Movies();
        $articleForm    = new Application_Form_Articles();

        $folderModel    = new Application_Model_Folder();

        if ($this->getRequest()->isXmlHttpRequest()){

            if ($this->getRequest()->getParam('delId')){

                $commentDel -> deleteItem($this->getRequest()->getParam('delId'));
                $this->view->id = $this->getRequest()->getParam('delId');

            }

        } else {

            $response = $this->getRequest()->getParam('name');

            if ($response == 'article') {

                if ($this->getRequest()->isPost()) {

                    $editData = $this->getRequest()->getPost();

                    $elem = $articleForm->getElement('miniImg');
                    $fileInfo = $elem->getFileInfo();

                    $editData['miniImg'] = $fileInfo['miniImg']['name'];

                    unset($editData['submit']);
                    unset($editData['MAX_FILE_SIZE']);

                    $articleDb ->editArticles($editData);

                    $basePath = '/img/article/' . $editData['id'] . '/';
                    $folderModel->createFolderChain($basePath, '/');
                    $imageDir = realpath(APPLICATION_PATH . '/../www/') . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'article' . DIRECTORY_SEPARATOR . $editData['id'] . DIRECTORY_SEPARATOR;

                    $elem->setDestination($imageDir);
                    $elem->receive();

                }

                $res = $articleDb->getItem($this->getRequest()->getParam('id'));
                $this->view->articles = $res;
                $this->view->form = $articleForm->populate($res);

                /////////////////// КОМЕНТАРІ!!!!!

                #$id = $this->getRequest()->getParam('id');

                #$this->view->sukaID = $id; //Вивід коментраів по ід

                #$this->view->articles = $article->getArticlesById($this->getRequest()->getParam('id'));

            } else if ($response == 'movie'){

                if ($this->getRequest()->isPost()){

                    $editData = $this->getRequest()->getPost();

                    unset($editData['submit']);
                    unset($editData['MAX_FILE_SIZE']);

                    $elem = $movieForm->getElement('miniImg');

                    $fileInfo = $elem->getFileInfo();

                    $editData['miniImg'] = $fileInfo['miniImg']['name'];
                    $editData['addImg'] = $_FILES['addImg']['name'];
                    Zend_Debug::dump($editData);die;
                    $movieDb->editMovie($editData);
                    $movieImgDb->addNewPic($editData);

                    $fname = array();
                    $ftmp = array();

                    foreach ($_FILES['addImg'] as $k => $v){

                        if ($k == 'name')$fname = $v;
                        if ($k == 'tmp_name')$ftmp = $v;

                    }

                    for ($i = 0;$i <= count($fname);$i++){

                        move_uploaded_file($ftmp[$i], 'img/movie/' . $editData['id'] . '/' . $fname[$i]);

                    }

                    $basePath = '/img/movie/' . $editData['id'] . '/';
                    $folderModel->createFolderChain($basePath, '/');
                    $imageDir = realpath(APPLICATION_PATH . '/../www/') . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'movie' . DIRECTORY_SEPARATOR . $editData['id'] . DIRECTORY_SEPARATOR;

                    $elem->setDestination($imageDir);
                    $elem->receive();

                }

                $id = $this->getRequest()->getParam('id');

                //populate form
                $movie = $movieDb->getItem($id);
                $this->view->formMovie = $movieForm->populate($movie);
                $this->view->movie = $movie;

                //view poster img
                $movieImg = $movieImgDb->getItemsWhere($id);
                $this->view->movieImg = $movieImg;

                //view OST img
                $movieImgOst = $movieImgOstDb->getItemsWhere($id);
                $this->view->movieImgOst = $movieImgOst;

            } else if ($response = 'games'){

                echo 'games edit';

            }

        }

    }


    public function commentsAction()
    {
        $wwc = new Application_Model_DbTable_Articles();
        $com = new Application_Model_DbTable_Comments();

        $this->view->articles = $wwc->workWithComments();
        $this->view->comments = $com->getItemsList();

    }

}













