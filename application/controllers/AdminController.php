<?php

class AdminController extends Zend_Controller_Action
{

    public function init()
    {
        $this   ->_helper->AjaxContext()
                ->addActionContext('index','json')
                ->addActionContext('movie','json')
                ->addActionContext('games','json')
                ->addActionContext('edit','json')
                ->initContext('json')
        ;
    }

    public function indexAction()
    {
        $articleDb  = new Application_Model_DbTable_Articles();
        $dwarf      = new Application_Model_Dwarf();

        if ($this->getRequest()->isXmlHttpRequest()){

            if ($this->getRequest()->getParam('param') == 'article'){

                $articleDb->deleteItem($this->getRequest()->getParam('delete_id'));

                $dir = '../www/img/article/' . $this->getRequest()->getParam('delete_id') . '/';
                $dwarf->rrmdir($dir);

            }

        }

        $page = (Zend_Controller_Front::getInstance()->getRequest()->getParam('page')) ? Zend_Controller_Front::getInstance()->getRequest()->getParam('page') : '1';
        $from = ($page - 1) * 5;

        $this->view->articles = $articleDb->getArticlesAdmin($from);
        $this->view->path = 'http://' . $_SERVER['SERVER_NAME'] . '/admin';

    }

    public function movieAction()
    {
        $movieDb    = new Application_Model_DbTable_Movies();
        $dwarf      = new Application_Model_Dwarf();

        if ($this->getRequest()->isXmlHttpRequest()){

            if ($this->getRequest()->getParam('param') == 'movie'){

                $movieDb->deleteItem($this->getRequest()->getParam('delete_id'));

                $dir = '../www/img/movie/' . $this->getRequest()->getParam('delete_id') . '/';
                $dwarf->rrmdir($dir);

            }

        } else {

            $this->view->movie = $movieDb->getItemsList();

        }

    }

    public function gamesAction()
    {
        $gamesDb    = new Application_Model_DbTable_Games();
        $dwarf      = new Application_Model_Dwarf();

        if ($this->getRequest()->isXmlHttpRequest()){

            if ($this->getRequest()->getParam('param') == 'games'){

                $gamesDb->deleteItem($this->getRequest()->getParam('delete_id'));

                $dir = '../www/img/games/' . $this->getRequest()->getParam('delete_id') . '/';
                $dwarf->rrmdir($dir);

            }

        } else {

            $this->view->games = $gamesDb->getItemsList();

       }

    }

    public function userAction()
    {
        // action body
    }

    public function addAction()
    {
        $articleForm    = new Application_Form_Articles();
        $movieForm      = new Application_Form_Movies();
        $gameForm       = new Application_Form_Games();

        $articleDb      = new Application_Model_DbTable_Articles();
        $movieDb        = new Application_Model_DbTable_Movies();
        $movieImgDb     = new Application_Model_DbTable_MovieImg();
        $gameDb         = new Application_Model_DbTable_Games();
        $gameImgDb      = new Application_Model_DbTable_GamesImg();

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


                    if ($elem1 = $articleForm->getElement('imgInText')){

                        $fileInfo1 = $elem1->getFileInfo();

                        foreach ($fileInfo1 as $key => $value){

                            $elem1->setDestination($imageDir);
                            $elem1->receive();

                        }

                    }

                    $this->redirect('/admin');

                }

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

                            $movieImgDb->addMoviePic($value['name'], $last_id, 'slider');

