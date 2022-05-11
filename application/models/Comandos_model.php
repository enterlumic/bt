<?php

 class Comandos_model extends CI_Model {

    private $id_user;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Debug_model');        
        $this->load->library('session');
        $this->load->library('encryption');
        $this->encryption->initialize( array( 'cipher' => 'aes-256', 'mode' => 'ctr', 'key' => '<a 32-character random string>') );
        $this->load->database();
        $this->id_user= isset($this->session->userdata['id_user'])? $this->session->userdata['id_user']: 0;
    }

    public function get_comandos_all($postData)
    {
        $sql= "CALL get_comandos_all(".$this->db->escape( trim( $postData['vc_atajo_teclado'] ) ).");";
        
        $query = $this->db->query($sql);
        $error = $this->db->error();

        if ($error['code'] === 0 && is_object($query->result_id))
        {
            foreach ($query->result() as $key => $value) 
            {
                $data[]= array("id_comandos"=>$value->id_comandos, "total"=> count($query->result()), "vc_comando" => $value->vc_comando, "vc_path_script" => $value->vc_path_script);
            }

            $this->db->close();

            return $error['code'] === 0 && count($data) > 0 
            ? $this->load->response(true, $data) 
            : $this->load->response(false, json_encode($error) );

        }
        else
        {
            return $this->load->response(false, json_encode($error) );
        }
    }

    public function get_comandos_all_by_id()
    {
        $sql= "CALL get_comandos_all_by_id();";
        $this->Debug_model->set_debug($this->id_user, "get_comandos_all_by_id", "\n" . $sql);
        $this->db->close();

        $query = $this->db->query($sql);
        $error = $this->db->error();

        if ($error['code'] === 0 && is_object($query->result_id))
        {
            foreach ($query->result() as $key => $value) 
            {
                $data[]= array("id_comandos"=>$value->id_comandos, "total"=> count($query->result()), "vc_comando" => $value->vc_comando, "vc_path_script" => $value->vc_path_script);
            }

            $this->db->close();

            return $error['code'] === 0 && count($data) > 0 
            ? $this->load->response(true, $data) 
            : $this->load->response(false, json_encode($error) );

        }
        else
        {
            return $this->load->response(false, json_encode($error) );
        }
    }

    public function get_comandos_by_id($postData)
    {
        $postData["id_comandos"]= $postData["id_comandos"];

        if (empty($postData["id_comandos"]))
            return $this->load->response(false, array("vc_message" => "El id_comandos es altamente requerido ") );

        if (!is_numeric($postData["id_comandos"]))
            return $this->load->response(false, array("vc_message" => "Se espera un valor numérico en: id_comandos ") );

        $sql= "CALL sp_get_comandos_by_id(".intval( $postData["id_comandos"] ).");";
        $query = $this->db->query($sql);
        $error = $this->db->error();

        if ($error['code'] === 0 && is_object($query->result_id))
        {
            foreach ($query->result() as $key => $value) 
            {
                $data= array("id"=> $this->encryption->encrypt($value->id) 
                              ,"vc_atajo_teclado" => $value->vc_atajo_teclado
                              ,"vc_comando" => $value->vc_comando
                              ,"vc_descripcion" => $value->vc_descripcion
                              ,"vc_path_script" => $value->vc_path_script
                              ,"vc_comentario" => $value->vc_comentario
                              ,"vCampo7_comandos" => $value->vCampo7_comandos
                              ,"vCampo8_comandos" => $value->vCampo8_comandos
                              ,"vCampo9_comandos" => $value->vCampo9_comandos
                              ,"vCampo10_comandos" => $value->vCampo10_comandos
                              ,"vCampo11_comandos" => $value->vCampo11_comandos
                              ,"vCampo12_comandos" => $value->vCampo12_comandos
                              ,"vCampo13_comandos" => $value->vCampo13_comandos
                              ,"vCampo14_comandos" => $value->vCampo14_comandos
                              ,"vCampo15_comandos" => $value->vCampo15_comandos
                              ,"vCampo16_comandos" => $value->vCampo16_comandos
                              ,"vCampo17_comandos" => $value->vCampo17_comandos
                              ,"vCampo18_comandos" => $value->vCampo18_comandos
                              ,"vCampo19_comandos" => $value->vCampo19_comandos
                              ,"vCampo20_comandos" => $value->vCampo20_comandos
                              ,"vCampo21_comandos" => $value->vCampo21_comandos
                              ,"vCampo22_comandos" => $value->vCampo22_comandos
                              ,"vCampo23_comandos" => $value->vCampo23_comandos
                              ,"vCampo24_comandos" => $value->vCampo24_comandos
                              ,"vCampo25_comandos" => $value->vCampo25_comandos
                              ,"vCampo26_comandos" => $value->vCampo26_comandos
                              ,"vCampo27_comandos" => $value->vCampo27_comandos
                              ,"vCampo28_comandos" => $value->vCampo28_comandos
                              ,"vCampo29_comandos" => $value->vCampo29_comandos
                              ,"vCampo30_comandos" => $value->vCampo30_comandos
                );
            }

            $this->db->close();

            $this->Debug_model->set_debug($this->id_user, "sp_get_comandos_by_id", "\n" . $sql);
            $this->db->close();

            return $error['code'] === 0 ? $this->load->response(true, $data) : $this->load->response(false, json_encode($error) );
        }
        else
        {
            return $this->load->response(false, json_encode($error) );
        }
    }

    public function get_comandos_by_datatable($postData) 
    {
        $sql  = "CALL sp_get_comandos(";
        $sql .=      $this->db->escape(isset($postData['search']['value']) && !empty($postData['search']['value']) ? true:false);
        $sql .= "," .$this->db->escape($postData['search']['value']);
        $sql .= "," .$this->db->escape($postData['start']);
        $sql .= "," .$this->db->escape($postData['length']);
        $sql .= "," .$this->db->escape($postData["order"][0]["column"]);
        $sql .= "," .$this->db->escape($postData["order"][0]["dir"]);
        $sql .= ",  @v_registro_total";
        $sql .=")";

        $query=  $this->db->query($sql);
        $result= $query->result();

        $query->free_result();
        $query->next_result();
        $totalRecords= (array) $this->db->query("SELECT @v_registro_total;")->result()[0];
        $totalRecords= $totalRecords['@v_registro_total'] ;

        $error = $this->db->error();
        $this->db->close();

        if ($error['code'] === 0 && is_array($result) && count($result) > 0)
        {
            foreach ($result as $key => $value) 
            {
                $data[]= array( $value->id
                              , $value->vc_atajo_teclado
                              , $value->vc_comando
                              , $value->vc_path_script
                              , $value->vc_comentario
                              , $value->vCampo7_comandos
                              , $value->vCampo8_comandos
                              , $value->vCampo9_comandos
                              , $value->vCampo10_comandos
                              , $this->encryption->encrypt($value->id)
                );
            }

            $json_data = array(
                "draw"            => intval( $postData['draw'] ),   
                "recordsTotal"    => intval( $totalRecords ),  
                "recordsFiltered" => intval( $totalRecords ),
                "data"            => $data
            );

            return json_encode($json_data);
        }
        else
        {
            return json_encode(array("data"=>"" ));
        }         
    }

    public function set_comandos($postData)
    {
        $vc_atajo_teclado= isset($postData['vc_atajo_teclado']) ? $postData['vc_atajo_teclado'] : ""; 
        $vc_comando= isset($postData['vc_comando']) ? $postData['vc_comando'] : ""; 
        $vc_descripcion= isset($postData['vc_descripcion']) ? $postData['vc_descripcion'] : ""; 
        $vc_path_script= isset($postData['vc_path_script']) ? $postData['vc_path_script'] : ""; 
        $vc_comentario= isset($postData['vc_comentario']) ? $postData['vc_comentario'] : ""; 
        $vCampo7_comandos= isset($postData['vCampo7_comandos']) ? $postData['vCampo7_comandos'] : ""; 
        $vCampo8_comandos= isset($postData['vCampo8_comandos']) ? $postData['vCampo8_comandos'] : ""; 
        $vCampo9_comandos= isset($postData['vCampo9_comandos']) ? $postData['vCampo9_comandos'] : ""; 
        $vCampo10_comandos= isset($postData['vCampo10_comandos']) ? $postData['vCampo10_comandos'] : ""; 
        $vCampo11_comandos= isset($postData['vCampo11_comandos']) ? $postData['vCampo11_comandos'] : ""; 
        $vCampo12_comandos= isset($postData['vCampo12_comandos']) ? $postData['vCampo12_comandos'] : ""; 
        $vCampo13_comandos= isset($postData['vCampo13_comandos']) ? $postData['vCampo13_comandos'] : ""; 
        $vCampo14_comandos= isset($postData['vCampo14_comandos']) ? $postData['vCampo14_comandos'] : ""; 
        $vCampo15_comandos= isset($postData['vCampo15_comandos']) ? $postData['vCampo15_comandos'] : ""; 
        $vCampo16_comandos= isset($postData['vCampo16_comandos']) ? $postData['vCampo16_comandos'] : ""; 
        $vCampo17_comandos= isset($postData['vCampo17_comandos']) ? $postData['vCampo17_comandos'] : ""; 
        $vCampo18_comandos= isset($postData['vCampo18_comandos']) ? $postData['vCampo18_comandos'] : ""; 
        $vCampo19_comandos= isset($postData['vCampo19_comandos']) ? $postData['vCampo19_comandos'] : ""; 
        $vCampo20_comandos= isset($postData['vCampo20_comandos']) ? $postData['vCampo20_comandos'] : ""; 
        $vCampo21_comandos= isset($postData['vCampo21_comandos']) ? $postData['vCampo21_comandos'] : ""; 
        $vCampo22_comandos= isset($postData['vCampo22_comandos']) ? $postData['vCampo22_comandos'] : ""; 
        $vCampo23_comandos= isset($postData['vCampo23_comandos']) ? $postData['vCampo23_comandos'] : ""; 
        $vCampo24_comandos= isset($postData['vCampo24_comandos']) ? $postData['vCampo24_comandos'] : ""; 
        $vCampo25_comandos= isset($postData['vCampo25_comandos']) ? $postData['vCampo25_comandos'] : ""; 
        $vCampo26_comandos= isset($postData['vCampo26_comandos']) ? $postData['vCampo26_comandos'] : ""; 
        $vCampo27_comandos= isset($postData['vCampo27_comandos']) ? $postData['vCampo27_comandos'] : ""; 
        $vCampo28_comandos= isset($postData['vCampo28_comandos']) ? $postData['vCampo28_comandos'] : ""; 
        $vCampo29_comandos= isset($postData['vCampo29_comandos']) ? $postData['vCampo29_comandos'] : ""; 
        $vCampo30_comandos= isset($postData['vCampo30_comandos']) ? $postData['vCampo30_comandos'] : ""; 

        $sql  = "CALL sp_set_comandos(";
        $sql .=      $this->db->escape( trim( $vc_atajo_teclado ) );
        $sql .= "," .$this->db->escape( trim( $vc_comando ) );
        $sql .= "," .$this->db->escape( trim( $vc_descripcion ) );
        $sql .= "," .$this->db->escape( trim( $vc_path_script ) );
        $sql .= "," .$this->db->escape( trim( $vc_comentario ) );
        $sql .= "," .$this->db->escape( trim( $vCampo7_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo8_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo9_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo10_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo11_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo12_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo13_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo14_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo15_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo16_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo17_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo18_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo19_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo20_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo21_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo22_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo23_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo24_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo25_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo26_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo27_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo28_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo29_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo30_comandos ) );
        $sql .= ", @last_id";
        $sql .= ");";

        $this->db->query($sql);

        $last_id= (array) $this->db->query("SELECT @last_id;")->result()[0];
        $data= array("last_id"=> $this->encryption->encrypt($last_id['@last_id']));

        $error = $this->db->error();
        $this->db->close();

        $this->Debug_model->set_debug($this->id_user, "sp_set_comandos", "\n" . $sql);
        $this->db->close();

        return $error['code'] === 0 ? $this->load->response(true, $data) : $this->load->response(false, json_encode($error) );
    }

    public function set_log_comando($postData)
    {
        $id_comandos= isset($postData['id_comandos']) ? $postData['id_comandos'] : ""; 
        $sql  = "CALL sp_set_log_comando(";
        $sql .=      $this->id_user;
        $sql .= "," .$id_comandos;
        $sql .= ", @last_id";
        $sql .= ");";

        $this->db->query($sql);

        $last_id= (array) $this->db->query("SELECT @last_id;")->result()[0];
        $data= array("last_id"=> $this->encryption->encrypt($last_id['@last_id']));

        $error = $this->db->error();
        $this->db->close();

        $this->Debug_model->set_debug($this->id_user, "sp_set_log_comando", "\n" . $sql);
        $this->db->close();
        
        return $error['code'] === 0 ? $this->load->response(true, $data) : $this->load->response(false, json_encode($error) );
    }

    public function set_update_comandos($postData)
    {
        $postData["id_comandos"]= $postData["id_comandos"];

        if (empty($postData["id_comandos"]))
            return $this->load->response(false, array("vc_message" => "El id_comandos es altamente requerido ") );

        if (!is_numeric($postData["id_comandos"]))
            return $this->load->response(false, array("vc_message" => "Se espera un valor numérico en: id_comandos ") );

        $vc_atajo_teclado= isset($postData['vc_atajo_teclado']) ? $postData['vc_atajo_teclado'] : ""; 
        $vc_comando= isset($postData['vc_comando']) ? $postData['vc_comando'] : ""; 
        $vc_descripcion= isset($postData['vc_descripcion']) ? $postData['vc_descripcion'] : ""; 
        $vc_path_script= isset($postData['vc_path_script']) ? $postData['vc_path_script'] : ""; 
        $vc_comentario= isset($postData['vc_comentario']) ? $postData['vc_comentario'] : ""; 
        $vCampo7_comandos= isset($postData['vCampo7_comandos']) ? $postData['vCampo7_comandos'] : ""; 
        $vCampo8_comandos= isset($postData['vCampo8_comandos']) ? $postData['vCampo8_comandos'] : ""; 
        $vCampo9_comandos= isset($postData['vCampo9_comandos']) ? $postData['vCampo9_comandos'] : ""; 
        $vCampo10_comandos= isset($postData['vCampo10_comandos']) ? $postData['vCampo10_comandos'] : ""; 
        $vCampo11_comandos= isset($postData['vCampo11_comandos']) ? $postData['vCampo11_comandos'] : ""; 
        $vCampo12_comandos= isset($postData['vCampo12_comandos']) ? $postData['vCampo12_comandos'] : ""; 
        $vCampo13_comandos= isset($postData['vCampo13_comandos']) ? $postData['vCampo13_comandos'] : ""; 
        $vCampo14_comandos= isset($postData['vCampo14_comandos']) ? $postData['vCampo14_comandos'] : ""; 
        $vCampo15_comandos= isset($postData['vCampo15_comandos']) ? $postData['vCampo15_comandos'] : ""; 
        $vCampo16_comandos= isset($postData['vCampo16_comandos']) ? $postData['vCampo16_comandos'] : ""; 
        $vCampo17_comandos= isset($postData['vCampo17_comandos']) ? $postData['vCampo17_comandos'] : ""; 
        $vCampo18_comandos= isset($postData['vCampo18_comandos']) ? $postData['vCampo18_comandos'] : ""; 
        $vCampo19_comandos= isset($postData['vCampo19_comandos']) ? $postData['vCampo19_comandos'] : ""; 
        $vCampo20_comandos= isset($postData['vCampo20_comandos']) ? $postData['vCampo20_comandos'] : ""; 
        $vCampo21_comandos= isset($postData['vCampo21_comandos']) ? $postData['vCampo21_comandos'] : ""; 
        $vCampo22_comandos= isset($postData['vCampo22_comandos']) ? $postData['vCampo22_comandos'] : ""; 
        $vCampo23_comandos= isset($postData['vCampo23_comandos']) ? $postData['vCampo23_comandos'] : ""; 
        $vCampo24_comandos= isset($postData['vCampo24_comandos']) ? $postData['vCampo24_comandos'] : ""; 
        $vCampo25_comandos= isset($postData['vCampo25_comandos']) ? $postData['vCampo25_comandos'] : ""; 
        $vCampo26_comandos= isset($postData['vCampo26_comandos']) ? $postData['vCampo26_comandos'] : ""; 
        $vCampo27_comandos= isset($postData['vCampo27_comandos']) ? $postData['vCampo27_comandos'] : ""; 
        $vCampo28_comandos= isset($postData['vCampo28_comandos']) ? $postData['vCampo28_comandos'] : ""; 
        $vCampo29_comandos= isset($postData['vCampo29_comandos']) ? $postData['vCampo29_comandos'] : ""; 
        $vCampo30_comandos= isset($postData['vCampo30_comandos']) ? $postData['vCampo30_comandos'] : ""; 

        $sql  = "CALL sp_set_update_comandos(";
        $sql .=      $this->db->escape( $postData["id_comandos"] );
        $sql .= "," .$this->db->escape( trim( $vc_atajo_teclado ) );
        $sql .= "," .$this->db->escape( trim( $vc_comando ) );
        $sql .= "," .$this->db->escape( trim( $vc_descripcion ) );
        $sql .= "," .$this->db->escape( trim( $vc_path_script ) );
        $sql .= "," .$this->db->escape( trim( $vc_comentario ) );
        $sql .= "," .$this->db->escape( trim( $vCampo7_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo8_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo9_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo10_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo11_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo12_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo13_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo14_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo15_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo16_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo17_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo18_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo19_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo20_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo21_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo22_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo23_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo24_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo25_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo26_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo27_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo28_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo29_comandos ) );
        $sql .= "," .$this->db->escape( trim( $vCampo30_comandos ) );
        $sql .= ", @i_internal_status";
        $sql .= ");";

        $this->db->query($sql);
        $i_internal_status= (array) $this->db->query("SELECT @i_internal_status;")->result()[0];
        $data= array("id_user"=> $this->encryption->encrypt($i_internal_status['@i_internal_status']));
        $this->db->close();

        $error = $this->db->error();
        $this->db->close();

        $this->Debug_model->set_debug($this->id_user, "sp_set_update_comandos", "\n" . $sql);
        $this->db->close();
        
        return $error['code'] === 0 ? $this->load->response(true, $data) : $this->load->response(false, json_encode($error) );
    }

    public function delete_comandos($id_comandos)
    {
        $sql  = "CALL sp_delete_comandos(";
        $sql .= intval( $id_comandos );
        $sql .= ", @i_internal_status";
        $sql .= ");";

        $this->db->query($sql);
        $query = $this->db->query("SELECT @i_internal_status");
        $data= $query->result()[0];
        
        $this->db->close();
        
        $this->Debug_model->set_debug($this->id_user, "sp_delete_comandos", $sql);

        return $this->load->response(true, $data);
    }

    public function undo_delete_comandos($id_comandos)
    {
        $sql  = "CALL sp_undo_delete_comandos(";
        $sql .= intval($id_comandos );
        $sql .= ", @i_internal_status";
        $sql .= ");";

        $this->db->query($sql);
        $query = $this->db->query("SELECT @i_internal_status");
        $data= $query->result()[0];
        $this->db->close();
        
        $this->Debug_model->set_debug($this->id_user, "sp_undo_delete_comandos", $sql);

        return $this->load->response(true, $data);
    }

}

?>
