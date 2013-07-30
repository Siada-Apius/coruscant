<?php

class Application_Model_DbTable_GamesImg extends Application_Model_DbTable_Abstract
{

    protected $_name = 'games_img';

    public function addGamePic ($data, $game_id, $type) {

        /**
         * @method addGamesPic
         *
         * insert new pic where type and id is
         */

        $array = array(

            'game_id' => $game_id,
            'text_img' => $data,
            'type' => $type

        );

        $this->insert($array);

    }


}

