<?php

abstract class Application_Model_DbTable_Abstract extends Zend_Db_Table_Abstract
{

    public function getItem($id){
        $id = (int)$id;
        $row = $this->fetchRow('id = ' . (int)$id);
        if(!$row) {
            throw new Exception("There is no element with ID: $id");
        }

        return $row->toArray();
    }

    public function getItemsList(){
        return $this->fetchAll()->toArray();
    }

    public function createItem($data)
    {

        try{
            $pk = $this->insert($data);
        } catch  (Exception $e) {
            $pk = false;
        }
        return $pk;

    }

    public function deleteItem($id)
    {

        $this->delete('id=' . ((int)$id));

    }

    public function updateItem($data,$id)
    {
        try{
            $pk = $this->update($data, 'id = ' . (int)$id);
            return true;
        } catch  (Exception $e) {
            $pk = false;
        }
        return $pk;

    }

    public function maxId($db) {


        $data = $this   ->select()
                        ->from($db, array(new Zend_Db_Expr('max(id) as maxId')));

        return $data->query()->fetch();

    }


}

