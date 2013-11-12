<?php

class Application_Form_Articles extends Zend_Form
{

    public function init()
    {
        $this->setEnctype(Zend_Form::ENCTYPE_MULTIPART);
        $this->setName('addForm');

        $id  = new Zend_Form_Element_Hidden('id');

        $title  = new Zend_Form_Element_Textarea('title');
        $title  ->setLabel('Title')
                ->setRequired(true)
                ->addFilter('StringTrim')
                ->setAttrib('id', 'titleAdd')
                ->setAttrib('class', 'titleAdd wysiwyg')
        ;

        $short  = new Zend_Form_Element_Textarea('shortDesc');
        $short  ->setRequired(true)
                ->setLabel('Short Description')
                ->setAttrib('class', 'shortDescAdd wysiwyg')
                ->setAttrib('id', 'shortDescAdd')
                ->addValidator('stringLength', false, array(3, 160))
                ->setAttrib('maxlength', 160)
        ;

        $full = new Zend_Form_Element_Textarea('full');
        $full   ->setRequired(true)
                ->setLabel('Text')
                ->addFilter('StringTrim')
                ->setAttrib('class', 'fullAdd wysiwyg')
        ;

        $author = new Zend_Form_Element_Text('author');
        $author     ->setLabel('Author')
                    ->addFilter('StringTrim')
                    ->setAttrib('id','authorAdd')
                    ->setAttrib('class', 'authorAdd inputEdit')
        ;

        $update = new Zend_Form_Element_Hidden('updateDate');
        $update ->setRequired(true)
                ->setAttrib('class', 'inputEdit')
                ->setValue(date('Y-m-d H:i:s'))

        ;

        $miniImg = new Zend_Form_Element_File('miniImg');
        $miniImg    ->setLabel('Upload image')
                    ->setAttrib('multiple','false')
                    ->addValidator('Extension', false, 'jpg, png, gif, jpeg')
        ;

        $imgInText = new Zend_Form_Element_File('imgInText');
        $imgInText  ->setLabel('Upload image for text')
                    ->setAttrib('multiple','true')
                    ->addValidator('Extension', false, 'jpg, png, gif, jpeg')
                    ->setIsArray(true)

        ;

        $submit = new Zend_Form_Element_Submit('submit');
        $submit     ->setAttrib('id', 'edit')
                    ->setLabel('Save change')
                    ->setAttrib('class','btn btn-info edit_but')
        ;

        $this->addElements(array($id, $title, $short, $full, $author, $update, $miniImg, $imgInText, $submit));

    }

}

