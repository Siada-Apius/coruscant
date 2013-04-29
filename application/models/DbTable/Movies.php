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

        $this->insert($param);

    }

}