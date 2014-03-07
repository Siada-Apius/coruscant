<?php

class Application_Model_DbTable_Articles extends Application_Model_DbTable_Abstract
{
    protected $_name = 'articles';

    public function getArticles($from = ''){

        /**
         * method getArticles
         * get all articles
         *
         * limited by 5
         *
         * return fields:
         * @param id
         * @param miniImg
         * @param title
         * @param shortDescription
         * @param addedDate
         */

        $data = $this   ->select()
                        ->from($this->_name, array('id', 'miniImg', 'title', 'shortDesc', 'addDate'))
                        ->where('status = ?', 1)
                        ->order('id DESC')
        ;

        if(isset($from))$data->limit(5, $from);

        return $data->query()->fetchAll();

    }


    public function getArticleWhereId($id){

        /**
         * method getArticlesAdmin
         * get article where id == @var $id
         *
         * return fields:
         * @param id
         * @param miniImg
         * @param title
         * @param shortDescription
         * @param fullDescription
         * @param addedDate
         */

        $data = $this   ->select()
                        ->from($this->_name, array('id', 'miniImg', 'title', 'shortDesc', 'full', 'addDate'))
                        ->where('id = ?', (int)$id)
        ;

        return $data->query()->fetch();
    }


    public function getArticlesAdmin($from = ''){

        /**
         * method getArticles
         * get articles for admin
         *
         * limited by 5
         *
         * return fields:
         * @param id
         * @param miniImg
         * @param title
         * @param shortDescription
         * @param updatedDate
         */

        $data = $this   ->select()
            ->from($this->_name, array('id', 'miniImg', 'title', 'shortDesc', 'updateDate'))
            ->order('id DESC')
        ;

        if(isset($from))$data->limit(5, $from);

        return $data->query()->fetchAll();

    }


    public function addArticles($newData){

        /**
         * method addArticles
         *
         * method add new article and return last ID
         * @return $array[lastInsertId()]
         */

        $array = array(
            'title' => $newData['title'],
            'shortDesc' => $newData['shortDesc'],
            'full' => $newData['full'],
            'author' => $newData['author'],
            'addDate' => date('Y-m-d H:i:s'),
            'updateDate' => date('Y-m-d H:i:s'),
            'miniImg' => $newData['miniImg'],
            'status' => $newData['status']

        );

        $this->insert($array);

        return $this->getAdapter()->lastInsertId();
    }


    public function editArticles($request){

        /**
         * method editArticles
         *
         * if input miniImg is empty, update without miniImg
         * else update all record
         */

        if (empty($request['miniImg'])) {

            $array = array(

                'title' => $request['title'],
                'shortDesc' => $request['shortDesc'],
                'full' => $request['full'],
                'author' => $request['author'],
                'updateDate' => date('Y-m-d H:i:s'),
                'status' => $request['status'],

            );

            $where = $this->getAdapter()->quoteInto('id = ?', $request['id']);
            $this->update($array, $where);

        } else {

            $where   = array( $this->getAdapter()->quoteInto('id = ?', $request['id']) );
            $this->update($request, $where);

        }

    }

    public function getArticlesIn($in){

        /**
         * method getArticlesIn
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

    /**
    public function createBusiness ($array = array(), $userId) {

        $data = array(

            'user_id' => $userId,
            'yelp_id' => $array['yelp_id'],
            'name' => $array['name'],
            'zip' => $array['zip'],
            'address' => $array['address'],
            'city' => $array['city'],
            'state' => $array['state'],
            'phone' => $array['phone'],
            'email' => $array['email'],
            'img_url' => $array['img'],
            'created' => date("Y-m-d H:i:s"),
            'updated' => date("Y-m-d H:i:s")

        );

        //Аналог!

        $array['user_id'] = $userId;
        $array['created'] = date("Y-m-d H:i:s");
        $array['updated'] = date("Y-m-d H:i:s");

        $this->insert($data);

        return $this->getAdapter()->lastInsertId();
    }

     */
}
