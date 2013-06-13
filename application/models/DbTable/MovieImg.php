<?php

class Application_Model_DbTable_MovieImg extends Application_Model_DbTable_Abstract
{

    protected $_name = 'movieimg';


    public function getItemsWhere($id) {

        /**
         * method getItemsWhere
         *
         * return all field where movie_id == $id
         */

        $data = $this   ->select()
                        ->from($this->_name)
                        ->where('movie_id = ?', $id)
        ;

        return $data->query()->fetchAll();
    }


    public function addNewPic($data) {

        /**
         * method addNewPic
         *
         * method only add new pictures
         */

        foreach ($data['addImg'] as $value) {

            $array = array(

                'movie_id' => $data['id'],
                'addImg' => $value,

            );

            $this->insert($array);

        }

    }

}

