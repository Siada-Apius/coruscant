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
        $articleDb  = new Application_Model_DbTable_Articles();
        $dwarf      = new Application_Model_Dwarf();

        if ($this->getRequest()->isXmlHttpRequest()){

            if ($this->getRequest()->getParam('delId')) {

                $articleDb->deleteItem($this->getRequest()->getParam('delId'));

                $dir = '../www/img/article/' . $this->getRequest()->getParam('delId') . '/';
                $dwarf->rrmdir($dir);

            }

        }

        $page = (Zend_Controller_Front::getInstance()->getRequest()->getParam('page')) ? Zend_Controller_Front::getInstance()->getRequest()->getParam('page') : '1';
        $from = ($page - 1) * 5;

        $this->view->articles = $articleDb->getArticles($from);
        $this->view->path = 'http://' . $_SERVER['SERVER_NAME'] . '/admin';

    }

    public function movieAction()
    {
        $movieDb    = new Application_Model_DbTable_Movies();
        $dwarf      = new Application_Model_Dwarf();

        if ($this->getRequest()->isXmlHttpRequest()){

            if ($this->getRequest()->getParam('movieId')) {

                $movieDb->deleteItem($this->getRequest()->getParam('movieId'));

                $dir = '../www/img/movie/' . $this->getRequest()->getParam('movieId') . '/';
                $dwarf->rrmdir($dir);

            }

        } else {

            $this->view->movie = $movieDb->getItemsList();

        }

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

        $folderModel    = new Application_Model_Folder();
        $editorArea = new My_Form_Element_WysibbEditor('content', 'Example Text Value' , array('label' => 'Feedback', 'class' => 'custom-texteditor' ));

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

            $this->view->wysiwyg = $editorArea;
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

            echo 'games add';

        }

    }

    public function editAction()
    {

        $articleDb      = new Application_Model_DbTable_Articles();
        $movieDb        = new Application_Model_DbTable_Movies();
        $movieImgDb     = new Application_Model_DbTable_MovieImg();

        $movieForm      = new Application_Form_Movies();
        $articleForm    = new Application_Form_Articles();

        $folderModel    = new Application_Model_Folder();
        $dwarf          = new Application_Model_Dwarf();




        if ($this->getRequest()->isXmlHttpRequest()){

            if ($this->getRequest()->getParam('articlePicName')){

                $articlePicName = $this->getRequest()->getParam('articlePicName');
                $articleId = $this->getRequest()->getParam('articleId');

                $needDir = '../www/img/article/' . $articleId . '/';

                $dwarf->deleteFile($needDir, $articlePicName);

            }

            if ($this->getRequest()->getParam('moviePicValue')){

                $moviePicValue = $this->getRequest()->getParam('moviePicValue');
                $moviePicName = $movieImgDb->getItem($moviePicValue);

                $needDir = '../www/img/movie/' . $moviePicName['movie_id'] . '/';

                $dwarf->deleteFile($needDir, $moviePicName['addImg']);
                $movieImgDb->deleteItem($moviePicValue);

            }

        } else {

            $response = $this->getRequest()->getParam('name');

            if ($response == 'article') {

                if ($this->getRequest()->isPost()) {

                    $editData = $this->getRequest()->getPost();

                    $elem = $articleForm->getElement('miniImg');
                    $fileInfo = $elem->getFileInfo();

                    $data['miniImg'] = $fileInfo['miniImg']['name'];

                    $articleDb->editArticles($editData);

                    $basePath = '/img/article/' . $editData['id'] . '/';
                    $folderModel->createFolderChain($basePath, '/');
                    $imageDir = realpath(APPLICATION_PATH . '/../www/') . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'article' . DIRECTORY_SEPARATOR . $editData['id'] . DIRECTORY_SEPARATOR;

                    $elem->setDestination($imageDir);
                    $elem->receive();


                    if ($elem1 = $articleForm->getElement('imgInText')){

                        $fileInfo1 = $elem1->getFileInfo();

                        foreach ($fileInfo1 as $key => $value){

                            $elem1->setDestination($imageDir);
                            $elem1->receive();

                        }

                    }

                }

                $res = $articleDb->getItem($this->getRequest()->getParam('id'));
                $this->view->articles = $res;
                $this->view->form = $articleForm->populate($res);

            }

            else if ($response == 'movie'){

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

                        foreach ($fileInfo1 as $key => $value){

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

                        foreach ($fileInfo2  as $key => $value){

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

                        foreach ($fileInfo1 as $key => $value){

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

                foreach ($movieImg as $value){
                    $result[] = $value;
                }
                $this->view->movieImg = $result;

            }

            else if ($response = 'games'){

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













