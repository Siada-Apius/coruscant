<?php

class Application_Model_Users{

    public function justSendSimpleEmil(){

        $mail = new Mail();  #виклик класу, в мене він знаходиться в ./library/My/Mail.php
        $mail->setRecipient('siadaapius@gmail.com');  #кому слати
        $mail->setTemplate(My_Mail::CONTACT); #шаблон, з допомогою якого надсилати лист
        $mail->name = 'user'; #змінна, яку передаєте в шаблон
        $mail->message = 'Hello world';  #повідомлення, яке передаєте в шаблон
        $mail->send(); #відправка

    }

}