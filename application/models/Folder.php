<?php

class Application_Model_Folder {

    public function createFolderChain($path, $separator = '/')
    {
        $path = explode($separator, $path); //exploding path by separator(default = '/')
        $path = array_filter($path); //remove empty elements from array
        $currentDir = realpath(APPLICATION_PATH . '/../www/') . DIRECTORY_SEPARATOR; //first dir after public
        foreach ($path as $folder) {
            $currentDir .= $folder . DIRECTORY_SEPARATOR; //each iterations append next folder with separator
            if (!file_exists($currentDir) OR !is_dir($currentDir)) { //if there is no such folder ->
                if(!mkdir($currentDir)) die('Can\'t create dir'); // create ! <-
            }

        }
    }
}