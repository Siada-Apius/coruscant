<?php

class Application_Form_Registration extends Zend_Form
{

    public function init()
    {
        $this->setName('regForm');

        //ИНИЦИАЛИЗИРУЕМ ФОРМУ
        //$this->setMethod('post');

        $name  = new Zend_Form_Element_Text('nickname');
        $name   ->setRequired(true)                                             // Поле обязательное
                ->addValidator('NotEmpty', true)                                //Поле не должно быть пустым
                #->addValidator('Alpha', true)                                   //Возвращаут false, если аргумент содержит символы, от алфавитных
                ->addFilter('StripTags')                                        //Удаляет из аргумента HTML и PHP код
                //->addFilter('HtmlEntities')                                     //Преобразует специальные символы в аргументе в соответствующие HTML сущности
                ->addFilter('StringTrim')                                       //Удаляет из аргумента ведущие и концевый пробелы
                ->setErrorMessages(array('Enter your Nickname'))                //Устанавливает сообщение об ошибке
                ->setAttrib('id', 'nickname')                                  //Устанавливает атребут
                ->setAttrib('placeholder', 'nickname')                          //Устанавливает атребут
        ;

        $email = new Zend_Form_Element_Text('email');
        $email  ->setRequired(true)
                ->addValidator('NotEmpty', true)
                ->addValidator('EmailAddress')
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->setErrorMessages(array('Enter true e-mail'))
                ->setAttrib('id', 'email')
                ->setAttrib('placeholder', 'e-mail')
        ;

        $password = new Zend_Form_Element_Password('password');
        $password   ->setRequired(true)
                    ->addValidator('NotEmpty', true)
                    ->addFilter('StripTags')
                    ->addFilter('StringTrim')
                    ->setErrorMessages(array('Dont be a fool'))
                    ->setAttrib('id','password')
                    ->setAttrib('placeholder', 'password')
        ;

        $submit = new Zend_Form_Element_Submit('Submit');
        $submit     ->setLabel('Submit')
                    ->setAttrib('id','reg')
                    ->setOptions(array('class' => 'btn btn-success'))
        ;

        //ДОБАВЛЯЕМ К ФОРМЕ ЭЛЕМЕНТЫ
        /*$this   ->addElement($name)
                ->addElement($email)
               ->addElement($password)
              ->addElement($submit)
        ;*/

        $this->addElements(array($name, $email, $password, $submit));

    }

}



