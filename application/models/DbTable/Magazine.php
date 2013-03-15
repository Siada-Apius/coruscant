<?php

class Application_Model_DbTable_Magazine extends Application_Model_DbTable_Abstract
{
    protected $_name = 'users';

    public function getUsers(){

        $data = $this   ->select()
                        ->from('users',array('nickname','password'));


        return $data->query()->fetchAll();
    }

}
