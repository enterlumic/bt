<?php

 class Notas_model extends CI_Model {

    private $id_user;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Debug_model');        
        $this->load->library('session');
        $this->load->library('encryption');
        $this->encryption->initialize( array( 'cipher' => 'aes-256', 'mode' => 'ctr', 'key' => '<a 32-character random string>') );
        $this->load->database();
        $this->id_user= isset($this->session->userdata['id_user']) ? $this->session->userdata['id_user']: 0;
    }

    public function get_notas_by_id($postData)
    {
        if (empty($postData["id_notas"]))
            return $this->load->response(false, array("vc_message" => "El id_notas es altamente requerido ") );

        if (!is_numeric($postData["id_notas"]))
            return $this->load->response(false, array("vc_message" => "Se espera un valor numérico en: id_notas ") );

        $sql= "CALL sp_get_notas_by_id(".intval($postData["id_notas"]).");";
        $query = $this->db->query($sql);
        $error = $this->db->error();

        if ($error['code'] === 0 && is_object($query->result_id))
        {
            foreach ($query->result() as $key => $value) 
            {
                $data= array(  "id"             => $value->id
                              ,"id_user"        => $value->id_user
                              ,"vc_nombre"      => $value->vc_nombre
                              ,"vc_atajo"       => $value->vc_atajo
                              ,"vc_descripcion" => $value->vc_descripcion
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

    public function get_notas_by_datatable($postData) 
    {
        $sql  = "CALL sp_get_notas(";
        $sql .=      $this->db->escape(isset($postData['search']['value']) && !empty($postData['search']['value']) ? true:false);
        $sql .= "," .$this->db->escape($postData['search']['value']);
        $sql .= "," .$this->db->escape($postData['start']);
        $sql .= "," .$this->db->escape($postData['length']);
        $sql .= "," .$this->db->escape($postData["order"][0]["column"]);
        $sql .= "," .$this->db->escape($postData["order"][0]["dir"]);
        $sql .=")";

        $this->Debug_model->set_debug($this->id_user, "sp_get_notas", "\n" . $sql);
        $this->db->close();

        $query= $this->db->query($sql);
        $error= $this->db->error();
        $this->db->close();

        if ($error['code'] === 0 && is_object($query->result_id) && is_array($query->result()) && !empty($query->result()))
        {

            foreach ($query->result() as $key => $value) 
            {
                $data[]= array( $value->id
                              , $value->id_user
                              , $value->vc_nombre
                              , $value->vc_atajo
                              , $value->vc_descripcion
                              , $value->id
                );
            }

            $totalRecords="SELECT COUNT(*) AS TOTAL FROM tbl_notas WHERE b_status > 0";
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

    public function set_notas($postData)
    {

        $id_user= isset($postData['id_user']) ? $postData['id_user'] : ""; 
        $vc_nombre= isset($postData['vc_nombre']) ? $postData['vc_nombre'] : ""; 
        $vc_atajo= isset($postData['vc_atajo']) ? $postData['vc_atajo'] : ""; 
        $vc_descripcion= isset($postData['vc_descripcion']) ? $postData['vc_descripcion'] : ""; 

        $sql  = "CALL sp_set_notas(";
        $sql .=      $this->db->escape( intval( $id_user ) );
        $sql .= "," .$this->db->escape( trim( $vc_nombre ) );
        $sql .= "," .$this->db->escape( trim( $vc_atajo ) );
        $sql .= "," .$this->db->escape( trim( $vc_descripcion ) );
        $sql .= ", @last_id";
        $sql .= ");";

        $this->db->query($sql);

        $last_id= (array) $this->db->query("SELECT @last_id;")->result()[0];
        $data= array("id_user"=> $this->encryption->encrypt($last_id['@last_id']));

        $error = $this->db->error();
        $this->db->close();

        $this->Debug_model->set_debug($this->id_user, "sp_set_notas", "\n" . $sql);
        $this->db->close();

        return $error['code'] === 0 ? $this->load->response(true, $data) : $this->load->response(false, json_encode($error) );
    }

    public function set_update_notas($postData)
    {
        if (empty($postData["id_notas"]))
            return $this->load->response(false, array("vc_message" => "El id_notas es altamente requerido ") );

        if (!is_numeric($postData["id_notas"]))
            return $this->load->response(false, array("vc_message" => "Se espera un valor numérico en: id_notas ") );

        $id_user= isset($postData['id_user']) ? $postData['id_user'] : ""; 
        $vc_nombre= isset($postData['vc_nombre']) ? $postData['vc_nombre'] : ""; 
        $vc_atajo= isset($postData['vc_atajo']) ? $postData['vc_atajo'] : ""; 
        $vc_descripcion= isset($postData['vc_descripcion']) ? $postData['vc_descripcion'] : ""; 

        $sql  = "CALL sp_set_update_notas(";
        $sql .=      $this->db->escape($postData["id_notas"]);
        $sql .= "," .$this->db->escape( trim( $id_user ) );
        $sql .= "," .$this->db->escape( trim( $vc_nombre ) );
        $sql .= "," .$this->db->escape( trim( $vc_atajo ) );
        $sql .= "," .$this->db->escape( trim( $vc_descripcion ) );
        $sql .= ", @i_internal_status";
        $sql .= ");";

        $this->db->query($sql);
        $i_internal_status= (array) $this->db->query("SELECT @i_internal_status;")->result()[0];
        $data= array("id_user"=> $this->encryption->encrypt($i_internal_status['@i_internal_status']));
        $this->db->close();

        $error = $this->db->error();
        $this->db->close();

        $this->Debug_model->set_debug($this->id_user, "sp_set_update_notas", "\n" . $sql);
        $this->db->close();

        return $error['code'] === 0 ? $this->load->response(true, $data) : $this->load->response(false, json_encode($error) );
    }

    public function delete_notas($id_notas)
    {
        $sql  = "CALL sp_delete_notas(";
        $sql .= intval($id_notas );
        $sql .= ", @i_internal_status";
        $sql .= ");";

        $this->db->query($sql);
        $query = $this->db->query("SELECT @i_internal_status");
        $data= $query->result()[0];
        
        $this->db->close();
        
        $this->Debug_model->set_debug($this->id_user, "sp_delete_notas", $sql);

        return $this->load->response(true, $data);
    }

    public function undo_delete_notas($id_notas)
    {
        $sql  = "CALL sp_undo_delete_notas(";
        $sql .= intval($id_notas );
        $sql .= ", @i_internal_status";
        $sql .= ");";

        $this->db->query($sql);
        $query = $this->db->query("SELECT @i_internal_status");
        $data= $query->result()[0];
        $this->db->close();

        $this->Debug_model->set_debug($this->id_user, "sp_undo_delete_notas", $sql);

        return $this->load->response(true, $data);
    }
}

?>
