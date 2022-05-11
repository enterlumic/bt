<?php

 class Qwe_model extends CI_Model {

    private $id_user;
    // private $db;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Debug_model');        
        $this->load->library('session');
        $this->load->library('encryption');
        $this->encryption->initialize( array( 'cipher' => 'aes-256', 'mode' => 'ctr', 'key' => '<a 32-character random string>') );
        $this->load->database();
        $this->id_user= isset($this->session->userdata['id_user'])? $this->session->userdata['id_user']: 0;
        // $this->db = $this->load->database('teiker', TRUE);
    }

    public function get_qwe_by_id($postData)
    {
        if (empty($postData["id_qwe"]))
            return $this->load->response(false, array("vc_message" => "El id_qwe es altamente requerido ") );

        if (!is_numeric($postData["id_qwe"]))
            return $this->load->response(false, array("vc_message" => "Se espera un valor numérico en: id_qwe ") );

        $sql= "CALL sp_get_qwe_by_id(".intval($postData["id_qwe"]).");";
        $query = $this->db->query($sql);
        $error = $this->db->error();

        if ($error['code'] === 0 && is_object($query->result_id))
        {
            foreach ($query->result() as $key => $value) 
            {
                $data= array("id"=> $value->id
                              ,"vCampo1_qwe" => $value->vCampo1_qwe
                              ,"vCampo2_qwe" => $value->vCampo2_qwe
                              ,"vCampo3_qwe" => $value->vCampo3_qwe
                              ,"vCampo4_qwe" => $value->vCampo4_qwe
                              ,"vCampo5_qwe" => $value->vCampo5_qwe
                              ,"vCampo6_qwe" => $value->vCampo6_qwe
                              ,"vCampo7_qwe" => $value->vCampo7_qwe
                              ,"vCampo8_qwe" => $value->vCampo8_qwe
                              ,"vCampo9_qwe" => $value->vCampo9_qwe
                              ,"vCampo10_qwe" => $value->vCampo10_qwe
                              ,"vCampo11_qwe" => $value->vCampo11_qwe
                              ,"vCampo12_qwe" => $value->vCampo12_qwe
                              ,"vCampo13_qwe" => $value->vCampo13_qwe
                              ,"vCampo14_qwe" => $value->vCampo14_qwe
                              ,"vCampo15_qwe" => $value->vCampo15_qwe
                              ,"vCampo16_qwe" => $value->vCampo16_qwe
                              ,"vCampo17_qwe" => $value->vCampo17_qwe
                              ,"vCampo18_qwe" => $value->vCampo18_qwe
                              ,"vCampo19_qwe" => $value->vCampo19_qwe
                              ,"vCampo20_qwe" => $value->vCampo20_qwe
                              ,"vCampo21_qwe" => $value->vCampo21_qwe
                              ,"vCampo22_qwe" => $value->vCampo22_qwe
                              ,"vCampo23_qwe" => $value->vCampo23_qwe
                              ,"vCampo24_qwe" => $value->vCampo24_qwe
                              ,"vCampo25_qwe" => $value->vCampo25_qwe
                              ,"vCampo26_qwe" => $value->vCampo26_qwe
                              ,"vCampo27_qwe" => $value->vCampo27_qwe
                              ,"vCampo28_qwe" => $value->vCampo28_qwe
                              ,"vCampo29_qwe" => $value->vCampo29_qwe
                              ,"vCampo30_qwe" => $value->vCampo30_qwe
                );
            }
            $this->db->close();

            return $error['code'] === 0 ? $this->load->response(true, $data) : $this->load->response(false, json_encode($error) );
        }
        else
        {
            return $this->load->response(false, json_encode($error) );
        }
    }

    public function get_qwe_by_datatable($postData) 
    {
        $sql  = "CALL sp_get_qwe(";
        $sql .=      $this->db->escape(isset($postData['search']['value']) && !empty($postData['search']['value']) ? true:false);
        $sql .= "," .$this->db->escape($postData['search']['value']);
        $sql .= "," .$this->db->escape($postData['start']);
        $sql .= "," .$this->db->escape($postData['length']);
        $sql .= "," .$this->db->escape($postData["order"][0]["column"]);
        $sql .= "," .$this->db->escape($postData["order"][0]["dir"]);
        $sql .= ",  @v_registro_total";
        $sql .=")";

        $query=$this->db->query($sql);
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
                              , $value->vCampo1_qwe
                              , $value->vCampo2_qwe
                              , $value->vCampo3_qwe
                              , $value->vCampo4_qwe
                              , $value->vCampo5_qwe
                              , $value->id
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

    public function set_qwe($postData)
    {

        $vCampo1_qwe= isset($postData['vCampo1_qwe']) ? $postData['vCampo1_qwe'] : ""; 
        $vCampo2_qwe= isset($postData['vCampo2_qwe']) ? $postData['vCampo2_qwe'] : ""; 
        $vCampo3_qwe= isset($postData['vCampo3_qwe']) ? $postData['vCampo3_qwe'] : ""; 
        $vCampo4_qwe= isset($postData['vCampo4_qwe']) ? $postData['vCampo4_qwe'] : ""; 
        $vCampo5_qwe= isset($postData['vCampo5_qwe']) ? $postData['vCampo5_qwe'] : ""; 
        $vCampo6_qwe= isset($postData['vCampo6_qwe']) ? $postData['vCampo6_qwe'] : ""; 
        $vCampo7_qwe= isset($postData['vCampo7_qwe']) ? $postData['vCampo7_qwe'] : ""; 
        $vCampo8_qwe= isset($postData['vCampo8_qwe']) ? $postData['vCampo8_qwe'] : ""; 
        $vCampo9_qwe= isset($postData['vCampo9_qwe']) ? $postData['vCampo9_qwe'] : ""; 
        $vCampo10_qwe= isset($postData['vCampo10_qwe']) ? $postData['vCampo10_qwe'] : ""; 
        $vCampo11_qwe= isset($postData['vCampo11_qwe']) ? $postData['vCampo11_qwe'] : ""; 
        $vCampo12_qwe= isset($postData['vCampo12_qwe']) ? $postData['vCampo12_qwe'] : ""; 
        $vCampo13_qwe= isset($postData['vCampo13_qwe']) ? $postData['vCampo13_qwe'] : ""; 
        $vCampo14_qwe= isset($postData['vCampo14_qwe']) ? $postData['vCampo14_qwe'] : ""; 
        $vCampo15_qwe= isset($postData['vCampo15_qwe']) ? $postData['vCampo15_qwe'] : ""; 
        $vCampo16_qwe= isset($postData['vCampo16_qwe']) ? $postData['vCampo16_qwe'] : ""; 
        $vCampo17_qwe= isset($postData['vCampo17_qwe']) ? $postData['vCampo17_qwe'] : ""; 
        $vCampo18_qwe= isset($postData['vCampo18_qwe']) ? $postData['vCampo18_qwe'] : ""; 
        $vCampo19_qwe= isset($postData['vCampo19_qwe']) ? $postData['vCampo19_qwe'] : ""; 
        $vCampo20_qwe= isset($postData['vCampo20_qwe']) ? $postData['vCampo20_qwe'] : ""; 
        $vCampo21_qwe= isset($postData['vCampo21_qwe']) ? $postData['vCampo21_qwe'] : ""; 
        $vCampo22_qwe= isset($postData['vCampo22_qwe']) ? $postData['vCampo22_qwe'] : ""; 
        $vCampo23_qwe= isset($postData['vCampo23_qwe']) ? $postData['vCampo23_qwe'] : ""; 
        $vCampo24_qwe= isset($postData['vCampo24_qwe']) ? $postData['vCampo24_qwe'] : ""; 
        $vCampo25_qwe= isset($postData['vCampo25_qwe']) ? $postData['vCampo25_qwe'] : ""; 
        $vCampo26_qwe= isset($postData['vCampo26_qwe']) ? $postData['vCampo26_qwe'] : ""; 
        $vCampo27_qwe= isset($postData['vCampo27_qwe']) ? $postData['vCampo27_qwe'] : ""; 
        $vCampo28_qwe= isset($postData['vCampo28_qwe']) ? $postData['vCampo28_qwe'] : ""; 
        $vCampo29_qwe= isset($postData['vCampo29_qwe']) ? $postData['vCampo29_qwe'] : ""; 
        $vCampo30_qwe= isset($postData['vCampo30_qwe']) ? $postData['vCampo30_qwe'] : ""; 

        $sql  = "CALL sp_set_qwe(";
        $sql .=      $this->db->escape( trim( $vCampo1_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo2_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo3_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo4_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo5_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo6_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo7_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo8_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo9_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo10_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo11_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo12_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo13_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo14_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo15_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo16_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo17_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo18_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo19_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo20_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo21_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo22_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo23_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo24_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo25_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo26_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo27_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo28_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo29_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo30_qwe ) );
        $sql .= ", @last_id";
        $sql .= ");";

        $this->db->query($sql);

        $last_id= (array) $this->db->query("SELECT @last_id;")->result()[0];
        $data= array("last_id"=> $this->encryption->encrypt($last_id['@last_id']));

        $error = $this->db->error();
        $this->db->close();

        $this->Debug_model->set_debug($this->id_user, "sp_set_qwe", "\n" . $sql);
        $this->db->close();

        return $error['code'] === 0 ? $this->load->response(true, $data) : $this->load->response(false, json_encode($error) );
    }

    public function set_update_qwe($postData)
    {

        if (empty($postData["id_qwe"]))
            return $this->load->response(false, array("vc_message" => "El id_qwe es altamente requerido ") );

        if (!is_numeric($postData["id_qwe"]))
            return $this->load->response(false, array("vc_message" => "Se espera un valor numérico en: id_qwe ") );

        $vCampo1_qwe= isset($postData['vCampo1_qwe']) ? $postData['vCampo1_qwe'] : ""; 
        $vCampo2_qwe= isset($postData['vCampo2_qwe']) ? $postData['vCampo2_qwe'] : ""; 
        $vCampo3_qwe= isset($postData['vCampo3_qwe']) ? $postData['vCampo3_qwe'] : ""; 
        $vCampo4_qwe= isset($postData['vCampo4_qwe']) ? $postData['vCampo4_qwe'] : ""; 
        $vCampo5_qwe= isset($postData['vCampo5_qwe']) ? $postData['vCampo5_qwe'] : ""; 
        $vCampo6_qwe= isset($postData['vCampo6_qwe']) ? $postData['vCampo6_qwe'] : ""; 
        $vCampo7_qwe= isset($postData['vCampo7_qwe']) ? $postData['vCampo7_qwe'] : ""; 
        $vCampo8_qwe= isset($postData['vCampo8_qwe']) ? $postData['vCampo8_qwe'] : ""; 
        $vCampo9_qwe= isset($postData['vCampo9_qwe']) ? $postData['vCampo9_qwe'] : ""; 
        $vCampo10_qwe= isset($postData['vCampo10_qwe']) ? $postData['vCampo10_qwe'] : ""; 
        $vCampo11_qwe= isset($postData['vCampo11_qwe']) ? $postData['vCampo11_qwe'] : ""; 
        $vCampo12_qwe= isset($postData['vCampo12_qwe']) ? $postData['vCampo12_qwe'] : ""; 
        $vCampo13_qwe= isset($postData['vCampo13_qwe']) ? $postData['vCampo13_qwe'] : ""; 
        $vCampo14_qwe= isset($postData['vCampo14_qwe']) ? $postData['vCampo14_qwe'] : ""; 
        $vCampo15_qwe= isset($postData['vCampo15_qwe']) ? $postData['vCampo15_qwe'] : ""; 
        $vCampo16_qwe= isset($postData['vCampo16_qwe']) ? $postData['vCampo16_qwe'] : ""; 
        $vCampo17_qwe= isset($postData['vCampo17_qwe']) ? $postData['vCampo17_qwe'] : ""; 
        $vCampo18_qwe= isset($postData['vCampo18_qwe']) ? $postData['vCampo18_qwe'] : ""; 
        $vCampo19_qwe= isset($postData['vCampo19_qwe']) ? $postData['vCampo19_qwe'] : ""; 
        $vCampo20_qwe= isset($postData['vCampo20_qwe']) ? $postData['vCampo20_qwe'] : ""; 
        $vCampo21_qwe= isset($postData['vCampo21_qwe']) ? $postData['vCampo21_qwe'] : ""; 
        $vCampo22_qwe= isset($postData['vCampo22_qwe']) ? $postData['vCampo22_qwe'] : ""; 
        $vCampo23_qwe= isset($postData['vCampo23_qwe']) ? $postData['vCampo23_qwe'] : ""; 
        $vCampo24_qwe= isset($postData['vCampo24_qwe']) ? $postData['vCampo24_qwe'] : ""; 
        $vCampo25_qwe= isset($postData['vCampo25_qwe']) ? $postData['vCampo25_qwe'] : ""; 
        $vCampo26_qwe= isset($postData['vCampo26_qwe']) ? $postData['vCampo26_qwe'] : ""; 
        $vCampo27_qwe= isset($postData['vCampo27_qwe']) ? $postData['vCampo27_qwe'] : ""; 
        $vCampo28_qwe= isset($postData['vCampo28_qwe']) ? $postData['vCampo28_qwe'] : ""; 
        $vCampo29_qwe= isset($postData['vCampo29_qwe']) ? $postData['vCampo29_qwe'] : ""; 
        $vCampo30_qwe= isset($postData['vCampo30_qwe']) ? $postData['vCampo30_qwe'] : ""; 

        $sql  = "CALL sp_set_update_qwe(";
        $sql .=      $this->db->escape($postData["id_qwe"]);
        $sql .= "," .$this->db->escape( trim( $vCampo1_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo2_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo3_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo4_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo5_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo6_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo7_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo8_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo9_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo10_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo11_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo12_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo13_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo14_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo15_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo16_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo17_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo18_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo19_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo20_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo21_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo22_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo23_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo24_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo25_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo26_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo27_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo28_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo29_qwe ) );
        $sql .= "," .$this->db->escape( trim( $vCampo30_qwe ) );
        $sql .= ", @i_internal_status";
        $sql .= ");";

        $this->db->query($sql);
        $i_internal_status= (array) $this->db->query("SELECT @i_internal_status;")->result()[0];
        $data= array("id_user"=> $this->encryption->encrypt($i_internal_status['@i_internal_status']));
        $this->db->close();

        $error = $this->db->error();
        $this->db->close();

        $this->Debug_model->set_debug($this->id_user, "sp_set_update_qwe", "\n" . $sql);
        $this->db->close();
        
        return $error['code'] === 0 ? $this->load->response(true, $data) : $this->load->response(false, json_encode($error) );
    }

    public function delete_qwe($id_qwe)
    {
        $sql  = "CALL sp_delete_qwe(";
        $sql .= intval($id_qwe );
        $sql .= ", @i_internal_status";
        $sql .= ");";

        $this->db->query($sql);
        $query = $this->db->query("SELECT @i_internal_status");
        $data= $query->result()[0];
        
        $this->db->close();
        
        $this->Debug_model->set_debug($this->id_user, "sp_delete_qwe", $sql);

        return $this->load->response(true, $data);
    }

    public function undo_delete_qwe($id_qwe)
    {

        $sql  = "CALL sp_undo_delete_qwe(";
        $sql .= intval($id_qwe );
        $sql .= ", @i_internal_status";
        $sql .= ");";

        $this->db->query($sql);
        $query = $this->db->query("SELECT @i_internal_status");
        $data= $query->result()[0];
        $this->db->close();
        
        $this->Debug_model->set_debug($this->id_user, "sp_undo_delete_qwe", $sql);

        return $this->load->response(true, $data);
    }

}

?>
