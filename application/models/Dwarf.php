<?php

class Application_Model_Dwarf
{

    public function rrmdir($dir) {

        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
                }
            }
            reset($objects);
            rmdir($dir);
        }

    }

    public function deleteFile($directory,$filename){

        // открываем директорию (получаем дескриптор директории)
        $dir = opendir($directory);

        // считываем содержание директории
        while(($file = readdir($dir))){

            // Если это файл и он равен удаляемому ...
            if((is_file("$directory/$file")) && ("$directory/$file" == "$directory/$filename"))

                // ...удаляем его.
            unlink("$directory/$file");

            // Если файла нет по запрошенному пути, возвращаем TRUE - значит файл удалён.
            if(!file_exists($directory."/".$filename)) return $s = TRUE;

        }
        // Закрываем дескриптор директории.
        closedir($dir);
    }

}

