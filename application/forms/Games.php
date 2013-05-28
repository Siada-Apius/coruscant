<?php

class Application_Form_Games extends Zend_Form
{

    public function init()
    {
        $this->setEnctype(Zend_Form::ENCTYPE_MULTIPART);

        $title = new Zend_Form_Element_Text('title');
        $title  ->setRequired(true)
                ->setLabel('Title')
                ->setAttrib('class', 'titleEdit')
                ->addFilter('StringTrim')
        ;

        $short = new Zend_Form_Element_Text('short');

    }


}

