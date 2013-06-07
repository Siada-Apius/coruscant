<?php

class Application_Form_Mail extends Zend_Form
{

    public function init()
    {
        $this->setName('mailForm');

        $mail_input = new Zend_Form_Element_Text('mail_input');
        $mail_input     ->setRequired(true)
                        ->setAttrib('placeholder', 'your email')
                        ->setAttrib('id', 'mail_input')
        ;

        $send = new Zend_Form_Element_Submit('send');
        $send   ->setAttrib('id', 'send')
                ->setAttrib('class','btn btn-success')
        ;

        $this->addElements(array($mail_input, $send));

    }

}

