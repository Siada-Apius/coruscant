<?php

class UserController extends Zend_Controller_Action
{

    public function init()
    {
        #i kill you
        #$user = new Application_Model_DbTable_Magazine();
        #$this->view->magazine = $user->getUsers();

        //ZEND AJAX

        $this   ->_helper->AjaxContext()
                ->addActionContext('registration','json')
                ->initContext('json');
    }

    public function indexAction()
    {

    }

    public function loginAction()
    {
        #створємо і виводимо в view нашу форму авторизації
        $login = new Application_Form_Login();
        $this->view->form = $login;


        #якщо пройшов пост запит
        if ($this->getRequest()->isPost()) {

            $data = $this->getRequest()->getPost();
            #якщо дані пройшли умови вказані в формі
            if ($login->isValid($data)) {

                #отримуємо дані
                $username = $this->getRequest()->getPost('username');
                $password =  md5($this->getRequest()->getPost('password'));

                #ініціалізуємо адаптор
                $authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());

                #робимо порівняння отриманих через пост даних і значень таблиці
                $authAdapter    ->setTableName('users')
                                ->setIdentityColumn('nickname')
                                ->setCredentialColumn('password')
                                ->setIdentity($username)
                                ->setCredential($password);

                $auth = Zend_Auth::getInstance();
                $result = $auth->authenticate($authAdapter);

                #якщо логін і пароль співпадають робимо запис даних користувача в сесію
                if ($result->isValid()) {

                    $identity = $authAdapter->getResultRowObject();

                    $authStorage = $auth->getStorage();
                    $authStorage->write($identity);

                    #редірект на головну
                    if($identity->role == 'admin'){
                        $this->_helper->redirector('index', 'admin');
                    }
                    else{
                        $this->_helper->redirector('index', 'media');

                    }


                }
                else{
                    #редірект на сторінку з помилкою про невдалу авторизацію
                    #$this->_helper->redirector('login', 'user');
                    echo 'You are weak!';



                }

            }

        }


    }

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_helper->redirector('index', 'index');
    }

    public function registrationAction()
    {

        $form = new Application_Form_Registration();
        $user = new Application_Model_DbTable_Users();

        if ($this->getRequest()->isXmlHttpRequest()){
            #ІФ АЯКС !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

            $check = $user->checkByMail($this->getRequest()->getParam('email'));


            if($check['email']){
                #ІФ ІСНУЄ МЕЙЛ!!!!!!!!!!!!!!!!!!!!!!!
                $this->view->mail = 0;

            }else{
                #ІФ НЕ ІСНУЄ РУЄСТРУЄШ!!!!!!!!!!!!!!!!!!!!!!!

                $request = $this->getRequest()->getPost();
                if ($form->isValid($request)){


                    $user->createUser($request); //$date це масив, в який підставляється з Users.php дані форми
                    $this->view->status = 1;

                }else{

                    $this->view->errors = $form->getErrors();

                }



            }





        }else{
            #ФІ НЕ АКЯКАССССССССССССССССССССССССССССССССССССССССССССССССС!!!!!!!!!!!!!!!!!!!!!!!!
            $form = new Application_Form_Registration();

            if ($this->getRequest()->isPost()) {



                $data = $this->getRequest()->getPost();

                if ($form->isValid($data)){


                    $user->createUser($data); //$date це масив, в який підставляється з Users.php дані форми


                }


            }
            $this->view->form = $form;

        }


    }

    public function confirmAction()
    {
        // action body
    }



}







