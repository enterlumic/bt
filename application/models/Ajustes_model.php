<?php

 class Ajustes_model extends CI_Model {

    private $id_user;
    private $db;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Debug_model');        
        $this->load->library('session');
        $this->load->library('encryption');
        $this->encryption->initialize( array( 'cipher' => 'aes-256', 'mode' => 'ctr', 'key' => '<a 32-character random string>') );
        $this->load->database();
        $this->id_user= isset($this->session->userdata['id_user'])? $this->session->userdata['id_user']: 0;
        $this->db = $this->load->database('teiker', TRUE);
    }

    public function get_ajustes_by_id($postData)
    {
        $postData["id"]= $this->encryption->decrypt($postData["id"]);

        if (empty($postData["id"]))
            return $this->load->response(false, array("vc_message" => "El id es altamente requerido ") );

        if (!is_numeric($postData["id"]))
            return $this->load->response(false, array("vc_message" => "Se espera un valor numérico en: id ") );

        $sql= "CALL sp_get_ajustes_by_id(".intval( $postData["id"] ).");";
        $query = $this->db->query($sql);
        $error = $this->db->error();

        if ($error['code'] === 0 && is_object($query->result_id))
        {
            foreach ($query->result() as $key => $value) 
            {
                $data= array("id"=> $this->encryption->encrypt($value->id) 
                              ,"nombre" => $value->nombre
                              ,"valor" => $value->valor
                              ,"valor_encrypt" => $value->valor_encrypt
                              ,"descripcion" => $value->descripcion
                              ,"activo" => $value->activo
                              ,"creado" => $value->creado
                              ,"creado_por" => $value->creado_por
                              ,"modificado" => $value->modificado
                              ,"modificado_por" => $value->modificado_por
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

    public function get_ajustes_by_datatable($postData) 
    {
        $sql  = "CALL sp_get_ajustes(";
        $sql .=      $this->db->escape(isset($postData['search']['value']) && !empty($postData['search']['value']) ? true:false);
        $sql .= "," .$this->db->escape($postData['search']['value']);
        $sql .= "," .$this->db->escape($postData['start']);
        $sql .= "," .$this->db->escape($postData['length']);
        $sql .= "," .$this->db->escape($postData["order"][0]["column"]);
        $sql .= "," .$this->db->escape($postData["order"][0]["dir"]);
        $sql .= ",  @v_registro_total";
        $sql .=");";

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
                $data[]= array( $this->encryption->encrypt($value->id)
                              , $value->nombre
                              , $value->valor
                              , $value->valor_encrypt
                              , $value->descripcion
                              , $value->activo
                              , $value->creado
                              , $value->creado_por
                              , $value->modificado
                              , $value->modificado_por
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

    public function set_ajustes($postData)
    {
        $nombre= isset($postData['nombre']) ? $postData['nombre'] : ""; 
        $valor= isset($postData['valor']) ? $postData['valor'] : ""; 
        $valor_encrypt= isset($postData['valor_encrypt']) ? $postData['valor_encrypt'] : ""; 
        $descripcion= isset($postData['descripcion']) ? $postData['descripcion'] : ""; 
        $activo= isset($postData['activo']) ? $postData['activo'] : ""; 
        $creado= isset($postData['creado']) ? $postData['creado'] : ""; 
        $creado_por= isset($postData['creado_por']) ? $postData['creado_por'] : ""; 
        $modificado= isset($postData['modificado']) ? $postData['modificado'] : ""; 
        $modificado_por= isset($postData['modificado_por']) ? $postData['modificado_por'] : ""; 

        $sql  = "CALL sp_set_ajustes(";
        $sql .=      $this->db->escape( trim( $nombre ) );
        $sql .= "," .$this->db->escape( trim( $valor ) );
        $sql .= "," .$this->db->escape( trim( $valor_encrypt ) );
        $sql .= "," .$this->db->escape( trim( $descripcion ) );
        $sql .= "," .$this->db->escape( trim( $activo ) );
        $sql .= "," .$this->db->escape( trim( $creado ) );
        $sql .= "," .$this->db->escape( trim( $creado_por ) );
        $sql .= "," .$this->db->escape( trim( $modificado ) );
        $sql .= "," .$this->db->escape( trim( $modificado_por ) );
        $sql .= ", @last_id";
        $sql .= ");";

        $this->db->query($sql);

        $last_id= (array) $this->db->query("SELECT @last_id;")->result()[0];
        $data= array("last_id"=> $this->encryption->encrypt($last_id['@last_id']));

        $error = $this->db->error();
        $this->db->close();

        $this->Debug_model->set_debug($this->id_user, "sp_set_ajustes", "\n" . $sql);
        $this->db->close();

        return $error['code'] === 0 ? $this->load->response(true, $data) : $this->load->response(false, json_encode($error) );
    }

    public function set_update_ajustes($postData)
    {
        $postData["id"]= $this->encryption->decrypt($postData["id"]);

        if (empty($postData["id"]))
            return $this->load->response(false, array("vc_message" => "El id es altamente requerido ") );

        if (!is_numeric($postData["id"]))
            return $this->load->response(false, array("vc_message" => "Se espera un valor numérico en: id ") );

        $nombre= isset($postData['nombre']) ? $postData['nombre'] : ""; 
        $valor= isset($postData['valor']) ? $postData['valor'] : ""; 
        $valor_encrypt= isset($postData['valor_encrypt']) ? $postData['valor_encrypt'] : ""; 
        $descripcion= isset($postData['descripcion']) ? $postData['descripcion'] : ""; 
        $activo= isset($postData['activo']) ? $postData['activo'] : ""; 
        $creado= isset($postData['creado']) ? $postData['creado'] : ""; 
        $creado_por= isset($postData['creado_por']) ? $postData['creado_por'] : ""; 
        $modificado= isset($postData['modificado']) ? $postData['modificado'] : ""; 
        $modificado_por= isset($postData['modificado_por']) ? $postData['modificado_por'] : ""; 

        $sql  = "CALL sp_set_update_ajustes(";
        $sql .=      $this->db->escape( $postData["id"] );
        $sql .= "," .$this->db->escape( trim( $nombre ) );
        $sql .= "," .$this->db->escape( trim( $valor ) );
        $sql .= "," .$this->db->escape( trim( $valor_encrypt ) );
        $sql .= "," .$this->db->escape( trim( $descripcion ) );
        $sql .= "," .$this->db->escape( trim( $activo ) );
        $sql .= "," .$this->db->escape( trim( $creado ) );
        $sql .= "," .$this->db->escape( trim( $creado_por ) );
        $sql .= "," .$this->db->escape( trim( $modificado ) );
        $sql .= "," .$this->db->escape( trim( $modificado_por ) );
        $sql .= ", @i_internal_status";
        $sql .= ");";

        $this->db->query($sql);
        $i_internal_status= (array) $this->db->query("SELECT @i_internal_status;")->result()[0];
        $data= array("id_user"=> $this->encryption->encrypt($i_internal_status['@i_internal_status']));
        $this->db->close();

        $error = $this->db->error();
        $this->db->close();

        $this->Debug_model->set_debug($this->id_user, "sp_set_update_ajustes", "\n" . $sql);
        $this->db->close();
        
        return $error['code'] === 0 ? $this->load->response(true, $data) : $this->load->response(false, json_encode($error) );
    }

    public function importar_ajustes($postData)
    {
        if (is_array($postData) && count($postData)> 0)
        {
            foreach ($postData as $key => $value) 
            {
                if ($value['vc_precio'] > 0 )
                {
                    $nombre= isset($postData['nombre']) ? $postData['nombre'] : ""; 
                    $valor= isset($postData['valor']) ? $postData['valor'] : ""; 
                    $valor_encrypt= isset($postData['valor_encrypt']) ? $postData['valor_encrypt'] : ""; 
                    $descripcion= isset($postData['descripcion']) ? $postData['descripcion'] : ""; 
                    $activo= isset($postData['activo']) ? $postData['activo'] : ""; 
                    $creado= isset($postData['creado']) ? $postData['creado'] : ""; 
                    $creado_por= isset($postData['creado_por']) ? $postData['creado_por'] : ""; 
                    $modificado= isset($postData['modificado']) ? $postData['modificado'] : ""; 
                    $modificado_por= isset($postData['modificado_por']) ? $postData['modificado_por'] : ""; 

                    $sql  = "CALL sp_set_importar_ajustes(";
                    $sql .=      intval($this->id_user);
                    $sql .= "," .$this->db->escape( trim( $nombre ) );
                    $sql .= "," .$this->db->escape( trim( $valor ) );
                    $sql .= "," .$this->db->escape( trim( $valor_encrypt ) );
                    $sql .= "," .$this->db->escape( trim( $descripcion ) );
                    $sql .= "," .$this->db->escape( trim( $activo ) );
                    $sql .= "," .$this->db->escape( trim( $creado ) );
                    $sql .= "," .$this->db->escape( trim( $creado_por ) );
                    $sql .= "," .$this->db->escape( trim( $modificado ) );
                    $sql .= "," .$this->db->escape( trim( $modificado_por ) );
                    $sql .= ", @last_id";
                    $sql .= ");";

                    $this->Debug_model->set_debug($this->id_user, "sp_set_importar_ajustes", "\n" . $sql );
                    $this->db->query($sql);
                    $last_id= (array) $this->db->query("SELECT @last_id;")->result()[0];
                    $id_producto= $last_id['@last_id'];

                    // $this->descargar_imagen_importando_xlsx($id_producto, $vc_foto);
                }
            }

        }

        $this->db->close();
    }

    public function delete_ajustes($id)
    {
        $id= $this->encryption->decrypt($id);

        $sql  = "CALL sp_delete_ajustes(";
        $sql .= intval( $id );
        $sql .= ", @i_internal_status";
        $sql .= ");";

        $this->db->query($sql);
        $query = $this->db->query("SELECT @i_internal_status");
        $data= $query->result()[0];
        
        $this->db->close();
        
        $this->Debug_model->set_debug($this->id_user, "sp_delete_ajustes", $sql);

        return $this->load->response(true, $data);
    }

    public function undo_delete_ajustes($id)
    {
        $id= $this->encryption->decrypt($id);

        $sql  = "CALL sp_undo_delete_ajustes(";
        $sql .= intval($id );
        $sql .= ", @i_internal_status";
        $sql .= ");";

        $this->db->query($sql);
        $query = $this->db->query("SELECT @i_internal_status");
        $data= $query->result()[0];
        $this->db->close();
        
        $this->Debug_model->set_debug($this->id_user, "sp_undo_delete_ajustes", $sql);

        return $this->load->response(true, $data);
    }

}

?>
