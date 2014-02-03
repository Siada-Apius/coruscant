<?php

class My_View_Helper_Url extends Zend_View_Helper_Abstract{

    public function url(){

        $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        return $url;

    }

}

?>