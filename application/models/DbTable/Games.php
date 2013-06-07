<?php

class Application_Model_DbTable_Games extends Application_Model_DbTable_Abstract
{

    protected $_name = 'games';

    public function getGamesIn($in){

        /**
         * method getGamesIn
         *
         * return all fields where id == $in
         */

        $data = $this   ->select()
                        ->from($this->_name)
                        ->where('id IN (?)', $in)
        ;

        return $data->query()->fetchAll();

    }

}

