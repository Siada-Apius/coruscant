<?php

class Application_Model_DbTable_Games extends Application_Model_DbTable_Abstract
{

    protected $_name = 'games';

    public function getGamesIn($in){

        /**
         * method getGamesIn
         *
         * using in search
         *
         * return fields:
         * @param id
         * @param title
         */

        $data = $this   ->select()
                        ->from($this->_name, array('id', 'title'))
                        ->where('id IN (?)', $in)
                        ->order('id DESC')
        ;

        return $data->query()->fetchAll();

    }

    public function editGame($data){

        /**
         * @method editGame
         *
         * if field poster is empty, update without him
         * else update all
         */

        if ($data['poster'] == '') {

            $array = array(

                'desc'      => $data['desc'],
                'title'     => $data['title'],
                'system'    => $data['system'],
                'funny'     => $data['funny'],
                'status'    => $data['status'],
                'author'    => $data['author']

            );

            $where = $this->getAdapter()->quoteInto('id = ?', $data['id']);

            $this->update($array, $where);

        } else {

            $where   = array(

                $this->getAdapter()->quoteInto('id = ?', $data['id'])

            );

            $this->update($data, $where);
        }

        return $this->getAdapter()->lastInsertId();
    }

    public function getGames(){

        /**
         * method getMoviesAdmin
         * get all movies article for admin
         *
         * @return:
         * @param id
         * @param title
         * @param poster
         * @param status
         */

        $data = $this   ->select()
                        ->from($this->_name, array('id', 'title', 'poster', 'status'))
        ;

        return $data->query()->fetchAll();
    }

    public function getGameWhereId($id){


        $data = $this   ->select()
                        ->from($this->_name, array('id', 'poster', 'title', 'desc', 'system', 'funny', 'status', 'author'))
                        ->where('id = ?', (int)$id)
        ;

        return $data->query()->fetch();
    }

}

