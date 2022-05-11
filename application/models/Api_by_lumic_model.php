<?php

 class Api_by_lumic_model extends CI_Model {
    private $id_user;

    public function __construct(){ 
		parent::__construct(); 
        $this->load->model('Debug_model');
        $this->id_user= isset($this->session->userdata['id_user'])? $this->session->userdata['id_user']: 0;
		$this->load->database();
    }
  
    public function get_api_by_lumic() {
        $data = $this->db->query("CALL sp_get_api_by_lumic(0,100000000);");
        return json_encode($data->result());
    }


    public function api_by_id($postData)
    {
        if (empty($postData["id"]))
            return $this->load->response(false, array("vc_message" => "El id es altamente requerido ") );

        if (!is_numeric($postData["id"]))
            return $this->load->response(false, array("vc_message" => "Se espera un valor numérico en: id ") );

        $sql= "CALL sp_get_api_by_id(".$postData["id"].");";
        $query = $this->db->query($sql);
        $error = $this->db->error();

        if ($error['code'] === 0 && is_object($query->result_id))
        {
            return $query->result()[0]->vc_name;
        }
        else
        {
            return $this->load->response(false, json_encode($error) );
        }
    }

    public function set_api_by_lumic($postData){

        $proyecto= str_replace("../", "", $postData['proyecto']);
        $sql  = "CALL sp_set_api_by_lumic(";
        $sql .=      $this->db->escape( trim( $proyecto ) );
        $sql .= "," .$this->db->escape( trim( $postData['name_strtolower'] ) );
        $sql .= "," .$this->db->escape( trim( $postData['rehacer_bd'] ) );
        $sql .= ",  @i_internal_status";
        $sql .= ");";

        file_put_contents("lanyz", $sql);

        $this->db->query($sql);
        $this->Debug_model->set_debug($this->id_user, "sp_set_api_by_lumic", "\n" . $sql);
        $this->db->close();        

        $query = $this->db->query("SELECT @i_internal_status");
        $data= $query->result()[0];
        
        return $this->load->response(true, $data);
    }

    public function delete_api_by_lumic($id)
    {
        $sql  = "CALL sp_delete_api_by_lumic(";
        $sql .= intval($id);
        $sql .= ", @i_internal_status";
        $sql .= ");";

        $this->db->query($sql);

        $i_internal_status= (array) $this->db->query("SELECT @i_internal_status")->result()[0];

        return $this->load->response(true, $i_internal_status);
    }

    public function reset_api()
    {
        $this->db->truncate('tbl_api');
    }

    public function undo_delete_api_by_lumic($id)
    {

        $sql  = "CALL sp_undo_delete_api_by_lumic(";
        $sql .= intval($id);
        $sql .= ", @i_internal_status";
        $sql .= ");";

        $this->db->query($sql);

        $i_internal_status= (array) $this->db->query("SELECT @i_internal_status")->result()[0];

        return $this->load->response(true, $i_internal_status);
    }
    
    public function set_update_api_by_lumic($param)
    {
        $sql  = "CALL sp_set_update_api_by_lumic(";
        $sql .= intval( $param["id"] );
        $sql .= "," .$this->db->escape( trim( $param['vc_description_update'] ) );
        $sql .= ", @i_internal_status";
        $sql .= ");";

        $this->db->query($sql);
        $i_internal_status= (array) $this->db->query("SELECT @i_internal_status")->result()[0];
        return $this->load->response(true, $i_internal_status);
    }

    public function guardar_ssh ($param){

        $fileName= isset($postData['fileName']) ? $postData['fileName'] : ""; 
        $textSSH= isset($postData['textSSH']) ? $postData['textSSH'] : ""; 

        $sql  = "CALL sp_set_update_datos_de_contacto_pf(";
        $sql .=      $this->db->escape( trim( $fileName ) );
        $sql .= "," .$this->db->escape( trim( $textSSH ) );
        $sql .= ", @i_internal_status";
        $sql .= ");";

        $this->db->query($sql);
        $i_internal_status= (array) $this->db->query("SELECT @i_internal_status;")->result()[0];
        $data= array("i_internal_status"=> $this->encryption->encrypt($i_internal_status['@i_internal_status']));
        $this->db->close();

        $error = $this->db->error();
        $this->db->close();

        return $error['code'] === 0 ? $this->load->response(true, $data) : $this->load->response(false, json_encode($error) );
    }

} 

?>
