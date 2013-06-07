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
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->setAttrib('class','titleEdit')
        ;

        $short = new Zend_Form_Element_Textarea('short');
        $short  ->setLabel('Short')
                ->addFilter('StringTrim')
        ;

        $actors = new Zend_Form_Element_Textarea('actors');
        $actors ->setLabel('actors')
                ->addFilter('StringTrim')
        ;

        $full  = new Zend_Form_Element_Textarea('full');
        $full   ->setRequired(true)
                ->addFilter('StringTrim')
                ->setLabel('Text')
                ->setAttrib('class', 'text')
        ;

        $funny = new Zend_Form_Element_Textarea('funny');
        $funny  ->setLabel('Funny')
                ->addFilter('StringTrim')
        ;

        $ost = new Zend_Form_Element_Textarea('ostList');
        $ost    ->setLabel('OST List')
                ->addFilter('StringTrim')
        ;

        $miniImg = new Zend_Form_Element_File('miniImg');
        $miniImg    ->addFilter('StringTrim')
                    ->setLabel('Upload Main Image')
                    ->setAttrib('multiple','false')
                    ->addValidator('Extension', false, 'jpg, png, gif, jpeg')
        ;

        $ostImg = new Zend_Form_Element_File('ostImg');
        $ostImg     ->addFilter('StringTrim')
                    ->setLabel('Upload OST image')
                    ->setAttrib('multiple','false')
                    ->addValidator('Extension', false, 'jpg, png, gif, jpeg')
        ;

        $submit = new Zend_Form_Element_Submit('submit');
        $submit     ->setAttrib('id', 'edit')
                    ->setLabel('Save change')
                    ->setAttrib('class','btn btn-success edit_but')
        ;

        $this->addElements(array($id, $title, $short, $actors, $full, $funny, $ost, $miniImg, $ostImg, $submit));

    }

}

