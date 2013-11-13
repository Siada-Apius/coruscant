<?php

abstract class Application_Model_DbTable_Abstract extends Zend_Db_Table_Abstract
{


    public function maxId($db) {

        /**
         * maxId method
         *
         * Method for receiving MAX id
         *
         * @return (array) object data
         */

        $data = $this   ->select()
                        ->from($db, array(new Zend_Db_Expr('max(id) as maxId')))
        ;

        return $data->query()->fetch();

    }


    public function getItem($id){

        /**
        * getItem method
        *
        * Method for receiving object by id
        *
        * @param  $id (int) object id
        * @return (array) object data
        */

        $row = $this->fetchRow($this->select()->where('id = ?', (int)$id));

        return $row->toArray();

    }


    public function getItemsList(){

        /**
        * getItemsList method
        *
        * Method for receiving list of objects
        *
        * @return (array) objects data list array
        */

        return $this->fetchAll()->toArray();

    }


    public function createItem($data){

        /**
         * createItem method
         *
         * Method create new record
         *
         * @param $data (array)
         * @return last insert id
         */

        $this->insert($data);

        return $this->getAdapter()->lastInsertId();

    }


    public function deleteItem($id){

        /**
        * deleteItem method
        *
        * Method to delete form DB by id
        *
        * @param  $id (int) object id
        */

        $this->delete('id = ' . (int)$id);

    }


    public function updateItem($data, $id){

        /**
        * updateItem method
        *
        * Method to delete form DB by id
        *
        * @param $id   (int)   object id
        * @param $data (array) data to update
        */

        $where = $this->getAdapter()->quoteInto('id = ?', (int)$id);
        return $this->update($data, $where);

    }

}

