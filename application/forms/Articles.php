<?php

class Application_Form_Articles extends Zend_Form
{

    public function init()
    {
        #тут вже собі виставиш типи полів і атрибути


        $id  = new Zend_Form_Element_Hidden('id');

        $title  = new Zend_Form_Element_Textarea('title');
        $title  ->setRequired(true)
                ->setLabel('Title')
                ->setAttrib('class','titleEdit')

        ;

        $short  = new Zend_Form_Element_Textarea('shortDesc');
        $short  ->setRequired(true)
                ->setLabel('Short Description')
                ->setAttrib('class', 'shortDesc')

        ;

        $full  = new Zend_Form_Element_Textarea('full');
        $full   ->setRequired(true)
                ->setLabel('Text')
                ->setAttrib('class', 'text')

        ;

        $author  = new Zend_Form_Element_Text('author');
        $author ->setRequired(true)
                ->setLabel('Author')
                ->setAttrib('class', 'inputEdit')

        ;

        $update  = new Zend_Form_Element_Hidden('updateDate');
        $update ->setRequired(true)
                ->setAttrib('class', 'inputEdit')
                ->setValue(date('Y-m-d H:i:s'))

        ;

        $submit = new Zend_Form_Element_Submit('submit');
        $submit     ->setAttrib('id', 'edit')
                    ->setLabel('Save change')
                    ->setAttrib('class','btn btn-success edit_but')
        ;


        $this->addElements(array($id, $title, $short, $full, $author, $update, $submit));



    }


}

