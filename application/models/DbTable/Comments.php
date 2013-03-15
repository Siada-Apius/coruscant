<?php

class Application_Model_DbTable_Comments extends Zend_Db_Table_Abstract
{

    protected $_name = 'comments';

    public function getCommentsByArticleId($id){

        $data = $this   ->select()
                        ->from('comments', array('id', 'user_name', 'owner', 'com_date', 'com_text'))
        ;

        if($id)$data->where('article_id = ? ', $id);

        return $data->query()->fetchAll();
    }


    public function addComment($addDate, $id){

        $addCom = array(
            'article_id' => $id,
            'user_name' => $addDate['user_name'],
            'com_date' => date('Y-m-d H:i:s'),
            'com_text' => $addDate['com_text']

        );

        $this->insert($addCom);

    }

    public function getAllComments (){

        $data = $this   -> select()
                        ->from('comments', array('user_name', 'owner', 'com_date', 'com_text'))
        ;

        return $data->query()->fetchAll();
    }


    public function deleteComment($id){

        $this->delete('id=' . (int)$id);

    }

}

