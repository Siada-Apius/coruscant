<?php

class Application_Form_Articles extends Zend_Form
{

    public function init()
    {
        #тут вже собі виставиш типи полів і атрибути

        $this->setEnctype(Zend_Form::ENCTYPE_MULTIPART);

        $this->setName('addForm');

        $id  = new Zend_Form_Element_Hidden('id');

        $title  = new Zend_Form_Element_Textarea('title');
        $title  ->setLabel('Title')
                ->setRequired(true)                                             // Поле обязательное
                ->addFilter('StringTrim')                                       //Удаляет из аргумента ведущие и концевый пробелы
                ->setAttrib('id', 'titleAdd')                                      //Устанавливает атребут
                ->setAttrib('class', 'titleAdd')
        ;

        $short  = new Zend_Form_Element_Textarea('shortDesc');
        $short  ->setRequired(true)
                ->setLabel('Short Description')
                ->setAttrib('class', 'shortDescAdd')
                ->setAttrib('id', 'shortDescAdd')
        ;

        $full = new Zend_Form_Element_Textarea('full');
        $full   ->setRequired(true)
                ->setLabel('Text')
                ->addFilter('StringTrim')
                ->setAttrib('id','fullAdd')
                ->setAttrib('class', 'fullAdd')
        ;

        $author = new Zend_Form_Element_Text('author');
        $author     ->setRequired(true)
                    ->setLabel('Author')
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
                    ->setDestination('./img/miniImg/')
        ;





        $submit = new Zend_Form_Element_Submit('submit');
        $submit     ->setAttrib('id', 'edit')
                    ->setLabel('Save change')
                    ->setAttrib('class','btn btn-success edit_but')
        ;


        $this->addElements(array($id, $title, $short, $full, $author, $update, $miniImg, $submit));



    }


}

