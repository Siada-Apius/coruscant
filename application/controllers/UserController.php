<?php

class UserController extends Zend_Controller_Action
{

    public function init()
    {

        $this   ->_helper->AjaxContext()
                ->addActionContext('registration','json')
                ->initContext('json')
        ;
    }

    public function indexAction()
    {

    }

    public function loginAction()
    {
        $login          = new Application_Form_Login();
        $authAdapter    = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());

        if ($this->getRequest()->isPost()) {

            $data = $this->getRequest()->getPost();

            if ($login->isValid($data)) {

                $username = $this->getRequest()->getPost('username');
                $password =  md5($this->getRequest()->getPost('password'));

                $authAdapter    ->setTableName('users')
                                ->setIdentityColumn('nickname')
                                ->setCredentialColumn('password')
                                ->setIdentity($username)
                                ->setCredential($password)
                ;

                $auth = Zend_Auth::getInstance();
                $result = $auth->authenticate($authAdapter);

                #якщо логін і пароль співпадають робимо запис даних користувача в сесію
                if ($result->isValid()){

                    $identity = $authAdapter->getResultRowObject();

                    $authStorage = $auth->getStorage();
                    $authStorage->write($identity);

                    #редірект на головну
                    if ($identity->role == 'admin'){
                        $this->_helper->redirector('index', 'admin');
                    } else{
                        $this->_helper->redirector('index', 'media');
                    }

                } else{

                    echo 'You are weak!';

                }
            }
        }

        $this->view->form = $login;
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

            $check = $user->checkByMail($this->getRequest()->getParam('email'));

            if ($check['email']){
                #ІФ ІСНУЄ МЕЙЛ!!!!!!!!!!!!!!!!!!!!!!!
                $this->view->mail = 0;

            } else {
                #ІФ НЕ ІСНУЄ РУЄСТРУЄШ!!!!!!!!!!!!!!!!!!!!!!!
                $request = $this->getRequest()->getPost();

                if ($form->isValid($request)){

                    $user->createUser($request);
                    $this->view->status = 1;

                } else {

                    $this->view->errors = $form->getErrors();

                }
            }

        } else {

            if ($this->getRequest()->isPost()) {

                $data = $this->getRequest()->getPost();

                if ($form->isValid($data)){

                    $user->createUser($data);

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







