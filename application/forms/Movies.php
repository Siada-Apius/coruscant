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
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->setAttrib('class','titleEdit')
        ;

        $full  = new Zend_Form_Element_Textarea('full');
        $full   ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->setLabel('Text')
                ->setAttrib('class', 'text')
        ;

        $miniImg = new Zend_Form_Element_File('miniImg');
        $miniImg    ->addFilter('StripTags')
                    ->addFilter('StringTrim')
                    ->setLabel('Upload image')
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

