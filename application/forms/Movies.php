<?php

class Application_Form_Movies extends Zend_Form
{

    public function init()
    {
        $this->setEnctype(Zend_Form::ENCTYPE_MULTIPART);

        $id  = new Zend_Form_Element_Hidden('id');
        $id     ->setAttrib('class', 'movieId');

        $title  = new Zend_Form_Element_Textarea('title');
        $title  ->setLabel('Title')
                ->addFilter('StringTrim')
                ->setAttrib('class','titleAdd')
        ;

        $short = new Zend_Form_Element_Textarea('short');
        $short  ->setLabel('Short Description')
                ->addFilter('StringTrim')
                ->setAttrib('class', 'shortDescAdd')
        ;

        $actors = new Zend_Form_Element_Textarea('actors');
        $actors ->setLabel('Actors')
                ->addFilter('StringTrim')
                ->setAttrib('class', 'actorsAdd')
        ;

        $full  = new Zend_Form_Element_Textarea('full');
        $full   ->addFilter('StringTrim')
                ->setLabel('Text')
                ->setAttrib('class', 'text')
                ->setAttrib('class', 'fullAdd')
        ;

        $funny = new Zend_Form_Element_Textarea('funny');
        $funny  ->setLabel('Funny')
                ->addFilter('StringTrim')
                ->setAttrib('class', 'funnyAdd')
        ;

        $ost = new Zend_Form_Element_Textarea('ostList');
        $ost    ->setLabel('OST List')
                ->addFilter('StringTrim')
                ->setAttrib('class', 'ostListAdd')
        ;

        $miniImg = new Zend_Form_Element_File('miniImg');
        $miniImg    ->addFilter('StringTrim')
                    ->setLabel('Upload Main Image')
                    ->setAttrib('multiple','false')
                    ->addValidator('Extension', false, 'jpg, png, gif, jpeg')
        ;

        $textImg = new Zend_Form_Element_File('textImg');
        $textImg    ->addFilter('StringTrim')
                    ->setLabel('Upload Text Image')
                    ->setAttrib('multiple','true')
                    ->addValidator('Extension', false, 'jpg, png, gif, jpeg')
                    ->setIsArray(true)
        ;

        $addImg = new Zend_Form_Element_File('addImg');
        $addImg     ->addFilter('StringTrim')
                    ->setLabel('Upload Slide Image')
                    ->setAttrib('multiple','true')
                    ->addValidator('Extension', false, 'jpg, png, gif, jpeg')
                    ->setIsArray(true)
        ;

        $ostImg = new Zend_Form_Element_File('ostImg');
        $ostImg     ->addFilter('StringTrim')
                    ->setLabel('Upload OST Image')
                    ->setAttrib('multiple','true')
                    ->addValidator('Extension', false, 'jpg, png, gif, jpeg')
                    ->setIsArray(true)
        ;

        $submit = new Zend_Form_Element_Submit('submit');
        $submit     ->setAttrib('id', 'edit')
                    ->setLabel('Save change')
                    ->setAttrib('class','btn btn-success edit_but')
        ;

        $this->addElements(array($id, $title, $short, $actors, $full, $funny, $ost, $miniImg, $textImg, $addImg, $ostImg, $submit));

    }

}

