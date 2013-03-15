<?php

class Application_Form_Comment extends Zend_Form
{

    public function init()
    {

        $this->setName('addCom');

        $user_name_add = new Zend_Form_Element_Text('user_name_add');
        $user_name_add  -> setRequired(true)
                        -> addFilter('StringTrim')
                        -> addFilter('StripTags')
                        -> addValidator('NotEmpty')
                        -> setAttrib('id', 'user_name')
                        -> setAttrib('class', 'user_name_add')
                        -> setAttrib('placeholder', 'Your name')
                        -> setErrorMessages(array('Empty? Why?'))
        ;


        $com_text_add = new Zend_Form_Element_Textarea('com_text_add');
        $com_text_add   -> setRequired(true)
                        -> addFilter('StringTrim')
                        -> addFilter('StripTags')
                        -> addValidator('NotEmpty')
                        -> setAttrib('id', 'com_text')
                        -> setAttrib('class', 'com_text_add')
                        -> setErrorMessages(array('Empty? Why?'))
        ;

        $com_but = new Zend_Form_Element_Submit('Conviction');
        $com_but    -> setAttrib('id', 'com_but')
                    -> setAttrib('class', 'btn btn-success')
        ;

        $this->addElements(array($user_name_add, $com_text_add, $com_but));

    }


}

