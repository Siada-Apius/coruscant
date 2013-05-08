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

        #Insert new movie article

        $this->insert($param);

        return $this->getAdapter()->lastInsertId();
    }

    public function getAllMovie() {

        #get all movies article

        $data = $this   ->select()
                        ->from($this->_name, array('id', 'miniImg', 'title', 'full'))
        ;

        return $data->query()->fetchAll();
    }

    public function getMovieById ($id) {

        #get movies article by id

        $data = $this   ->select()
                        ->from($this->_name, array('id', 'miniImg', 'title', 'full'))
                        ->where('id = ?', $id)
        ;

        return $data->query()->fetch();

    }

    public function editMovie ($request) {

        #Zend_Debug::dump($request);die;
        if ($request['miniImg'] == '') {

            $array = array(

                'title' => $request['title'],
                'full' => $request['full']

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

}