<?php

class Application_Form_Add extends Zend_Form
{

    public function init()
    {
        $this->setName('addForm');


        #$this->setAction('/index/index');
        //$this->setMethod('post');


        $title  = new Zend_Form_Element_Textarea('title');
        $title  ->setLabel('Title')
                ->setRequired(true)                                             // Поле обязательное
                ->addFilter('StringTrim')                                       //Удаляет из аргумента ведущие и концевый пробелы
                ->setAttrib('id', 'titleAdd')                                      //Устанавливает атребут
                ->setAttrib('class', 'titleAdd')
        ;


        $shortDesc = new Zend_Form_Element_Textarea('shortDesc');
        $shortDesc  ->setRequired(true)
                    ->setLabel('Short Description')
                    ->addFilter('StringTrim')
                    ->setAttrib('id', 'shortDescAdd')
                    ->setAttrib('class', 'shortDescAdd')
        ;

        //СОЗДАЕМ ТЕКСТОВОЕ ПОЛЕ ДЛЯ ВВОДА ПАРОЛЯ
        $full = new Zend_Form_Element_Textarea('full');
        $full   ->setRequired(true)
                ->setLabel('Text')
                ->addFilter('StringTrim')
                ->setAttrib('id','fullAdd')
                ->setAttrib('class', 'fullAdd')
        ;


        $author = new Zend_Form_Element_Text('author');
        $author   ->setRequired(true)
                  ->setLabel('Author')
                  ->addFilter('StringTrim')
                  ->setAttrib('id','authorAdd')
                  ->setAttrib('class', 'authorAdd')
        ;




    /*
        $element = new Zend_Form_Element_File('foo');
        $element->setLabel('Upload an image:')
            ->setDestination('/var/www/upload');
        // ensure only 1 file
        $element->addValidator('Count', false, 1);
        // limit to 100K
        $element->addValidator('Size', false, 102400);
        // only JPEG, PNG, and GIFs
        $element->addValidator('Extension', false, 'jpg,png,gif');

    */

        //СОЗДАЕМ КНОПКУ ДЛЯ ОТПРАВКИ
        $submit = new Zend_Form_Element_Submit('Submit');
        $submit     ->setLabel('Add')
                    ->setOptions(array('class' => 'btn btn-success'))
        ;


        $this->addElements(array($title, $shortDesc, $full, $author, $submit));
    }

}



