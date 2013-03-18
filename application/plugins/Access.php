<?php

class Application_Plugin_Access extends Zend_Controller_Plugin_Abstract
{

    private $_acl = null;
    private $_auth = null;

    const ACCESS_DENIED = 401;
    /*
    *
    */

    public function __construct()
    {
        $this->_acl = $this->getRole();
        $this->_auth = Zend_Auth::getInstance();
    }

    protected function getRole()
    {
        $acl = new Zend_Acl();

        $acl->addRole('guest');
        $acl->addRole('user');
        $acl->addRole('admin');


        $acl->addResource('index');
        $acl->addResource('error');

        $acl->addResource('admin');
        $acl->addResource('account');
        $acl->addResource('user');
        $acl->addResource('media');
        $acl->addResource('news');
        $acl->addResource('games');
        $acl->addResource('archive');
        $acl->addResource('about');


        #admin allow
        $acl->allow('admin', 'error', array('index'));
        $acl->allow('admin', 'index', array('index'));
        $acl->allow('admin', 'user', array('index','logout'));
        $acl->allow('admin', 'media', array('index', 'article'));
        $acl->allow('admin', 'admin', array('index', 'media', 'user', 'add', 'edit', 'comments'));
        $acl->allow('admin', 'account', array('index'));
        $acl->allow('admin', 'error', array('error404','error'));


        #user allow
        $acl->allow('user', 'index', array('index'));
        $acl->allow('user', 'media', array('index', 'article', 'page'));
        $acl->allow('user', 'user', array('index','logout'));
        $acl->allow('user', 'error', array('error404','error'));


        #guest allow
        $acl->allow('guest', 'index', array('index', 'mail'));
        $acl->allow('guest', 'user', array('index', 'login', 'registration'));
        $acl->allow('guest', 'media', array('index', 'article', 'page'));
        $acl->allow('guest', 'news', array('index'));
        $acl->allow('guest', 'games', array('index'));
        $acl->allow('guest', 'archive', array('index'));
        $acl->allow('guest', 'about', array('index'));

        $acl->deny('guest', 'user', array('logout'));
        $acl->allow('guest', 'error', array('error404','error'));


        Zend_Registry::set('Zend_Acl',$acl);

        $identity = Zend_Auth::getInstance()->getStorage()->read();

        $role = !empty($identity->role) ? $identity->role : 'guest';
        Zend_Registry::set('currentRole',$role);

        //Zend_View_Helper_Navigation_HelperAbstract::setDefaultAcl($acl);

        return $acl;

    }

    public function preDispatch(Zend_Controller_Request_Abstract $request) {

        // get current controller
        $resource = $request->getControllerName();

        // get current action
        $action = $request->getActionName();

        // get role
        $identity = $this->_auth->getStorage()->read();

        $role = !empty($identity->role) ? $identity->role : 'guest';

        //Zend_View_Helper_Navigation::setRole($role);
        #echo 'Роль -> ' . $role .' | Ресурс -> '. $resource .' | Екшн-> '. $action . '<br>';
        if (!$this->_acl->isAllowed($role, $resource, $action)) {
            $request->setControllerName('error')->setActionName('page404');
            #throw new Zend_Acl_Exception("This page is not accessible.", Application_Plugin_Access::ACCESS_DENIED);
        }
    }
}