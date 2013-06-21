<?php

class Application_Model_DbTable_MovieImgText extends Application_Model_DbTable_Abstract
{

    protected $_name = 'movieimgtext';


    public function addMovieTextPic ($data, $movie_id) {

        $array = array(

            'movie_id' => $movie_id,
            'textImg' => $data,

        );

        $this->insert($array);

    }

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
}

