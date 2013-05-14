<?php

class Application_Model_DbTable_Articles extends Application_Model_DbTable_Abstract
{


    protected $_name = 'articles';


    public function getArticles($from = ''){
        #from , to не обовязкові змінні як бачиш
        $data = $this   ->select()
                        ->from('articles',array('id', 'miniImg', 'title', 'shortDesc', 'full', 'author', 'updateDate', 'ratingGood', 'ratingBad'))
                        ->order('id DESC')

        ;

        if(isset($from))$data->limit(5,$from);

        return $data->query()->fetchAll();
    }


    public function getArticlesById ($id){

        $art = $this    ->select()
                        ->from('articles', array('id', 'miniImg', 'title', 'shortDesc', 'full', 'author', 'ratingGood', 'ratingBad', 'updateDate'))
                        ->where('id = ?', $id)
        ;

        return $art->query()->fetch();

    }


    public function addArticles($newData){

        #ці файли тільки для запитів до бд, не забувай про мвс
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

        #$request так як в тебе назви полыв в бд  ынпутыв однаковы то тобы не треба формавати масив
        #ін вже такий як треба ахуєл да?
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


    public function deleteArticle ($id) {

        $this->delete('id=' . (int)$id);

    }

    public function workWithComments (){

        $wwc = $this   ->select()
                        ->from('articles', array('title'))
        ;

        return $wwc->query()->fetchAll();

    }

    public function getArticlesIn($in){

        $data = $this   ->select()
                        ->from('articles')
                        ->where('id IN (?)', $in);

        $id = $data->query();
        return $id->fetchAll();

    }


    /*
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
