<?php

class Application_Form_Movies extends Zend_Form
{

    public function init()
    {
        $this->setEnctype(Zend_Form::ENCTYPE_MULTIPART);

        $id  = new Zend_Form_Element_Hidden('id');

        $title  = new Zend_Form_Element_Textarea('title');
        $title  ->setRequired(true)
                ->setLabel('Title')
                ->addValidator('NotEmpty')
                ->setAttrib('class','titleEdit')
        ;

        $full  = new Zend_Form_Element_Textarea('full');
        $full   ->setRequired(true)
                ->setLabel('Text')
                ->setAttrib('class', 'text')
        ;

        $miniImg = new Zend_Form_Element_File('miniImg');
        $miniImg    ->setLabel('Upload image')
                    ->setAttrib('multiple','false')
                    ->addValidator('Extension', false, 'jpg, png, gif, jpeg')
        ;

        $submit = new Zend_Form_Element_Submit('submit');
        $submit     ->setAttrib('id', 'edit')
                    ->setLabel('Save change')
                    ->setAttrib('class','btn btn-success edit_but')
        ;


        $this->addElements(array($id, $title, $full, $miniImg, $submit));
    }

}

