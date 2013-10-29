<?php

class Application_Form_Login extends Zend_Form
{
    public function init()
    {

        $this->setName('loginForm');
        $this->setAttrib('class', 'form-signin');
        #$this->setAction('/media/index');

        $login = new Zend_Form_Element_Text('username');
        $login  ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->setAttrib('id', 'username')
                ->setAttrib('placeholder', 'login')
                ->setAttrib('class', 'form-control')
        ;

        $password = new Zend_Form_Element_Password('password');
        $password   ->setRequired(true)
                    ->addFilter('StripTags')
                    ->addFilter('StringTrim')
                    ->addValidator('NotEmpty')
                    ->setAttrib('id', 'password')
                    ->setAttrib('placeholder', 'password')
                    ->setAttrib('class', 'form-control')
        ;

        $submit = new Zend_Form_Element_Submit('submit');
        $submit     ->setAttrib('id', 'sign')
                    ->setAttrib('class','btn btn-lg btn-primary btn-block')
        ;

        $this->addElements(array($login, $password, $submit));

    }

}

