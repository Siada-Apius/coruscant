<?php

class My_View_Helper_Url extends Zend_View_Helper_Abstract{

    public function url(){

        $url = 'http://' . $_SERVER['SERVER_NAME'];

        return $url;

    }

}

?>