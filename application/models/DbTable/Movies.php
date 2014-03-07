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
         * for add new movie article
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
         * for edit movie article
         *
         * if field miniImg is empty, update without him
         * else update all
         */

        if ($request['miniImg'] == '') {

            $array = array(

                'short'     => $request['short'],
                'title'     => $request['title'],
                'trailer'   => $request['trailer'],
                'full'      => $request['full'],
                'actors'    => $request['actors'],
                'funny'     => $request['funny'],
                'ostList'   => $request['ostList'],
                'status'    => $request['status'],
                'author'    => $request['author'],

            );

            $where = $this->getAdapter()->quoteInto('id = ?', $request['id']);

            $this->update($array, $where);

        } else {

            $where = array(

                $this->getAdapter()->quoteInto('id = ?', $request['id'])

            );

            $this->update($request, $where);

        }

        return $this->getAdapter()->lastInsertId();
    }

    public function getMoviesIn($in){

        /**
         * method getMoviesIn
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

        return  $data->query()->fetchAll();
    }

    public function getMovies(){

        /**
         * method getMoviesAdmin
         * get all movies article for admin
         *
         * return fields:
         * @param id
         * @param title
         * @param miniImg
         */

        $data = $this   ->select()
                        ->from($this->_name, array('id', 'title', 'miniImg', 'status'))
        ;

        return $data->query()->fetchAll();
    }

    public function getMovieWhereId($id){

        /**
         * method getMovieWhereId
         * get movie article where id == @var $id
         *
         * return fields:
         * @param id
         * @param miniImg
         * @param title
         * @param short
         * @param trailer
         * @param actors
         * @param full
         * @param funny
         * @param ostList
         * @param status
         * @param author
         */

        $data = $this   ->select()
                        ->from($this->_name, array('id', 'miniImg', 'title', 'short', 'trailer', 'actors', 'full', 'funny', 'ostList', 'status', 'author'))
                        ->where('id = ?', (int)$id)
        ;

        return $data->query()->fetch();
    }
}