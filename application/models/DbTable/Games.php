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

                'desc' => $data['desc'],
                'title' => $data['title'],
                'system' => $data['system'],
                'funny' => $data['funny'],

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

    public function getOnlyId () {

        /**
         * getOnlyId method
         *
         * Method what select all id from table
         * Where article status is open
         *
         * @use - CRON JOB
         */

        $data = $this   ->select()
                        ->from($this->_name, 'id')
                        ->where('status = ?', 1)
        ;

        return $data->query()->fetchAll();
    }

}

