<?php

 class Configuraciones_model extends CI_Model {

    private $id_user;

    public function __construct(){
        parent::__construct();
        $this->load->model('Debug_model');        
        $this->load->library('session');
        $this->load->library('encryption');
        $this->encryption->initialize( array( 'cipher' => 'aes-256', 'mode' => 'ctr', 'key' => '<a 32-character random string>') );
        $this->load->database();
        $this->id_user= isset($this->session->userdata['id_user'])? $this->session->userdata['id_user']: 0;
    }

    public function get_configuraciones()
    {
        $sql= "CALL sp_get_configuraciones();";
        $query = $this->db->query($sql);
        $error = $this->db->error();

        if ($error['code'] === 0 && is_object($query->result_id))
        {
            foreach ($query->result() as $key => $value) 
            {
                $data= array(  "vc_background_color" => $value->vc_background_color
                              ,"vc_layouts" => $value->vc_layouts
                              ,"vc_RTL" => $value->vc_RTL
                              ,"b_Sidebar_Fixed" => $value->b_Sidebar_Fixed
                              ,"b_Header_Fixed" => $value->b_Header_Fixed
                              ,"b_Box_Layouts" => $value->b_Box_Layouts
                              ,"b_Breadcumb_sticky" => $value->b_Breadcumb_sticky
                              ,"id_user" => $value->id_user
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

    public function get_configuraciones_by_datatable($postData) 
    {
        $sql  = "CALL sp_get_configuraciones(";
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
                              , $value->vc_background_color
                              , $value->vc_layouts
                              , $value->vc_RTL
                              , $value->b_Sidebar_Fixed
                              , $value->b_Header_Fixed
                              , $value->id
                );       
            }

            $totalRecords="SELECT COUNT(*) AS TOTAL FROM tbl_configuraciones WHERE b_status > 0";
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

    public function set_configuraciones($postData)
    {
        $vc_background_color= isset($postData['vc_background_color']) ? $postData['vc_background_color'] : ""; 
        $vc_layouts= isset($postData['vc_layouts']) ? $postData['vc_layouts'] : ""; 
        $vc_RTL= isset($postData['vc_RTL']) ? $postData['vc_RTL'] : ""; 
        $b_Sidebar_Fixed= isset($postData['b_Sidebar_Fixed']) ? $postData['b_Sidebar_Fixed'] : ""; 
        $b_Header_Fixed= isset($postData['b_Header_Fixed']) ? $postData['b_Header_Fixed'] : ""; 
        $b_Box_Layouts= isset($postData['b_Box_Layouts']) ? $postData['b_Box_Layouts'] : ""; 
        $b_Breadcumb_sticky= isset($postData['b_Breadcumb_sticky']) ? $postData['b_Breadcumb_sticky'] : ""; 
        $id_user= isset($postData['id_user']) ? $postData['id_user'] : ""; 
        $vc_titulo_tema= isset($postData['vc_titulo_tema']) ? $postData['vc_titulo_tema'] : ""; 
        $vCampo10_configuraciones= isset($postData['vCampo10_configuraciones']) ? $postData['vCampo10_configuraciones'] : ""; 
        $vCampo11_configuraciones= isset($postData['vCampo11_configuraciones']) ? $postData['vCampo11_configuraciones'] : ""; 
        $vCampo12_configuraciones= isset($postData['vCampo12_configuraciones']) ? $postData['vCampo12_configuraciones'] : ""; 
        $vCampo13_configuraciones= isset($postData['vCampo13_configuraciones']) ? $postData['vCampo13_configuraciones'] : ""; 
        $vCampo14_configuraciones= isset($postData['vCampo14_configuraciones']) ? $postData['vCampo14_configuraciones'] : ""; 
        $vCampo15_configuraciones= isset($postData['vCampo15_configuraciones']) ? $postData['vCampo15_configuraciones'] : ""; 
        $vCampo16_configuraciones= isset($postData['vCampo16_configuraciones']) ? $postData['vCampo16_configuraciones'] : ""; 
        $vCampo17_configuraciones= isset($postData['vCampo17_configuraciones']) ? $postData['vCampo17_configuraciones'] : ""; 
        $vCampo18_configuraciones= isset($postData['vCampo18_configuraciones']) ? $postData['vCampo18_configuraciones'] : ""; 
        $vCampo19_configuraciones= isset($postData['vCampo19_configuraciones']) ? $postData['vCampo19_configuraciones'] : ""; 
        $vCampo20_configuraciones= isset($postData['vCampo20_configuraciones']) ? $postData['vCampo20_configuraciones'] : ""; 
        $vCampo21_configuraciones= isset($postData['vCampo21_configuraciones']) ? $postData['vCampo21_configuraciones'] : ""; 
        $vCampo22_configuraciones= isset($postData['vCampo22_configuraciones']) ? $postData['vCampo22_configuraciones'] : ""; 
        $vCampo23_configuraciones= isset($postData['vCampo23_configuraciones']) ? $postData['vCampo23_configuraciones'] : ""; 
        $vCampo24_configuraciones= isset($postData['vCampo24_configuraciones']) ? $postData['vCampo24_configuraciones'] : ""; 
        $vCampo25_configuraciones= isset($postData['vCampo25_configuraciones']) ? $postData['vCampo25_configuraciones'] : ""; 
        $vCampo26_configuraciones= isset($postData['vCampo26_configuraciones']) ? $postData['vCampo26_configuraciones'] : ""; 
        $vCampo27_configuraciones= isset($postData['vCampo27_configuraciones']) ? $postData['vCampo27_configuraciones'] : ""; 
        $vCampo28_configuraciones= isset($postData['vCampo28_configuraciones']) ? $postData['vCampo28_configuraciones'] : ""; 
        $vCampo29_configuraciones= isset($postData['vCampo29_configuraciones']) ? $postData['vCampo29_configuraciones'] : ""; 
        $vCampo30_configuraciones= isset($postData['vCampo30_configuraciones']) ? $postData['vCampo30_configuraciones'] : ""; 

        $sql  = "CALL sp_set_configuraciones(";
        $sql .=      $this->db->escape( trim( $vc_background_color ) );
        $sql .= "," .$this->db->escape( trim( $vc_layouts ) );
        $sql .= "," .$this->db->escape( trim( $vc_RTL ) );
        $sql .= "," .$this->db->escape( trim( $b_Sidebar_Fixed ) );
        $sql .= "," .$this->db->escape( trim( $b_Header_Fixed ) );
        $sql .= "," .$this->db->escape( trim( $b_Box_Layouts ) );
        $sql .= "," .$this->db->escape( trim( $b_Breadcumb_sticky ) );
        $sql .= "," .$this->db->escape( trim( $id_user ) );
        $sql .= "," .$this->db->escape( trim( $vc_titulo_tema ) );
        $sql .= "," .$this->db->escape( trim( $vCampo10_configuraciones ) );
        $sql .= "," .$this->db->escape( trim( $vCampo11_configuraciones ) );
        $sql .= "," .$this->db->escape( trim( $vCampo12_configuraciones ) );
        $sql .= "," .$this->db->escape( trim( $vCampo13_configuraciones ) );
        $sql .= "," .$this->db->escape( trim( $vCampo14_configuraciones ) );
        $sql .= "," .$this->db->escape( trim( $vCampo15_configuraciones ) );
        $sql .= "," .$this->db->escape( trim( $vCampo16_configuraciones ) );
        $sql .= "," .$this->db->escape( trim( $vCampo17_configuraciones ) );
        $sql .= "," .$this->db->escape( trim( $vCampo18_configuraciones ) );
        $sql .= "," .$this->db->escape( trim( $vCampo19_configuraciones ) );
        $sql .= "," .$this->db->escape( trim( $vCampo20_configuraciones ) );
        $sql .= "," .$this->db->escape( trim( $vCampo21_configuraciones ) );
        $sql .= "," .$this->db->escape( trim( $vCampo22_configuraciones ) );
        $sql .= "," .$this->db->escape( trim( $vCampo23_configuraciones ) );
        $sql .= "," .$this->db->escape( trim( $vCampo24_configuraciones ) );
        $sql .= "," .$this->db->escape( trim( $vCampo25_configuraciones ) );
        $sql .= "," .$this->db->escape( trim( $vCampo26_configuraciones ) );
        $sql .= "," .$this->db->escape( trim( $vCampo27_configuraciones ) );
        $sql .= "," .$this->db->escape( trim( $vCampo28_configuraciones ) );
        $sql .= "," .$this->db->escape( trim( $vCampo29_configuraciones ) );
        $sql .= "," .$this->db->escape( trim( $vCampo30_configuraciones ) );
        $sql .= ", @last_id";
        $sql .= ");";

        $this->db->query($sql);

        $last_id= (array) $this->db->query("SELECT @last_id;")->result()[0];
        $data= array("id_user"=> $this->encryption->encrypt($last_id['@last_id']));

        $error = $this->db->error();
        $this->db->close();

        $this->Debug_model->set_debug($this->id_user, "sp_set_configuraciones", "\n" . $sql);
        $this->db->close();

        return $error['code'] === 0 ? $this->load->response(true, $data) : $this->load->response(false, json_encode($error) );
    }

    public function set_update_configuraciones($postData)
    {
        $vc_background_color= isset($postData['vc_background_color']) ? $postData['vc_background_color'] : ""; 
        $vc_layouts= isset($postData['vc_layouts']) ? $postData['vc_layouts'] : ""; 
        $vc_RTL= isset($postData['vc_RTL']) ? $postData['vc_RTL'] : ""; 
        $b_Sidebar_Fixed= isset($postData['b_Sidebar_Fixed']) ? $postData['b_Sidebar_Fixed'] : ""; 
        $b_Header_Fixed= isset($postData['b_Header_Fixed']) ? $postData['b_Header_Fixed'] : ""; 
        $b_Box_Layouts= isset($postData['b_Box_Layouts']) ? $postData['b_Box_Layouts'] : ""; 
        $b_Breadcumb_sticky= isset($postData['b_Breadcumb_sticky']) ? $postData['b_Breadcumb_sticky'] : ""; 
        $id_user= isset($postData['id_user']) ? $postData['id_user'] : ""; 
        $vc_titulo_tema= isset($postData['vc_titulo_tema']) ? $postData['vc_titulo_tema'] : ""; 
        $vCampo10_configuraciones= isset($postData['vCampo10_configuraciones']) ? $postData['vCampo10_configuraciones'] : ""; 
        $vCampo11_configuraciones= isset($postData['vCampo11_configuraciones']) ? $postData['vCampo11_configuraciones'] : ""; 
        $vCampo12_configuraciones= isset($postData['vCampo12_configuraciones']) ? $postData['vCampo12_configuraciones'] : ""; 
        $vCampo13_configuraciones= isset($postData['vCampo13_configuraciones']) ? $postData['vCampo13_configuraciones'] : ""; 
        $vCampo14_configuraciones= isset($postData['vCampo14_configuraciones']) ? $postData['vCampo14_configuraciones'] : ""; 
        $vCampo15_configuraciones= isset($postData['vCampo15_configuraciones']) ? $postData['vCampo15_configuraciones'] : ""; 
        $vCampo16_configuraciones= isset($postData['vCampo16_configuraciones']) ? $postData['vCampo16_configuraciones'] : ""; 
        $vCampo17_configuraciones= isset($postData['vCampo17_configuraciones']) ? $postData['vCampo17_configuraciones'] : ""; 
        $vCampo18_configuraciones= isset($postData['vCampo18_configuraciones']) ? $postData['vCampo18_configuraciones'] : ""; 
        $vCampo19_configuraciones= isset($postData['vCampo19_configuraciones']) ? $postData['vCampo19_configuraciones'] : ""; 
        $vCampo20_configuraciones= isset($postData['vCampo20_configuraciones']) ? $postData['vCampo20_configuraciones'] : ""; 
        $vCampo21_configuraciones= isset($postData['vCampo21_configuraciones']) ? $postData['vCampo21_configuraciones'] : ""; 
        $vCampo22_configuraciones= isset($postData['vCampo22_configuraciones']) ? $postData['vCampo22_configuraciones'] : ""; 
        $vCampo23_configuraciones= isset($postData['vCampo23_configuraciones']) ? $postData['vCampo23_configuraciones'] : ""; 
        $vCampo24_configuraciones= isset($postData['vCampo24_configuraciones']) ? $postData['vCampo24_configuraciones'] : ""; 
        $vCampo25_configuraciones= isset($postData['vCampo25_configuraciones']) ? $postData['vCampo25_configuraciones'] : ""; 
        $vCampo26_configuraciones= isset($postData['vCampo26_configuraciones']) ? $postData['vCampo26_configuraciones'] : ""; 
        $vCampo27_configuraciones= isset($postData['vCampo27_configuraciones']) ? $postData['vCampo27_configuraciones'] : ""; 
        $vCampo28_configuraciones= isset($postData['vCampo28_configuraciones']) ? $postData['vCampo28_configuraciones'] : ""; 
        $vCampo29_configuraciones= isset($postData['vCampo29_configuraciones']) ? $postData['vCampo29_configuraciones'] : ""; 
        $vCampo30_configuraciones= isset($postData['vCampo30_configuraciones']) ? $postData['vCampo30_configuraciones'] : ""; 

        $sql  = "CALL sp_set_update_configuraciones(";
        $sql .=      $this->db->escape( trim( $vc_background_color ) );
        $sql .= "," .$this->db->escape( trim( $vc_layouts ) );
        $sql .= "," .$this->db->escape( trim( $vc_RTL ) );
        $sql .= "," .$this->db->escape( trim( $b_Sidebar_Fixed ) );
        $sql .= "," .$this->db->escape( trim( $b_Header_Fixed ) );
        $sql .= "," .$this->db->escape( trim( $b_Box_Layouts ) );
        $sql .= "," .$this->db->escape( trim( $b_Breadcumb_sticky ) );
        $sql .= "," .$this->db->escape( trim( $id_user ) );
        $sql .= "," .$this->db->escape( trim( $vc_titulo_tema ) );
        $sql .= "," .$this->db->escape( trim( $vCampo10_configuraciones ) );
        $sql .= "," .$this->db->escape( trim( $vCampo11_configuraciones ) );
        $sql .= "," .$this->db->escape( trim( $vCampo12_configuraciones ) );
        $sql .= "," .$this->db->escape( trim( $vCampo13_configuraciones ) );
        $sql .= "," .$this->db->escape( trim( $vCampo14_configuraciones ) );
        $sql .= "," .$this->db->escape( trim( $vCampo15_configuraciones ) );
        $sql .= "," .$this->db->escape( trim( $vCampo16_configuraciones ) );
        $sql .= "," .$this->db->escape( trim( $vCampo17_configuraciones ) );
        $sql .= "," .$this->db->escape( trim( $vCampo18_configuraciones ) );
        $sql .= "," .$this->db->escape( trim( $vCampo19_configuraciones ) );
        $sql .= "," .$this->db->escape( trim( $vCampo20_configuraciones ) );
        $sql .= "," .$this->db->escape( trim( $vCampo21_configuraciones ) );
        $sql .= "," .$this->db->escape( trim( $vCampo22_configuraciones ) );
        $sql .= "," .$this->db->escape( trim( $vCampo23_configuraciones ) );
        $sql .= "," .$this->db->escape( trim( $vCampo24_configuraciones ) );
        $sql .= "," .$this->db->escape( trim( $vCampo25_configuraciones ) );
        $sql .= "," .$this->db->escape( trim( $vCampo26_configuraciones ) );
        $sql .= "," .$this->db->escape( trim( $vCampo27_configuraciones ) );
        $sql .= "," .$this->db->escape( trim( $vCampo28_configuraciones ) );
        $sql .= "," .$this->db->escape( trim( $vCampo29_configuraciones ) );
        $sql .= "," .$this->db->escape( trim( $vCampo30_configuraciones ) );
        $sql .= ", @i_internal_status";
        $sql .= ");";

        $this->db->query($sql);
        $i_internal_status= (array) $this->db->query("SELECT @i_internal_status;")->result()[0];
        $data= array("id_user"=> $this->encryption->encrypt($i_internal_status['@i_internal_status']));
        $this->db->close();

        $error = $this->db->error();
        $this->db->close();

        $this->Debug_model->set_debug($this->id_user, "sp_set_update_configuraciones", "\n" . $sql);
        $this->db->close();
        
        return $error['code'] === 0 ? $this->load->response(true, $data) : $this->load->response(false, json_encode($error) );
    }

    public function delete_configuraciones($id_configuraciones)
    {
        $sql  = "CALL sp_delete_configuraciones(";
        $sql .= intval($id_configuraciones );
        $sql .= ", @i_internal_status";
        $sql .= ");";

        $this->db->query($sql);
        $query = $this->db->query("SELECT @i_internal_status");
        $data= $query->result()[0];
        
        $this->db->close();
        
        $this->Debug_model->set_debug($this->id_user, "sp_delete_configuraciones", $sql);

        return $this->load->response(true, $data);
    }

    public function undo_delete_configuraciones($id_configuraciones)
    {

        $sql  = "CALL sp_undo_delete_configuraciones(";
        $sql .= intval($id_configuraciones );
        $sql .= ", @i_internal_status";
        $sql .= ");";

        $this->db->query($sql);
        $query = $this->db->query("SELECT @i_internal_status");
        $data= $query->result()[0];
        $this->db->close();
        
        $this->Debug_model->set_debug($this->id_user, "sp_undo_delete_configuraciones", $sql);

        return $this->load->response(true, $data);
    }

}

?>
