<?php

class Application_Model_DbTable_Users extends Application_Model_DbTable_Abstract
{
//EMEIL
    protected $_name = 'users';

    /*
     public function createUser($data) {

        $array = array(

            "nickname" => $data['nickname'],
            "email" => $data['email'],
            "password" => md5($data['password']),
            "created" => date('Y-m-d H:i:s'),
            "updated" => date('Y-m-d H:i:s')

        );

        $this->insert($array);

    }
    */

    public function createUser($request) {



            #простіше додати в реквест потрібні поля як в масив ніж наново визначати всі елементи паря
            #але в рекесті в тебе є дишній сабміт тому його треба буде забрати
            #тому краще робити просто кнопку яка буде слати по кліку аякс, хотя воно в тебе не обовязкове
            #нашо ти дублюєш? воно і так є

            $request['password'] = md5($request['password']);
            $request['created'] = date('Y-m-d H:i:s');
            $request['updated'] = date('Y-m-d H:i:s');




        $this->insert($request);

    }

    #check email to unique

    public function checkByMail($email){


        $data = $this   ->select()
                        ->from($this->_name)
                        ->where('email = ?' , $email);

        return $data->query()->fetch();





    }

}

