<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload {

    public function upload_file($files, $path, $get_path)
    {
        $_FILES= $files;

        if (is_array($_FILES) && count($_FILES) > 0){

            foreach ($_FILES as $key=>$value){

                $image_name    = $value['name'];
                $tmp_name      = $value['tmp_name'];
                $size          = $value['size'];
                $type          = $value['type'];
                $error         = $value['error'];
                $allowed       =  array('pdf');
                $filename      = $image_name;
                $ext           = pathinfo($filename, PATHINFO_EXTENSION);
                $file_basename = md5(substr($filename, 0, strripos($filename, '.')) . microtime(true)  );
                $file_ext      = substr($filename, strripos($filename, '.'));
                $filename;
                $directoryName = $path;
                
                if(!is_dir($directoryName)){
                    mkdir($directoryName, 0755, true);
                }
                
                $target_img  = $directoryName . DIRECTORY_SEPARATOR . md5($file_basename) . $file_ext;
                $target_name = md5($file_basename) . $file_ext;

                if(in_array($ext,$allowed)){
                    if(move_uploaded_file($tmp_name,$target_img)){
                        ///////////////////////////
                        $target_img= $target_name;
                        
                        return array("b_status"=> true, "vc_photo"=>$target_name, "ss"=>$target_img);
                    }else{
                        return array("b_status"=> false, "errors"=> "no se pudo cargar");
                    }
                }
                return array("b_status"=> false, "errors"=> "Solo se permite: ". $allowed[0]. ", ". $allowed[1]. ", ". $allowed[2]. ", ". $allowed[3]);
                
            }
        }
        return $images_arr;
    }

}