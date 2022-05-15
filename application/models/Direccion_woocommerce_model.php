<?php

 class Direccion_woocommerce_model extends CI_Model {

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

    public function get_direccion_woocommerce_by_id($postData)
    {
        $postData["iddirecciontienda"]= $this->encryption->decrypt($postData["iddirecciontienda"]);

        if (empty($postData["iddirecciontienda"]))
            return $this->load->response(false, array("vc_message" => "El id es altamente requerido ") );

        if (!is_numeric($postData["iddirecciontienda"]))
            return $this->load->response(false, array("vc_message" => "Se espera un valor numérico en: id ") );

        $sql= "CALL sp_get_direccion_woocommerce_by_id(".intval( $postData["iddirecciontienda"] ).");";
        $query = $this->db->query($sql);
        $error = $this->db->error();

        if ($error['code'] === 0 && is_object($query->result_id))
        {
            foreach ($query->result() as $key => $value) 
            {
                $data= array("iddirecciontienda"=> $this->encryption->encrypt($value->id) 
                              ,"id_cliente" => $value->id_cliente
                              ,"url" => $value->url
                              ,"nombre" => $value->nombre
                              ,"empresa" => $value->empresa
                              ,"correo" => $value->correo
                              ,"telefono" => $value->telefono
                              ,"calle" => $value->calle
                              ,"colonia" => $value->colonia
                              ,"ciudad" => $value->ciudad
                              ,"codigo_postal" => $value->codigo_postal
                              ,"estado" => $value->estado
                              ,"pais" => $value->pais
                              ,"activo" => $value->activo
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

    public function get_direccion_woocommerce_by_datatable($postData) 
    {
        $sql  = "CALL sp_get_direccion_woocommerce(";
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

        $this->Debug_model->set_debug($this->id_user, "sp_get_direccion_woocommerce", "\n" . $sql);

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
                              , $value->id_cliente
                              , $value->url
                              , $value->nombre
                              , $value->empresa
                              , $value->correo
                              , $value->telefono
                              , $value->calle
                              , $value->colonia
                              , $value->ciudad
                              , $value->codigo_postal
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

    public function set_direccion_woocommerce($postData)
    {
        $id_cliente= isset($postData['id_cliente']) ? $postData['id_cliente'] : ""; 
        $url= isset($postData['url']) ? $postData['url'] : ""; 
        $nombre= isset($postData['nombre']) ? $postData['nombre'] : ""; 
        $empresa= isset($postData['empresa']) ? $postData['empresa'] : ""; 
        $correo= isset($postData['correo']) ? $postData['correo'] : ""; 
        $telefono= isset($postData['telefono']) ? $postData['telefono'] : ""; 
        $calle= isset($postData['calle']) ? $postData['calle'] : ""; 
        $colonia= isset($postData['colonia']) ? $postData['colonia'] : ""; 
        $ciudad= isset($postData['ciudad']) ? $postData['ciudad'] : ""; 
        $codigo_postal= isset($postData['codigo_postal']) ? $postData['codigo_postal'] : ""; 
        $estado= isset($postData['estado']) ? $postData['estado'] : ""; 
        $pais= isset($postData['pais']) ? $postData['pais'] : ""; 
        $activo= isset($postData['activo']) ? $postData['activo'] : ""; 

        $sql  = "CALL sp_set_direccion_woocommerce(";
        $sql .=      $this->db->escape( trim( $id_cliente ) );
        $sql .= "," .$this->db->escape( trim( $url ) );
        $sql .= "," .$this->db->escape( trim( $nombre ) );
        $sql .= "," .$this->db->escape( trim( $empresa ) );
        $sql .= "," .$this->db->escape( trim( $correo ) );
        $sql .= "," .$this->db->escape( trim( $telefono ) );
        $sql .= "," .$this->db->escape( trim( $calle ) );
        $sql .= "," .$this->db->escape( trim( $colonia ) );
        $sql .= "," .$this->db->escape( trim( $ciudad ) );
        $sql .= "," .$this->db->escape( trim( $codigo_postal ) );
        $sql .= "," .$this->db->escape( trim( $estado ) );
        $sql .= "," .$this->db->escape( trim( $pais ) );
        $sql .= "," .$this->db->escape( trim( $activo ) );
        $sql .= ", @last_id";
        $sql .= ");";

        $this->db->query($sql);

        $last_id= (array) $this->db->query("SELECT @last_id;")->result()[0];
        $data= array("last_id"=> $this->encryption->encrypt($last_id['@last_id']));

        $error = $this->db->error();
        $this->db->close();

        $this->Debug_model->set_debug($this->id_user, "sp_set_direccion_woocommerce", "\n" . $sql);
        $this->db->close();

        return $error['code'] === 0 ? $this->load->response(true, $data) : $this->load->response(false, json_encode($error) );
    }

    public function set_update_direccion_woocommerce($postData)
    {
        $postData["iddirecciontienda"]= $this->encryption->decrypt($postData["iddirecciontienda"]);

        if (empty($postData["iddirecciontienda"]))
            return $this->load->response(false, array("vc_message" => "El id es altamente requerido ") );

        if (!is_numeric($postData["iddirecciontienda"]))
            return $this->load->response(false, array("vc_message" => "Se espera un valor numérico en: id ") );

        $id_cliente= isset($postData['id_cliente']) ? $postData['id_cliente'] : ""; 
        $url= isset($postData['url']) ? $postData['url'] : ""; 
        $nombre= isset($postData['nombre']) ? $postData['nombre'] : ""; 
        $empresa= isset($postData['empresa']) ? $postData['empresa'] : ""; 
        $correo= isset($postData['correo']) ? $postData['correo'] : ""; 
        $telefono= isset($postData['telefono']) ? $postData['telefono'] : ""; 
        $calle= isset($postData['calle']) ? $postData['calle'] : ""; 
        $colonia= isset($postData['colonia']) ? $postData['colonia'] : ""; 
        $ciudad= isset($postData['ciudad']) ? $postData['ciudad'] : ""; 
        $codigo_postal= isset($postData['codigo_postal']) ? $postData['codigo_postal'] : ""; 
        $estado= isset($postData['estado']) ? $postData['estado'] : ""; 
        $pais= isset($postData['pais']) ? $postData['pais'] : ""; 
        $activo= isset($postData['activo']) ? $postData['activo'] : ""; 

        $sql  = "CALL sp_set_update_direccion_woocommerce(";
        $sql .=      $this->db->escape( $postData["iddirecciontienda"] );
        $sql .= "," .$this->db->escape( trim( $id_cliente ) );
        $sql .= "," .$this->db->escape( trim( $url ) );
        $sql .= "," .$this->db->escape( trim( $nombre ) );
        $sql .= "," .$this->db->escape( trim( $empresa ) );
        $sql .= "," .$this->db->escape( trim( $correo ) );
        $sql .= "," .$this->db->escape( trim( $telefono ) );
        $sql .= "," .$this->db->escape( trim( $calle ) );
        $sql .= "," .$this->db->escape( trim( $colonia ) );
        $sql .= "," .$this->db->escape( trim( $ciudad ) );
        $sql .= "," .$this->db->escape( trim( $codigo_postal ) );
        $sql .= "," .$this->db->escape( trim( $estado ) );
        $sql .= "," .$this->db->escape( trim( $pais ) );
        $sql .= "," .$this->db->escape( trim( $activo ) );
        $sql .= ", @i_internal_status";
        $sql .= ");";

        $this->db->query($sql);
        $i_internal_status= (array) $this->db->query("SELECT @i_internal_status;")->result()[0];
        $data= array("id_user"=> $this->encryption->encrypt($i_internal_status['@i_internal_status']));
        $this->db->close();

        $error = $this->db->error();
        $this->db->close();

        $this->Debug_model->set_debug($this->id_user, "sp_set_update_direccion_woocommerce", "\n" . $sql);
        $this->db->close();
        
        return $error['code'] === 0 ? $this->load->response(true, $data) : $this->load->response(false, json_encode($error) );
    }

    public function importar_direccion_woocommerce($postData)
    {
        if (is_array($postData) && count($postData)> 0)
        {
            foreach ($postData as $key => $value) 
            {
                if ($value['vc_precio'] > 0 )
                {
                    $id_cliente= isset($postData['id_cliente']) ? $postData['id_cliente'] : ""; 
                    $url= isset($postData['url']) ? $postData['url'] : ""; 
                    $nombre= isset($postData['nombre']) ? $postData['nombre'] : ""; 
                    $empresa= isset($postData['empresa']) ? $postData['empresa'] : ""; 
                    $correo= isset($postData['correo']) ? $postData['correo'] : ""; 
                    $telefono= isset($postData['telefono']) ? $postData['telefono'] : ""; 
                    $calle= isset($postData['calle']) ? $postData['calle'] : ""; 
                    $colonia= isset($postData['colonia']) ? $postData['colonia'] : ""; 
                    $ciudad= isset($postData['ciudad']) ? $postData['ciudad'] : ""; 
                    $codigo_postal= isset($postData['codigo_postal']) ? $postData['codigo_postal'] : 
                    $estado= isset($postData['estado']) ? $postData['estado'] : ""; 
                    $pais= isset($postData['pais']) ? $postData['pais'] : ""; 
                    $activo= isset($postData['activo']) ? $postData['activo'] : ""; 

                    $sql  = "CALL sp_set_importar_direccion_woocommerce(";
                    $sql .=      intval($this->id_user);
                    $sql .= "," .$this->db->escape( trim( $id_cliente ) );
                    $sql .= "," .$this->db->escape( trim( $url ) );
                    $sql .= "," .$this->db->escape( trim( $nombre ) );
                    $sql .= "," .$this->db->escape( trim( $empresa ) );
                    $sql .= "," .$this->db->escape( trim( $correo ) );
                    $sql .= "," .$this->db->escape( trim( $telefono ) );
                    $sql .= "," .$this->db->escape( trim( $calle ) );
                    $sql .= "," .$this->db->escape( trim( $colonia ) );
                    $sql .= "," .$this->db->escape( trim( $ciudad ) );
                    $sql .= "," .$this->db->escape( trim( $codigo_postal ) );
                    $sql .= "," .$this->db->escape( trim( $estado ) );
                    $sql .= "," .$this->db->escape( trim( $pais ) );
                    $sql .= "," .$this->db->escape( trim( $activo ) );
                    $sql .= ", @last_id";
                    $sql .= ");";

                    $this->Debug_model->set_debug($this->id_user, "sp_set_importar_direccion_woocommerce", "\n" . $sql );
                    $this->db->query($sql);
                    $last_id= (array) $this->db->query("SELECT @last_id;")->result()[0];
                    $id_producto= $last_id['@last_id'];

                    // $this->descargar_imagen_importando_xlsx($id_producto, $vc_foto);
                }
            }

        }

        $this->db->close();
    }

    public function delete_direccion_woocommerce($id)
    {
        $id= $this->encryption->decrypt($id);

        $sql  = "CALL sp_delete_direccion_woocommerce(";
        $sql .= intval( $id );
        $sql .= ", @i_internal_status";
        $sql .= ");";

        $this->db->query($sql);
        $query = $this->db->query("SELECT @i_internal_status");
        $data= $query->result()[0];
        
        $this->db->close();
        
        $this->Debug_model->set_debug($this->id_user, "sp_delete_direccion_woocommerce", $sql);

        return $this->load->response(true, $data);
    }

    public function undo_delete_direccion_woocommerce($id)
    {
        $id= $this->encryption->decrypt($id);

        $sql  = "CALL sp_undo_delete_direccion_woocommerce(";
        $sql .= intval($id );
        $sql .= ", @i_internal_status";
        $sql .= ");";

        $this->db->query($sql);
        $query = $this->db->query("SELECT @i_internal_status");
        $data= $query->result()[0];
        $this->db->close();
        
        $this->Debug_model->set_debug($this->id_user, "sp_undo_delete_direccion_woocommerce", $sql);

        return $this->load->response(true, $data);
    }

}

?>
