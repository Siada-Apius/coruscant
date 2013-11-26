<?php
    /**
    * Created by  Volodymyr Pasika.
    * Date: 17.06.13
    * Time: 13:55
    * Skype: passika_web
    */

class Application_Model_Images {

    public function createRandName($old){

        /*
         * createRandName method
         *
         * Generate default name for image
         *
         * param $old  (string) old name
         * return $new (string) new name
         *
         */

        $new = '';
        srand((double)microtime() * 1000000);
        $char_list = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $char_list .= "abcdefghijklmnopqrstuvwxyz";
        $char_list .= "1234567890";

        for ($i = 0; $i < 8; $i++) {

            $new .= substr($char_list, (rand() % (strlen($char_list))), 1);

        }

        $array = explode('.', $old);
        $ext = strtolower(end($array));

        $name = $new . '.' . $ext;

        return $new;

    }

    public function resize($file, $size, $height, $name, $path)
    {
        /**
         * method resize
         *
         * Method for resizing image
         * @param $file(string) image path - //'./img/article/114/'
         * @param $size(string) new width - //width in px
         * @param $height(string) new height - //height in px
         * @param $name(string) new name
         * @param $path(string) new path - //'./img/article/114/'
         */

        if (!is_dir($path . '/'))
            if (!mkdir($path, 0777)) ;

        $array = explode('.', $name);
        $ext = strtolower(end($array));

        switch (strtolower($ext)) {

            case "gif":
                $out = imagecreatefromgif($file);
                break;

            case "jpg":
                $out = imagecreatefromjpeg($file);
                break;

            case "jpeg":
                $out = imagecreatefromjpeg($file);
                break;

            case "png":
                $out = imagecreatefrompng($file);
                break;
        }

        $src_w = imagesx($out);
        $src_h = imagesy($out);

        if ($src_w > $size || $src_h > $height) {

            if ($src_w > $size) {

                $dst_w = $size;
                $dst_h = floor($src_h / ($src_w / $size));


                $img_out = imagecreatetruecolor($dst_w, $dst_h);
                imagecopyresampled($img_out, $out, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);

                switch (strtolower($ext)) {
                    case "gif":
                        imagegif($img_out, $path . $name);
                        break;
                    case "jpg":
                        imagejpeg($img_out, $path . $name, 100);
                        break;
                    case "jpeg":
                        imagejpeg($img_out, $path . $name, 100);
                        break;
                    case "png":
                        imagepng($img_out, $path . $name);
                        break;
                }

            } else if ($src_h > $height) {

                $dst_h = $height;
                $dst_w = floor($src_w / ($src_h / $height));

                if ($dst_w > $size) {

                    $dst_w = $size;
                    $dst_h = floor($src_h / ($src_w / $size));

                }


                $img_out = imagecreatetruecolor($dst_w, $dst_h);
                imagecopyresampled($img_out, $out, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);

                switch (strtolower($ext)) {
                    case "gif":
                        imagegif($img_out, $path . $name);
                        break;
                    case "jpg":
                        imagejpeg($img_out, $path . $name, 100);
                        break;
                    case "jpeg":
                        imagejpeg($img_out, $path . $name, 100);
                        break;
                    case "png":
                        imagepng($img_out, $path . $name);
                        break;
                }

            }

            $array = explode('.', $name);
            $ext = strtolower(end($array));

            switch (strtolower($ext)) {

                case "gif":
                    $out = imagecreatefromgif($path . $name);
                    break;

                case "jpg":
                    $out = imagecreatefromjpeg($path . $name);
                    break;

                case "jpeg":
                    $out = imagecreatefromjpeg($path . $name);
                    break;

                case "png":
                    $out = imagecreatefrompng($path . $name);
                    break;
            }

            $src_w = imagesx($out);
            $src_h = imagesy($out);

            if ($src_h > $height) {

                $dst_h = $height;
                $dst_w = floor($src_w / ($src_h / $height));

                if ($dst_w > $size) {

                    $dst_w = $size;
                    $dst_h = floor($src_h / ($src_w / $size));

                }

                $img_out = imagecreatetruecolor($dst_w, $dst_h);
                imagecopyresampled($img_out, $out, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);

                switch (strtolower($ext)) {
                    case "gif":
                        imagegif($img_out, $path . $name);
                        break;
                    case "jpg":
                        imagejpeg($img_out, $path . $name, 100);
                        break;
                    case "jpeg":
                        imagejpeg($img_out, $path . $name, 100);
                        break;
                    case "png":
                        imagepng($img_out, $path . $name);
                        break;
                }

            }

        } else {

            copy($file, $path . $name);

        }


    }

    public function createRandString(){

        /*
         * createRandName method
         *
         * Generate default name for image
         *
         * param $old  (string) old name
         * return $new (string) new name
         *
         */

        $new = '';
        srand((double)microtime() * 1000000);
        $char_list = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $char_list .= "abcdefghijklmnopqrstuvwxyz";
        $char_list .= "1234567890";

        for ($i = 0; $i < 8; $i++) {

            $new .= substr($char_list, (rand() % (strlen($char_list))), 1);

        }

        return $new;

    }

    public function createRandInt(){

        /*
         * createRandName method
         *
         * Generate default name for image
         *
         * param $old  (string) old name
         * return $new (string) new name
         *
         */

        $new = '';
        srand((double)microtime() * 1000000);
        $char_list = "1234567890";

        for ($i = 0; $i < 8; $i++) {

            $new .= substr($char_list, (rand() % (strlen($char_list))), 1);

        }

        return $new;

    }

}
