<?php

 class Console_model extends CI_Model {

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

    public function get_console_by_id($postData)
    {
        if (empty($postData["id_console"]))
            return $this->load->response(false, array("vc_message" => "El id_console es altamente requerido ") );

        if (!is_numeric($postData["id_console"]))
            return $this->load->response(false, array("vc_message" => "Se espera un valor numérico en: id_console ") );

        $sql= "CALL sp_get_console_by_id(".intval($postData["id_console"]).");";
        $query = $this->db->query($sql);
        $error = $this->db->error();

        if ($error['code'] === 0 && is_object($query->result_id))
        {
            foreach ($query->result() as $key => $value) 
            {
                $data= array("id"=> $value->id
                              ,"vCampo1_console" => $value->vCampo1_console
                              ,"vCampo2_console" => $value->vCampo2_console
                              ,"vCampo3_console" => $value->vCampo3_console
                              ,"vCampo4_console" => $value->vCampo4_console
                              ,"vCampo5_console" => $value->vCampo5_console
                              ,"vCampo6_console" => $value->vCampo6_console
                              ,"vCampo7_console" => $value->vCampo7_console
                              ,"vCampo8_console" => $value->vCampo8_console
                              ,"vCampo9_console" => $value->vCampo9_console
                              ,"vCampo10_console" => $value->vCampo10_console
                              ,"vCampo11_console" => $value->vCampo11_console
                              ,"vCampo12_console" => $value->vCampo12_console
                              ,"vCampo13_console" => $value->vCampo13_console
                              ,"vCampo14_console" => $value->vCampo14_console
                              ,"vCampo15_console" => $value->vCampo15_console
                              ,"vCampo16_console" => $value->vCampo16_console
                              ,"vCampo17_console" => $value->vCampo17_console
                              ,"vCampo18_console" => $value->vCampo18_console
                              ,"vCampo19_console" => $value->vCampo19_console
                              ,"vCampo20_console" => $value->vCampo20_console
                              ,"vCampo21_console" => $value->vCampo21_console
                              ,"vCampo22_console" => $value->vCampo22_console
                              ,"vCampo23_console" => $value->vCampo23_console
                              ,"vCampo24_console" => $value->vCampo24_console
                              ,"vCampo25_console" => $value->vCampo25_console
                              ,"vCampo26_console" => $value->vCampo26_console
                              ,"vCampo27_console" => $value->vCampo27_console
                              ,"vCampo28_console" => $value->vCampo28_console
                              ,"vCampo29_console" => $value->vCampo29_console
                              ,"vCampo30_console" => $value->vCampo30_console
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

    public function get_console_by_datatable($postData) 
    {
        $sql  = "CALL sp_get_console(";
        $sql .=      $this->db->escape(isset($postData['search']['value']) && !empty($postData['search']['value']) ? true:false);
        $sql .= "," .$this->db->escape($postData['search']['value']);
        $sql .= "," .$this->db->escape($postData['start']);
        $sql .= "," .$this->db->escape($postData['length']);
        $sql .= "," .$this->db->escape($postData["order"][0]["column"]);
        $sql .= "," .$this->db->escape($postData["order"][0]["dir"]);
        $sql .=")";

        $query=$this->db->query($sql);     
        $error = $this->db->error();
        $this->db->close();

        if ($error['code'] === 0 && is_object($query->result_id) && is_array($query->result()) && !empty($query->result()))
        {

            foreach ($query->result() as $key => $value) 
            {
                $data[]= array( $value->id
                              , $value->vCampo1_console
                              , $value->vCampo2_console
                              , $value->vCampo3_console
                              , $value->vCampo4_console
                              , $value->vCampo5_console
                              , $value->id
                );       
            }

            $totalRecords="SELECT COUNT(*) AS TOTAL FROM tbl_console WHERE b_status > 0";
            $totalRecords= $this->db->query($totalRecords)->result();
            $totalRecords= $totalRecords[0]->TOTAL <= 0 ? 1 : $totalRecords[0]->TOTAL;

            $this->db->close();

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

    public function set_console($postData)
    {

        $vCampo1_console= isset($postData['vCampo1_console']) ? $postData['vCampo1_console'] : ""; 
        $vCampo2_console= isset($postData['vCampo2_console']) ? $postData['vCampo2_console'] : ""; 
        $vCampo3_console= isset($postData['vCampo3_console']) ? $postData['vCampo3_console'] : ""; 
        $vCampo4_console= isset($postData['vCampo4_console']) ? $postData['vCampo4_console'] : ""; 
        $vCampo5_console= isset($postData['vCampo5_console']) ? $postData['vCampo5_console'] : ""; 
        $vCampo6_console= isset($postData['vCampo6_console']) ? $postData['vCampo6_console'] : ""; 
        $vCampo7_console= isset($postData['vCampo7_console']) ? $postData['vCampo7_console'] : ""; 
        $vCampo8_console= isset($postData['vCampo8_console']) ? $postData['vCampo8_console'] : ""; 
        $vCampo9_console= isset($postData['vCampo9_console']) ? $postData['vCampo9_console'] : ""; 
        $vCampo10_console= isset($postData['vCampo10_console']) ? $postData['vCampo10_console'] : ""; 
        $vCampo11_console= isset($postData['vCampo11_console']) ? $postData['vCampo11_console'] : ""; 
        $vCampo12_console= isset($postData['vCampo12_console']) ? $postData['vCampo12_console'] : ""; 
        $vCampo13_console= isset($postData['vCampo13_console']) ? $postData['vCampo13_console'] : ""; 
        $vCampo14_console= isset($postData['vCampo14_console']) ? $postData['vCampo14_console'] : ""; 
        $vCampo15_console= isset($postData['vCampo15_console']) ? $postData['vCampo15_console'] : ""; 
        $vCampo16_console= isset($postData['vCampo16_console']) ? $postData['vCampo16_console'] : ""; 
        $vCampo17_console= isset($postData['vCampo17_console']) ? $postData['vCampo17_console'] : ""; 
        $vCampo18_console= isset($postData['vCampo18_console']) ? $postData['vCampo18_console'] : ""; 
        $vCampo19_console= isset($postData['vCampo19_console']) ? $postData['vCampo19_console'] : ""; 
        $vCampo20_console= isset($postData['vCampo20_console']) ? $postData['vCampo20_console'] : ""; 
        $vCampo21_console= isset($postData['vCampo21_console']) ? $postData['vCampo21_console'] : ""; 
        $vCampo22_console= isset($postData['vCampo22_console']) ? $postData['vCampo22_console'] : ""; 
        $vCampo23_console= isset($postData['vCampo23_console']) ? $postData['vCampo23_console'] : ""; 
        $vCampo24_console= isset($postData['vCampo24_console']) ? $postData['vCampo24_console'] : ""; 
        $vCampo25_console= isset($postData['vCampo25_console']) ? $postData['vCampo25_console'] : ""; 
        $vCampo26_console= isset($postData['vCampo26_console']) ? $postData['vCampo26_console'] : ""; 
        $vCampo27_console= isset($postData['vCampo27_console']) ? $postData['vCampo27_console'] : ""; 
        $vCampo28_console= isset($postData['vCampo28_console']) ? $postData['vCampo28_console'] : ""; 
        $vCampo29_console= isset($postData['vCampo29_console']) ? $postData['vCampo29_console'] : ""; 
        $vCampo30_console= isset($postData['vCampo30_console']) ? $postData['vCampo30_console'] : ""; 

        $sql  = "CALL sp_set_console(";
        $sql .=      $this->db->escape( trim( $vCampo1_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo2_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo3_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo4_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo5_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo6_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo7_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo8_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo9_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo10_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo11_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo12_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo13_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo14_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo15_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo16_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo17_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo18_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo19_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo20_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo21_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo22_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo23_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo24_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo25_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo26_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo27_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo28_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo29_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo30_console ) );
        $sql .= ", @last_id";
        $sql .= ");";

        $this->db->query($sql);

        $last_id= (array) $this->db->query("SELECT @last_id;")->result()[0];
        $data= array("id_user"=> $this->encryption->encrypt($last_id['@last_id']));

        $error = $this->db->error();
        $this->db->close();

        $this->Debug_model->set_debug($this->id_user, "sp_set_console", "\n" . $sql);
        $this->db->close();

        return $error['code'] === 0 ? $this->load->response(true, $data) : $this->load->response(false, json_encode($error) );
    }

    public function set_update_console($postData)
    {

        if (empty($postData["id_console"]))
            return $this->load->response(false, array("vc_message" => "El id_console es altamente requerido ") );

        if (!is_numeric($postData["id_console"]))
            return $this->load->response(false, array("vc_message" => "Se espera un valor numérico en: id_console ") );

        $vCampo1_console= isset($postData['vCampo1_console']) ? $postData['vCampo1_console'] : ""; 
        $vCampo2_console= isset($postData['vCampo2_console']) ? $postData['vCampo2_console'] : ""; 
        $vCampo3_console= isset($postData['vCampo3_console']) ? $postData['vCampo3_console'] : ""; 
        $vCampo4_console= isset($postData['vCampo4_console']) ? $postData['vCampo4_console'] : ""; 
        $vCampo5_console= isset($postData['vCampo5_console']) ? $postData['vCampo5_console'] : ""; 
        $vCampo6_console= isset($postData['vCampo6_console']) ? $postData['vCampo6_console'] : ""; 
        $vCampo7_console= isset($postData['vCampo7_console']) ? $postData['vCampo7_console'] : ""; 
        $vCampo8_console= isset($postData['vCampo8_console']) ? $postData['vCampo8_console'] : ""; 
        $vCampo9_console= isset($postData['vCampo9_console']) ? $postData['vCampo9_console'] : ""; 
        $vCampo10_console= isset($postData['vCampo10_console']) ? $postData['vCampo10_console'] : ""; 
        $vCampo11_console= isset($postData['vCampo11_console']) ? $postData['vCampo11_console'] : ""; 
        $vCampo12_console= isset($postData['vCampo12_console']) ? $postData['vCampo12_console'] : ""; 
        $vCampo13_console= isset($postData['vCampo13_console']) ? $postData['vCampo13_console'] : ""; 
        $vCampo14_console= isset($postData['vCampo14_console']) ? $postData['vCampo14_console'] : ""; 
        $vCampo15_console= isset($postData['vCampo15_console']) ? $postData['vCampo15_console'] : ""; 
        $vCampo16_console= isset($postData['vCampo16_console']) ? $postData['vCampo16_console'] : ""; 
        $vCampo17_console= isset($postData['vCampo17_console']) ? $postData['vCampo17_console'] : ""; 
        $vCampo18_console= isset($postData['vCampo18_console']) ? $postData['vCampo18_console'] : ""; 
        $vCampo19_console= isset($postData['vCampo19_console']) ? $postData['vCampo19_console'] : ""; 
        $vCampo20_console= isset($postData['vCampo20_console']) ? $postData['vCampo20_console'] : ""; 
        $vCampo21_console= isset($postData['vCampo21_console']) ? $postData['vCampo21_console'] : ""; 
        $vCampo22_console= isset($postData['vCampo22_console']) ? $postData['vCampo22_console'] : ""; 
        $vCampo23_console= isset($postData['vCampo23_console']) ? $postData['vCampo23_console'] : ""; 
        $vCampo24_console= isset($postData['vCampo24_console']) ? $postData['vCampo24_console'] : ""; 
        $vCampo25_console= isset($postData['vCampo25_console']) ? $postData['vCampo25_console'] : ""; 
        $vCampo26_console= isset($postData['vCampo26_console']) ? $postData['vCampo26_console'] : ""; 
        $vCampo27_console= isset($postData['vCampo27_console']) ? $postData['vCampo27_console'] : ""; 
        $vCampo28_console= isset($postData['vCampo28_console']) ? $postData['vCampo28_console'] : ""; 
        $vCampo29_console= isset($postData['vCampo29_console']) ? $postData['vCampo29_console'] : ""; 
        $vCampo30_console= isset($postData['vCampo30_console']) ? $postData['vCampo30_console'] : ""; 

        $sql  = "CALL sp_set_update_console(";
        $sql .=      $this->db->escape($postData["id_console"]);
        $sql .= "," .$this->db->escape( trim( $vCampo1_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo2_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo3_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo4_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo5_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo6_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo7_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo8_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo9_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo10_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo11_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo12_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo13_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo14_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo15_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo16_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo17_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo18_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo19_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo20_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo21_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo22_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo23_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo24_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo25_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo26_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo27_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo28_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo29_console ) );
        $sql .= "," .$this->db->escape( trim( $vCampo30_console ) );
        $sql .= ", @i_internal_status";
        $sql .= ");";

        $this->db->query($sql);
        $i_internal_status= (array) $this->db->query("SELECT @i_internal_status;")->result()[0];
        $data= array("id_user"=> $this->encryption->encrypt($i_internal_status['@i_internal_status']));
        $this->db->close();

        $error = $this->db->error();
        $this->db->close();

        $this->Debug_model->set_debug($this->id_user, "sp_set_update_console", "\n" . $sql);
        $this->db->close();
        
        return $error['code'] === 0 ? $this->load->response(true, $data) : $this->load->response(false, json_encode($error) );
    }

    public function delete_console($id_console)
    {
        $sql  = "CALL sp_delete_console(";
        $sql .= intval($id_console );
        $sql .= ", @i_internal_status";
        $sql .= ");";

        $this->db->query($sql);
        $query = $this->db->query("SELECT @i_internal_status");
        $data= $query->result()[0];
        
        $this->db->close();
        
        $this->Debug_model->set_debug($this->id_user, "sp_delete_console", $sql);

        return $this->load->response(true, $data);
    }

    public function undo_delete_console($id_console)
    {

        $sql  = "CALL sp_undo_delete_console(";
        $sql .= intval($id_console );
        $sql .= ", @i_internal_status";
        $sql .= ");";

        $this->db->query($sql);
        $query = $this->db->query("SELECT @i_internal_status");
        $data= $query->result()[0];
        $this->db->close();
        
        $this->Debug_model->set_debug($this->id_user, "sp_undo_delete_console", $sql);

        return $this->load->response(true, $data);
    }

}

?>
