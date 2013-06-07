<?php

class Application_Model_DbTable_MovieImgOst extends Application_Model_DbTable_Abstract
{

    protected $_name = 'movieimgost';

    public function getItemsWhere($id) {

        /**
         * method getItemsWhere
         *
         * return fields where movie_id == $id
         */

        $data = $this   ->select()
                        ->from($this->_name)
                        ->where('movie_id = ?', $id)
        ;

        return $data->query()->fetchAll();
    }

}

