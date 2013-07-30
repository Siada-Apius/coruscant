<?php

class Application_Model_DbTable_Articles extends Application_Model_DbTable_Abstract
{
    protected $_name = 'articles';

    public function getArticles($from = ''){

        /**
         * method getArticles
         *
         * return all fields but limited by 5
         * @var $data
         */

        $data = $this   ->select()
                        ->from($this->_name, array('id', 'miniImg', 'title', 'shortDesc', 'full', 'author', 'updateDate', 'ratingGood', 'ratingBad'))
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
            "title" => $newData['title'],
            "shortDesc" => $newData['shortDesc'],
            "full" => $newData['full'],
            "author" => $newData['author'],
            "addDate" => date('Y-m-d H:i:s'),
            "updateDate" => date('Y-m-d H:i:s'),
            "miniImg" => $newData['miniImg']

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

        if ($request['miniImg'] == '') {

            $array = array(

                'title' => $request['title'],
                'shortDesc' => $request['shortDesc'],
                'full' => $request['full'],
                'author' => $request['author'],
                'updateDate' => date('Y-m-d H:i:s'),

            );

            $where = $this->getAdapter()->quoteInto('id = ?', $request['id']);
            $this->update($array, $where);

        } else {

            $where   = array(

                $this->getAdapter()->quoteInto('id = ?', $request['id'])

            );

            $this->update($request, $where);

        }

    }

    public function getArticlesIn($in){

        /**
         * method getArticlesIn
         *
         * return all fields where id == $in
         */

        $data = $this   ->select()
                        ->from($this->_name)
                        ->where('id IN (?)', $in)
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
