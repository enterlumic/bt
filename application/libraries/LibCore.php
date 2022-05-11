<?php
class LibCore{

    public function borrar_archivos($postData)
    {
        foreach ($postData as $key => $value) {
            
            if (preg_match("/^vc_path/", $key) )
            {
        
                $files= scandir(pathinfo($value)['dirname'], 1);
                
                if (is_array($files) && $files !==".")
                {

                    foreach ($files as $value1) 
                    {

                        if (!in_array($value1,array(".",".."))
                            && file_exists(pathinfo($value)['dirname'] ."/". $value1) 
                            && pathinfo($value)['basename'] !== $value1
                            && preg_match("/vc_path/", pathinfo($value)['dirname'])
                        )
                        {
                            unlink(pathinfo($value)['dirname'] ."/". $value1);
                        }

                        unset($value1);

                    }
                }


                unset($files);
            }

        }        
    }    
}
?>