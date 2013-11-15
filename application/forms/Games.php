<?php

class Application_Form_Games extends Zend_Form
{

    public function init()
    {
        $this->setEnctype(Zend_Form::ENCTYPE_MULTIPART);

        $id  = new Zend_Form_Element_Hidden('id');
        $id     ->setAttrib('class', 'gameId');

        $status = new Zend_Form_Element_Select('status');
        $status ->setLabel('Status')
            ->setRequired(true)
            ->addMultiOptions(array(
                0 => 'block',
                1 => 'open',
            ))
        ;

        $title = new Zend_Form_Element_Textarea('title');
        $title  ->setRequired(true)
                ->setLabel('Title')
                ->setAttrib('class', 'titleAdd wysiwyg markItUpEditor')
                ->addFilter('StringTrim')
        ;

        $system = new Zend_Form_Element_Textarea('system');
        $system ->setLabel('System Requirements')
                ->setAttrib('class', 'titleAdd wysiwyg markItUpEditor')
                ->addFilter('StringTrim')
        ;

        $desc = new Zend_Form_Element_Textarea('desc');
        $desc   ->setLabel('Description')
                ->setAttrib('class', 'titleAdd wysiwyg markItUpEditor')
                ->addFilter('StringTrim')
        ;

        $funny = new Zend_Form_Element_Textarea('funny');
        $funny  ->setLabel('Some thing interesting')
                ->setAttrib('class', 'titleAdd wysiwyg markItUpEditor')
                ->addFilter('StringTrim')
        ;

        $poster = new Zend_Form_Element_File('poster');
        $poster ->addFilter('StringTrim')
                ->setLabel('Upload Main Image')
                ->setAttrib('multiple','false')
                ->addValidator('Extension', false, 'jpg, png, gif, jpeg')
        ;

        $textImg = new Zend_Form_Element_File('text_img');
        $textImg    ->addFilter('StringTrim')
                    ->setLabel('Upload Text Image')
                    ->setAttrib('multiple','true')
                    ->addValidator('Extension', false, 'jpg, png, gif, jpeg')
                    ->setIsArray(true)
        ;

        $submit = new Zend_Form_Element_Submit('submit');
        $submit ->setLabel('Save change')
                ->setAttrib('class','btn btn-success edit_but')
        ;

        $this->addElements(array($id, $status, $title, $system, $desc, $funny, $poster, $textImg, $submit));
    }

}

