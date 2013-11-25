<?php

class Application_Form_Comment extends Zend_Form
{

    public function init()
    {

        $this->setName('addCom');

        $user_name = new Zend_Form_Element_Text('user_name');
        $user_name  ->setRequired(true)
                    ->addFilter('StringTrim')
                    ->addFilter('StripTags')
                    ->addValidator('NotEmpty')
                    ->setAttrib('id', 'user_name')
                    ->setAttrib('class', 'user_name_add')
                    ->setAttrib('placeholder', 'your name')
                    ->setErrorMessages(array('Empty? Why?'))
        ;

        $user_email = new Zend_Form_Element_Text('user_email');
        $user_email ->setRequired(true)
                    ->addValidator('NotEmpty', true)
                    ->addValidator('EmailAddress')
                    ->addFilter('StripTags')
                    ->addFilter('StringTrim')
                    ->setErrorMessages(array('Enter true e-mail'))
                    ->setAttrib('id', 'email')
                    ->setAttrib('placeholder', 'e-mail')
        ;

        $com_text = new Zend_Form_Element_Textarea('com_text');
        $com_text   ->setRequired(true)
                    ->addFilter('StringTrim')
                    ->addFilter('StripTags')
                    ->addValidator('NotEmpty')
                    ->setAttrib('id', 'com_text')
                    ->setAttrib('class', 'com_text_add')
                    ->setErrorMessages(array('Empty? Why?'))
        ;

        $com_but = new Zend_Form_Element_Submit('submit');
        $com_but    ->setAttrib('id', 'com_but')
                    ->setAttrib('class', 'btn btn-default')
        ;

        $this->addElements(array($user_name, $user_email, $com_text, $com_but));

    }

}

