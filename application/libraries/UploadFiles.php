<?php
class UploadFiles{

    public function Upload($config){

        $config['upload_path']   = isset($config['upload_path']) && !empty($config['upload_path']) ? $config['upload_path'] : "./uploads";
        $config['allowed_types'] = isset($config['allowed_types']) && !empty($config['allowed_types']) ? $config['allowed_types'] : '*';
        $config['max_size']      = isset($config['max_size']) && !empty($config['max_size']) ? $config['max_size'] : 5500000;
        $config['encrypt_name']  = isset($config['encrypt_name']) && !empty($config['encrypt_name']) ? $config['encrypt_name'] : FALSE;
        $config['overwrite']     = isset($config['overwrite']) && !empty($config['overwrite']) ? $config['overwrite'] : TRUE;

        $this->CI =& get_instance();
        $this->CI->load->library('upload', $config);

        $files = $_FILES;
        foreach($_FILES as $file_name=>$value)
        {
            if ($file_name !== "" && $value['name']!=='' && $value['size'] > 0  && $value['error'] !==4  )
            {
                // ESPECIAL PARA ARCHIVO MULTIPLE
                if(is_array($value['name']))
                {
                    foreach ($_FILES[$file_name]['name'] as $key => $value) 
                    {
                        $_FILES[$file_name]['name']    = $files[$file_name]['name'][$key];
                        $_FILES[$file_name]['type']    = $files[$file_name]['type'][$key];
                        $_FILES[$file_name]['tmp_name']= $files[$file_name]['tmp_name'][$key];
                        $_FILES[$file_name]['error']   = $files[$file_name]['error'][$key];
                        $_FILES[$file_name]['size']    = $files[$file_name]['size'][$key];

                        $path= $config['upload_path'] . md5(date("H:m:i")) ."/". $file_name;
                        if (!file_exists( $path ))
                            mkdir( $path, 0777, true);

                        $path_dependiente= $path;
                        $config['upload_path']= $path;

                        $this->CI->upload->initialize($config);
                        if($this->CI->upload->do_upload($file_name))
                        {
                            $path= explode("uploads", $this->CI->upload->data()['full_path']);
                            $path= "uploads".$path[1];
                            $arr[]=array($path);
                            $data[$file_name] = array('file_name'=> $file_name, 'full_path' => $arr);
                            unset($config['upload_path']);
                            $config['upload_path']= $path_dependiente;
                        }
                    }

                }

                // ARCHIVO UNICO
                if ( isset($value['name']) && !is_array($value['name']) && !empty($value['name']))
                {
                    if (!file_exists($config['upload_path'] . $file_name))
                        mkdir($config['upload_path'] . $file_name, 0777, true);

                    $path_dependiente= $config['upload_path'];
                    $config['upload_path']= $config['upload_path'] . $file_name;

                    $this->CI->upload->initialize($config);

                    if ( $this->CI->upload->do_upload($file_name))
                    {
                        $path= explode("uploads", $this->CI->upload->data()['full_path']);
                        $path= "uploads".$path[1];
                        $data[$file_name] = $path;
                    }
                    else
                    {
                        return $this->CI->upload->display_errors();
                    }

                    unset($config['upload_path']);
                    $config['upload_path']= $path_dependiente;
                }
                
            }
        }

        if (isset($data) && is_array($data))
        {
            return $data;
        }


    }

}
?>
