<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Siada-Apius
 * Date: 29.04.13
 * Time: 18:42
 * To change this template use File | Settings | File Templates.
 */

class Application_Model_DbTable_Movies extends Application_Model_DbTable_Abstract {

    protected $_name = 'movies';

    public function addMovie($param) {

        /**
         * method addMovie
         *
         * @$param['addImg'] and @$param['ostImg'] - there are not in this DB Table
         *
         * Insert new movie article and return last insert ID
         */

        unset($param['addImg']);
        unset($param['ostImg']);

        $this->insert($param);

        return $this->getAdapter()->lastInsertId();
    }

    public function editMovie ($request) {

        /**
         * method editMovie
         *
         * if field miniImg is empty, update without him
         * else update all
         */

        if ($request['miniImg'] == '') {

            $array = array(

                'short' => $request['short'],
                'title' => $request['title'],
                'full' => $request['full'],
                'actors' => $request['actors'],
                'funny' => $request['funny'],

            );

            $where = $this->getAdapter()->quoteInto('id = ?', $request['id']);

            $this->update($array, $where);

        } else {

            $where   = array(

                $this->getAdapter()->quoteInto('id = ?', $request['id'])

            );

            $this->update($request, $where);

        }

        return $this->getAdapter()->lastInsertId();
    }

    public function getMoviesIn($in){

        /**
         * @method getMoviesIn
         *
         * @return all fields where id == $in
         */

        $data = $this   ->select()
                        ->from($this->_name)
                        ->where('id IN (?)', $in)
                        ->order('id DESC')
        ;

        return  $data->query()->fetchAll();
    }

}