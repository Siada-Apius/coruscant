<?php

    class My_View_Helper_Comments extends Zend_View_Helper_Abstract{

    public function comments($id){

        $comments = new Application_Model_DbTable_Comments();
        $array = $comments->getCommentsByArticleId($id);

        $identity = Zend_Auth::getInstance()->getStorage()->read();

        echo "<ul class='list'>";

        foreach ($array as $value){

            echo"<li  id = 'comment{$value['id']}'>
                    <div class='comments'>
                        <div class='user_name'>{$value['user_name']}</div>
                        <div class='com_date'>{$value['com_date']}</div>
            ";

            if (isset($identity->role)  && $identity->role == 'admin'){


                echo"   <div class='comDelete'>
                            <input class='comDeleteInput' type='image' src='/img/style/delete.png' value='". $value['id'] ."' title='{$value['id']}'>
                        </div>
                        <div class='com_text'>{$value['com_text']}</div>
                ";
            }

            else{
            echo"        <div class='com_text'>{$value['com_text']}</div>
                    </div>
                </li>
            ";

            }
        }

        echo "</ul>";

    }

}