                            $elem1->setDestination($imageDir);
                            $elem1->receive();

                        }

                    }

                    if ($elem2 = $movieForm->getElement('ostImg')) {

                        $fileInfo2 = $elem2->getFileInfo();

                        foreach ($fileInfo2  as $key => $value){

                            $movieImgDb->addMoviePic($value['name'], $last_id, 'ost');

                            $elem2->setDestination($imageDir);
                            $elem2->receive();

                        }
                    }

                    if ($movieForm->getElement('textImg')){

                        $elem1 = $movieForm->getElement('textImg');
                        $fileInfo1 = $elem1->getFileInfo();

                        foreach ($fileInfo1 as $key => $value){

                            if ($value['name']){
                                $movieImgDb->addMoviePic($value['name'], $last_id, 'text');
                            }

                            $elem1->setDestination($imageDir);
                            $elem1->receive();

                        }

                    }

                    $this->redirect('/admin/movie');

                }

            }

            $this->view->movie = $movieForm;

        } else if ($response == 'games'){

            if ($this->getRequest()->isPost()){

                $gameData = $this->getRequest()->getPost();

                if ($gameForm->isValid($gameData)){

                    unset($gameData['MAX_FILE_SIZE']);
                    unset($gameData['submit']);

                    $elem = $gameForm->getElement('poster');
                    $fileInfo = $elem->getFileInfo();

                    $gameData['poster'] = $fileInfo['poster']['name'];

                    $last_id = $gameDb->createItem($gameData);

                    $basePath = '/img/games/' . $last_id . '/';
                    $folderModel->createFolderChain($basePath, '/');
                    $imageDir = realpath(APPLICATION_PATH . '/../www/') . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'games' . DIRECTORY_SEPARATOR . $last_id . DIRECTORY_SEPARATOR;

                    $elem->setDestination($imageDir);
                    $elem->receive();

                    if ($elem1 = $gameForm->getElement('text_img')){

                        $fileInfo1 = $elem1->getFileInfo();

                        foreach ($fileInfo1 as $value){

                            $gameImgDb->addGamePic($value['name'], $last_id, 'text');

                            $elem1->setDestination($imageDir);
                            $elem1->receive();

                        }

                    }

                    $this->redirect('/admin/games');

                }

            }

            $this->view->gameForm = $gameForm;

        }

    }

    public function editAction()
    {
        $articleDb      = new Application_Model_DbTable_Articles();
        $movieDb        = new Application_Model_DbTable_Movies();
        $movieImgDb     = new Application_Model_DbTable_MovieImg();
        $gameDb         = new Application_Model_DbTable_Games();
        $gameImgDb      = new Application_Model_DbTable_GamesImg();

        $movieForm      = new Application_Form_Movies();
        $articleForm    = new Application_Form_Articles();
        $gameForm       = new Application_Form_Games();

        $folderModel    = new Application_Model_Folder();
        $dwarf          = new Application_Model_Dwarf(); //delete folder
        $image          = new Application_Model_Images();

        if ($this->getRequest()->isXmlHttpRequest()){

            if ($this->getRequest()->getParam('param') == 'article'){

                $needDir = '../www/img/article/' . $this->getRequest()->getParam('id') . '/';
                $dwarf->deleteFile($needDir, $this->getRequest()->getParam('name'));

            }
//
//            if ($this->getRequest()->getParam('moviePicValue')){
//
//                $moviePicValue = $this->getRequest()->getParam('moviePicValue');
//                $moviePicName = $movieImgDb->getItem($moviePicValue);
//
//                $needDir = '../www/img/movie/' . $moviePicName['movie_id'] . '/';
//
//                $dwarf->deleteFile($needDir, $moviePicName['addImg']);
//                $movieImgDb->deleteItem($moviePicValue);
//
//            }

        } else {

            $response = $this->getRequest()->getParam('name');

            if ($response == 'article') {

                if ($this->getRequest()->isPost()) {

                    $editData = $this->getRequest()->getPost();

                    if (is_uploaded_file($_FILES['miniImg']['tmp_name']))

                    $editData['miniImg'] = $_FILES['miniImg']['name'];
                    unset($editData['submit']);
                    unset($editData['MAX_FILE_SIZE']);

                    $articleDb->editArticles($editData);

                    if ($_FILES['miniImg']['name']){
                        move_uploaded_file($_FILES['miniImg']['tmp_name'], './img/article/' . $editData['id'] . '/' . $_FILES['miniImg']['name']);
                        $image->resize('./img/article/' . $editData['id'] . '/' . $_FILES['miniImg']['name'], 223, 5000000, $_FILES['miniImg']['name'], './img/article/' . $editData['id'] . '/');
                    }

                    /*upload for img in text*/
                    $imageDir = realpath(APPLICATION_PATH . '/../www/') . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'article' . DIRECTORY_SEPARATOR . $editData['id'] . DIRECTORY_SEPARATOR;
                    if ($elem = $articleForm->getElement('imgInText')){

                        $fileInfo = $elem->getFileInfo();

                        foreach ($fileInfo as $value){

                            $elem->setDestination($imageDir);
                            $elem->receive();
                            $image->resize('./img/article/' . $editData['id'] . '/' . $value['name'], 644, 5000000, $value['name'], './img/article/' . $editData['id'] . '/');

                        }

                    }

                }

                $res = $articleDb->getItem($this->getRequest()->getParam('id'));
                $this->view->articles = $res;
                $this->view->form = $articleForm->populate($res);



            } else if ($response == 'movie'){

                if ($this->getRequest()->isPost()){

                    $editData = $this->getRequest()->getPost();

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

                    if ($movieForm->getElement('addImg')){

                        $elem1 = $movieForm->getElement('addImg');
                        $fileInfo1 = $elem1->getFileInfo();

                        foreach ($fileInfo1 as $value){

                            if ($value['name']) {
                                $movieImgDb->addMoviePic($value['name'], $editData['id'], 'slider');
                            }

                            $elem1->setDestination($imageDir);
                            $elem1->receive();

                        }

                    }

                    if ($movieForm->getElement('ostImg')) {

                        $elem2 = $movieForm->getElement('ostImg');
                        $fileInfo2 = $elem2->getFileInfo();

                        foreach ($fileInfo2  as $value){

                            if ($value['name']){
                                $movieImgDb->addMoviePic($value['name'], $editData['id'], 'ost');
                            }

                            $elem2->setDestination($imageDir);
                            $elem2->receive();

                        }
                    }

                    if ($movieForm->getElement('textImg')){

                        $elem1 = $movieForm->getElement('textImg');
                        $fileInfo1 = $elem1->getFileInfo();

                        foreach ($fileInfo1 as $value){

                            if ($value['name']){
                                $movieImgDb->addMoviePic($value['name'], $editData['id'], 'text');
                            }

                            $elem1->setDestination($imageDir);
                            $elem1->receive();

                        }

                    }

                }

                $id = $this->getRequest()->getParam('id');

                //populate form
                $movie = $movieDb->getItem($id);
                $this->view->formMovie = $movieForm->populate($movie);
                $this->view->movie = $movie;

                //view poster img
                $type = array('slider', 'ost', 'text');
                $movieImg = $movieImgDb->getItemsWhere($id, $type);
                $this->view->movieImg = $movieImg;

            } else if ($response = 'games'){

                if ($this->getRequest()->isPost()){

                    $gameData = $this->getRequest()->getPost();

                    if ($gameForm->isValid($gameData)){

                        unset($gameData['MAX_FILE_SIZE']);
                        unset($gameData['submit']);

                        $elem = $gameForm->getElement('poster');
                        $fileInfo = $elem->getFileInfo();

                        $gameData['poster'] = $fileInfo['poster']['name'];

                        $gameDb->editGame($gameData);

                        $basePath = '/img/games/' . $gameData['id'] . '/';
                        $folderModel->createFolderChain($basePath, '/');
                        $imageDir = realpath(APPLICATION_PATH . '/../www/') . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'games' . DIRECTORY_SEPARATOR . $gameData['id'] . DIRECTORY_SEPARATOR;

                        $elem->setDestination($imageDir);
                        $elem->receive();

                        if ($elem1 = $gameForm->getElement('text_img')){

                            $fileInfo1 = $elem1->getFileInfo();

                            foreach ($fileInfo1 as $value){

                                $gameImgDb->addGamePic($value['name'], $gameData['id'], 'text');

                                $elem1->setDestination($imageDir);
                                $elem1->receive();

                            }

                        }

                        $this->redirect('/admin/games');

                    }

                }

                $data = $gameDb->getItem($this->getRequest()->getParam('id'));
                $this->view->gameForm = $gameForm->populate($data);
            }

        }

    }

    public function commentsAction()
    {
        $articleDb  = new Application_Model_DbTable_Articles();
        $movieDb    = new Application_Model_DbTable_Movies();
        $gameDb     = new Application_Model_DbTable_Games();
        $com        = new Application_Model_DbTable_Comments();

        $this->view->articles = $articleDb->getItemsList();
        $this->view->movies = $movieDb->getItemsList();
        $this->view->games = $gameDb->getItemsList();
        $this->view->comments = $com->getItemsList();

    }

}













