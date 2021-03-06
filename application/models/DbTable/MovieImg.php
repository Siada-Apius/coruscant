<?php

class Application_Model_DbTable_MovieImg extends Application_Model_DbTable_Abstract
{

    protected $_name = 'movie_img';


    public function getMovieImageWhere($id, $type) {

        /**
         * @method getMovieImageWhere
         *
         * @return all fields where movie_id == $id
         * @return and type == $type
         */

        foreach ($type as $val){

            $data = $this   ->select()
                            ->from($this->_name)
                            ->where('movie_id = ?', $id)
                            ->where('type = ?', $val)
            ;

            $fatArray[$val] = $data->query()->fetchAll();

        }

        return $fatArray;
    }

    public function addMoviePic ($data, $movie_id, $type) {

        /**
         * @method addMoviePic
         *
         * insert new pic where type is
         */

        $array = array(

            'movie_id' => $movie_id,
            'addImg' => $data,
            'type' => $type

        );

        $this->insert($array);

    }

}

