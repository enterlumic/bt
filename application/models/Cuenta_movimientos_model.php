<?php

 class Cuenta_movimientos_model extends CI_Model {

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

    public function get_cuenta_movimientos_by_id($postData)
    {
        $postData["id"]= $this->encryption->decrypt($postData["id"]);

        if (empty($postData["id"]))
            return $this->load->response(false, array("vc_message" => "El id es altamente requerido ") );

        if (!is_numeric($postData["id"]))
            return $this->load->response(false, array("vc_message" => "Se espera un valor numérico en: id ") );

        $sql= "CALL sp_get_cuenta_movimientos_by_id(".intval( $postData["id"] ).");";
        $query = $this->db->query($sql);
        $error = $this->db->error();

        if ($error['code'] === 0 && is_object($query->result_id))
        {
            foreach ($query->result() as $key => $value) 
            {
                $data= array("id"=> $this->encryption->encrypt($value->id) 
                              ,"id_cliente" => $value->id_cliente
                              ,"id_paypal" => $value->id_paypal
                              ,"id_movimiento" => $value->id_movimiento
                              ,"tipo_movimiento" => $value->tipo_movimiento
                              ,"saldo_anterior" => $value->saldo_anterior
                              ,"saldo_nuevo" => $value->saldo_nuevo
                              ,"importe" => $value->importe
                              ,"monto_total" => $value->monto_total
                              ,"titular_cuenta" => $value->titular_cuenta
                              ,"refvc" => $value->refvc
                              ,"id_concepto" => $value->id_concepto
                              ,"descripcion" => $value->descripcion
                              ,"fecha_movimiento" => $value->fecha_movimiento
                              ,"creado_por" => $value->creado_por
                              ,"refInt" => $value->refInt
                              ,"refInt2" => $value->refInt2
                              ,"modificado" => $value->modificado
                              ,"activo" => $value->activo
                              ,"id_cuenta_movimientos" => $value->id_cuenta_movimientos
                              ,"id_cliente" => $value->id_cliente
                              ,"id_paypal" => $value->id_paypal
                              ,"id_movimiento" => $value->id_movimiento
                              ,"tipo_movimiento" => $value->tipo_movimiento
                              ,"saldo_anterior" => $value->saldo_anterior
                              ,"saldo_nuevo" => $value->saldo_nuevo
                              ,"importe" => $value->importe
                              ,"titular_cuenta" => $value->titular_cuenta
                              ,"refvc" => $value->refvc
                              ,"id_concepto" => $value->id_concepto
                              ,"descripcion" => $value->descripcion
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

    public function get_cuenta_movimientos_by_datatable($postData) 
    {
        $sql  = "CALL sp_get_cuenta_movimientos(";
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

        $this->Debug_model->set_debug($this->id_user, "sp_get_cuenta_movimientos", "\n" . $sql);

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
                              , $value->id_paypal
                              , $value->id_movimiento
                              , $value->tipo_movimiento
                              , $value->saldo_anterior
                              , $value->saldo_nuevo
                              , $value->importe
                              , $value->monto_total
                              , $value->titular_cuenta
                              , $value->refvc
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

    public function set_cuenta_movimientos($postData)
    {
        $id_cliente= isset($postData['id_cliente']) ? $postData['id_cliente'] : ""; 
        $id_paypal= isset($postData['id_paypal']) ? $postData['id_paypal'] : ""; 
        $id_movimiento= isset($postData['id_movimiento']) ? $postData['id_movimiento'] : ""; 
        $tipo_movimiento= isset($postData['tipo_movimiento']) ? $postData['tipo_movimiento'] : ""; 
        $saldo_anterior= isset($postData['saldo_anterior']) ? $postData['saldo_anterior'] : ""; 
        $saldo_nuevo= isset($postData['saldo_nuevo']) ? $postData['saldo_nuevo'] : ""; 
        $importe= isset($postData['importe']) ? $postData['importe'] : ""; 
        $monto_total= isset($postData['monto_total']) ? $postData['monto_total'] : ""; 
        $titular_cuenta= isset($postData['titular_cuenta']) ? $postData['titular_cuenta'] : ""; 
        $refvc= isset($postData['refvc']) ? $postData['refvc'] : ""; 
        $id_concepto= isset($postData['id_concepto']) ? $postData['id_concepto'] : ""; 
        $descripcion= isset($postData['descripcion']) ? $postData['descripcion'] : ""; 
        $fecha_movimiento= isset($postData['fecha_movimiento']) ? $postData['fecha_movimiento'] : ""; 
        $creado_por= isset($postData['creado_por']) ? $postData['creado_por'] : ""; 
        $refInt= isset($postData['refInt']) ? $postData['refInt'] : ""; 
        $refInt2= isset($postData['refInt2']) ? $postData['refInt2'] : ""; 
        $modificado= isset($postData['modificado']) ? $postData['modificado'] : ""; 
        $activo= isset($postData['activo']) ? $postData['activo'] : ""; 
        $id_cuenta_movimientos= isset($postData['id_cuenta_movimientos']) ? $postData['id_cuenta_movimientos'] : ""; 
        $id_cliente= isset($postData['id_cliente']) ? $postData['id_cliente'] : ""; 
        $id_paypal= isset($postData['id_paypal']) ? $postData['id_paypal'] : ""; 
        $id_movimiento= isset($postData['id_movimiento']) ? $postData['id_movimiento'] : ""; 
        $tipo_movimiento= isset($postData['tipo_movimiento']) ? $postData['tipo_movimiento'] : ""; 
        $saldo_anterior= isset($postData['saldo_anterior']) ? $postData['saldo_anterior'] : ""; 
        $saldo_nuevo= isset($postData['saldo_nuevo']) ? $postData['saldo_nuevo'] : ""; 
        $importe= isset($postData['importe']) ? $postData['importe'] : ""; 
        $titular_cuenta= isset($postData['titular_cuenta']) ? $postData['titular_cuenta'] : ""; 
        $refvc= isset($postData['refvc']) ? $postData['refvc'] : ""; 
        $id_concepto= isset($postData['id_concepto']) ? $postData['id_concepto'] : ""; 
        $descripcion= isset($postData['descripcion']) ? $postData['descripcion'] : ""; 

        $sql  = "CALL sp_set_cuenta_movimientos(";
        $sql .=      $this->db->escape( trim( $id_cliente ) );
        $sql .= "," .$this->db->escape( trim( $id_paypal ) );
        $sql .= "," .$this->db->escape( trim( $id_movimiento ) );
        $sql .= "," .$this->db->escape( trim( $tipo_movimiento ) );
        $sql .= "," .$this->db->escape( trim( $saldo_anterior ) );
        $sql .= "," .$this->db->escape( trim( $saldo_nuevo ) );
        $sql .= "," .$this->db->escape( trim( $importe ) );
        $sql .= "," .$this->db->escape( trim( $monto_total ) );
        $sql .= "," .$this->db->escape( trim( $titular_cuenta ) );
        $sql .= "," .$this->db->escape( trim( $refvc ) );
        $sql .= "," .$this->db->escape( trim( $id_concepto ) );
        $sql .= "," .$this->db->escape( trim( $descripcion ) );
        $sql .= "," .$this->db->escape( trim( $fecha_movimiento ) );
        $sql .= "," .$this->db->escape( trim( $creado_por ) );
        $sql .= "," .$this->db->escape( trim( $refInt ) );
        $sql .= "," .$this->db->escape( trim( $refInt2 ) );
        $sql .= "," .$this->db->escape( trim( $modificado ) );
        $sql .= "," .$this->db->escape( trim( $activo ) );
        $sql .= "," .$this->db->escape( trim( $id_cuenta_movimientos ) );
        $sql .= "," .$this->db->escape( trim( $id_cliente ) );
        $sql .= "," .$this->db->escape( trim( $id_paypal ) );
        $sql .= "," .$this->db->escape( trim( $id_movimiento ) );
        $sql .= "," .$this->db->escape( trim( $tipo_movimiento ) );
        $sql .= "," .$this->db->escape( trim( $saldo_anterior ) );
        $sql .= "," .$this->db->escape( trim( $saldo_nuevo ) );
        $sql .= "," .$this->db->escape( trim( $importe ) );
        $sql .= "," .$this->db->escape( trim( $titular_cuenta ) );
        $sql .= "," .$this->db->escape( trim( $refvc ) );
        $sql .= "," .$this->db->escape( trim( $id_concepto ) );
        $sql .= "," .$this->db->escape( trim( $descripcion ) );
        $sql .= ", @last_id";
        $sql .= ");";

        $this->db->query($sql);

        $last_id= (array) $this->db->query("SELECT @last_id;")->result()[0];
        $data= array("last_id"=> $this->encryption->encrypt($last_id['@last_id']));

        $error = $this->db->error();
        $this->db->close();

        $this->Debug_model->set_debug($this->id_user, "sp_set_cuenta_movimientos", "\n" . $sql);
        $this->db->close();

        return $error['code'] === 0 ? $this->load->response(true, $data) : $this->load->response(false, json_encode($error) );
    }

    public function set_update_cuenta_movimientos($postData)
    {
        $postData["id"]= $this->encryption->decrypt($postData["id"]);

        if (empty($postData["id"]))
            return $this->load->response(false, array("vc_message" => "El id es altamente requerido ") );

        if (!is_numeric($postData["id"]))
            return $this->load->response(false, array("vc_message" => "Se espera un valor numérico en: id ") );

        $id_cliente= isset($postData['id_cliente']) ? $postData['id_cliente'] : ""; 
        $id_paypal= isset($postData['id_paypal']) ? $postData['id_paypal'] : ""; 
        $id_movimiento= isset($postData['id_movimiento']) ? $postData['id_movimiento'] : ""; 
        $tipo_movimiento= isset($postData['tipo_movimiento']) ? $postData['tipo_movimiento'] : ""; 
        $saldo_anterior= isset($postData['saldo_anterior']) ? $postData['saldo_anterior'] : ""; 
        $saldo_nuevo= isset($postData['saldo_nuevo']) ? $postData['saldo_nuevo'] : ""; 
        $importe= isset($postData['importe']) ? $postData['importe'] : ""; 
        $monto_total= isset($postData['monto_total']) ? $postData['monto_total'] : ""; 
        $titular_cuenta= isset($postData['titular_cuenta']) ? $postData['titular_cuenta'] : ""; 
        $refvc= isset($postData['refvc']) ? $postData['refvc'] : ""; 
        $id_concepto= isset($postData['id_concepto']) ? $postData['id_concepto'] : ""; 
        $descripcion= isset($postData['descripcion']) ? $postData['descripcion'] : ""; 
        $fecha_movimiento= isset($postData['fecha_movimiento']) ? $postData['fecha_movimiento'] : ""; 
        $creado_por= isset($postData['creado_por']) ? $postData['creado_por'] : ""; 
        $refInt= isset($postData['refInt']) ? $postData['refInt'] : ""; 
        $refInt2= isset($postData['refInt2']) ? $postData['refInt2'] : ""; 
        $modificado= isset($postData['modificado']) ? $postData['modificado'] : ""; 
        $activo= isset($postData['activo']) ? $postData['activo'] : ""; 
        $id_cuenta_movimientos= isset($postData['id_cuenta_movimientos']) ? $postData['id_cuenta_movimientos'] : ""; 
        $id_cliente= isset($postData['id_cliente']) ? $postData['id_cliente'] : ""; 
        $id_paypal= isset($postData['id_paypal']) ? $postData['id_paypal'] : ""; 
        $id_movimiento= isset($postData['id_movimiento']) ? $postData['id_movimiento'] : ""; 
        $tipo_movimiento= isset($postData['tipo_movimiento']) ? $postData['tipo_movimiento'] : ""; 
        $saldo_anterior= isset($postData['saldo_anterior']) ? $postData['saldo_anterior'] : ""; 
        $saldo_nuevo= isset($postData['saldo_nuevo']) ? $postData['saldo_nuevo'] : ""; 
        $importe= isset($postData['importe']) ? $postData['importe'] : ""; 
        $titular_cuenta= isset($postData['titular_cuenta']) ? $postData['titular_cuenta'] : ""; 
        $refvc= isset($postData['refvc']) ? $postData['refvc'] : ""; 
        $id_concepto= isset($postData['id_concepto']) ? $postData['id_concepto'] : ""; 
        $descripcion= isset($postData['descripcion']) ? $postData['descripcion'] : ""; 

        $sql  = "CALL sp_set_update_cuenta_movimientos(";
        $sql .=      $this->db->escape( $postData["id"] );
        $sql .= "," .$this->db->escape( trim( $id_cliente ) );
        $sql .= "," .$this->db->escape( trim( $id_paypal ) );
        $sql .= "," .$this->db->escape( trim( $id_movimiento ) );
        $sql .= "," .$this->db->escape( trim( $tipo_movimiento ) );
        $sql .= "," .$this->db->escape( trim( $saldo_anterior ) );
        $sql .= "," .$this->db->escape( trim( $saldo_nuevo ) );
        $sql .= "," .$this->db->escape( trim( $importe ) );
        $sql .= "," .$this->db->escape( trim( $monto_total ) );
        $sql .= "," .$this->db->escape( trim( $titular_cuenta ) );
        $sql .= "," .$this->db->escape( trim( $refvc ) );
        $sql .= "," .$this->db->escape( trim( $id_concepto ) );
        $sql .= "," .$this->db->escape( trim( $descripcion ) );
        $sql .= "," .$this->db->escape( trim( $fecha_movimiento ) );
        $sql .= "," .$this->db->escape( trim( $creado_por ) );
        $sql .= "," .$this->db->escape( trim( $refInt ) );
        $sql .= "," .$this->db->escape( trim( $refInt2 ) );
        $sql .= "," .$this->db->escape( trim( $modificado ) );
        $sql .= "," .$this->db->escape( trim( $activo ) );
        $sql .= "," .$this->db->escape( trim( $id_cuenta_movimientos ) );
        $sql .= "," .$this->db->escape( trim( $id_cliente ) );
        $sql .= "," .$this->db->escape( trim( $id_paypal ) );
        $sql .= "," .$this->db->escape( trim( $id_movimiento ) );
        $sql .= "," .$this->db->escape( trim( $tipo_movimiento ) );
        $sql .= "," .$this->db->escape( trim( $saldo_anterior ) );
        $sql .= "," .$this->db->escape( trim( $saldo_nuevo ) );
        $sql .= "," .$this->db->escape( trim( $importe ) );
        $sql .= "," .$this->db->escape( trim( $titular_cuenta ) );
        $sql .= "," .$this->db->escape( trim( $refvc ) );
        $sql .= "," .$this->db->escape( trim( $id_concepto ) );
        $sql .= "," .$this->db->escape( trim( $descripcion ) );
        $sql .= ", @i_internal_status";
        $sql .= ");";

        $this->db->query($sql);
        $i_internal_status= (array) $this->db->query("SELECT @i_internal_status;")->result()[0];
        $data= array("id_user"=> $this->encryption->encrypt($i_internal_status['@i_internal_status']));
        $this->db->close();

        $error = $this->db->error();
        $this->db->close();

        $this->Debug_model->set_debug($this->id_user, "sp_set_update_cuenta_movimientos", "\n" . $sql);
        $this->db->close();
        
        return $error['code'] === 0 ? $this->load->response(true, $data) : $this->load->response(false, json_encode($error) );
    }

    public function importar_cuenta_movimientos($postData)
    {
        if (is_array($postData) && count($postData)> 0)
        {
            foreach ($postData as $key => $value) 
            {
                if ($value['vc_precio'] > 0 )
                {
                    $id_cliente= isset($postData['id_cliente']) ? $postData['id_cliente'] : ""; 
                    $id_paypal= isset($postData['id_paypal']) ? $postData['id_paypal'] : ""; 
                    $id_movimiento= isset($postData['id_movimiento']) ? $postData['id_movimiento'] : ""; 
                    $tipo_movimiento= isset($postData['tipo_movimiento']) ? $postData['tipo_movimiento'] : ""; 
                    $saldo_anterior= isset($postData['saldo_anterior']) ? $postData['saldo_anterior'] : ""; 
                    $saldo_nuevo= isset($postData['saldo_nuevo']) ? $postData['saldo_nuevo'] : ""; 
                    $importe= isset($postData['importe']) ? $postData['importe'] : ""; 
                    $monto_total= isset($postData['monto_total']) ? $postData['monto_total'] : ""; 
                    $titular_cuenta= isset($postData['titular_cuenta']) ? $postData['titular_cuenta'] : ""; 
                    $refvc= isset($postData['refvc']) ? $postData['refvc'] : 
                    $id_concepto= isset($postData['id_concepto']) ? $postData['id_concepto'] : ""; 
                    $descripcion= isset($postData['descripcion']) ? $postData['descripcion'] : ""; 
                    $fecha_movimiento= isset($postData['fecha_movimiento']) ? $postData['fecha_movimiento'] : ""; 
                    $creado_por= isset($postData['creado_por']) ? $postData['creado_por'] : ""; 
                    $refInt= isset($postData['refInt']) ? $postData['refInt'] : ""; 
                    $refInt2= isset($postData['refInt2']) ? $postData['refInt2'] : ""; 
                    $modificado= isset($postData['modificado']) ? $postData['modificado'] : ""; 
                    $activo= isset($postData['activo']) ? $postData['activo'] : ""; 
                    $id_cuenta_movimientos= isset($postData['id_cuenta_movimientos']) ? $postData['id_cuenta_movimientos'] : ""; 
                    $id_cliente= isset($postData['id_cliente']) ? $postData['id_cliente'] : ""; 
                    $id_paypal= isset($postData['id_paypal']) ? $postData['id_paypal'] : ""; 
                    $id_movimiento= isset($postData['id_movimiento']) ? $postData['id_movimiento'] : ""; 
                    $tipo_movimiento= isset($postData['tipo_movimiento']) ? $postData['tipo_movimiento'] : ""; 
                    $saldo_anterior= isset($postData['saldo_anterior']) ? $postData['saldo_anterior'] : ""; 
                    $saldo_nuevo= isset($postData['saldo_nuevo']) ? $postData['saldo_nuevo'] : ""; 
                    $importe= isset($postData['importe']) ? $postData['importe'] : ""; 
                    $titular_cuenta= isset($postData['titular_cuenta']) ? $postData['titular_cuenta'] : ""; 
                    $refvc= isset($postData['refvc']) ? $postData['refvc'] : ""; 
                    $id_concepto= isset($postData['id_concepto']) ? $postData['id_concepto'] : ""; 
                    $descripcion= isset($postData['descripcion']) ? $postData['descripcion'] : ""; 

                    $sql  = "CALL sp_set_importar_cuenta_movimientos(";
                    $sql .=      intval($this->id_user);
                    $sql .= "," .$this->db->escape( trim( $id_cliente ) );
                    $sql .= "," .$this->db->escape( trim( $id_paypal ) );
                    $sql .= "," .$this->db->escape( trim( $id_movimiento ) );
                    $sql .= "," .$this->db->escape( trim( $tipo_movimiento ) );
                    $sql .= "," .$this->db->escape( trim( $saldo_anterior ) );
                    $sql .= "," .$this->db->escape( trim( $saldo_nuevo ) );
                    $sql .= "," .$this->db->escape( trim( $importe ) );
                    $sql .= "," .$this->db->escape( trim( $monto_total ) );
                    $sql .= "," .$this->db->escape( trim( $titular_cuenta ) );
                    $sql .= "," .$this->db->escape( trim( $refvc ) );
                    $sql .= "," .$this->db->escape( trim( $id_concepto ) );
                    $sql .= "," .$this->db->escape( trim( $descripcion ) );
                    $sql .= "," .$this->db->escape( trim( $fecha_movimiento ) );
                    $sql .= "," .$this->db->escape( trim( $creado_por ) );
                    $sql .= "," .$this->db->escape( trim( $refInt ) );
                    $sql .= "," .$this->db->escape( trim( $refInt2 ) );
                    $sql .= "," .$this->db->escape( trim( $modificado ) );
                    $sql .= "," .$this->db->escape( trim( $activo ) );
                    $sql .= "," .$this->db->escape( trim( $id_cuenta_movimientos ) );
                    $sql .= "," .$this->db->escape( trim( $id_cliente ) );
                    $sql .= "," .$this->db->escape( trim( $id_paypal ) );
                    $sql .= "," .$this->db->escape( trim( $id_movimiento ) );
                    $sql .= "," .$this->db->escape( trim( $tipo_movimiento ) );
                    $sql .= "," .$this->db->escape( trim( $saldo_anterior ) );
                    $sql .= "," .$this->db->escape( trim( $saldo_nuevo ) );
                    $sql .= "," .$this->db->escape( trim( $importe ) );
                    $sql .= "," .$this->db->escape( trim( $titular_cuenta ) );
                    $sql .= "," .$this->db->escape( trim( $refvc ) );
                    $sql .= "," .$this->db->escape( trim( $id_concepto ) );
                    $sql .= "," .$this->db->escape( trim( $descripcion ) );                    
                    $sql .= ", @last_id";
                    $sql .= ");";

                    $this->Debug_model->set_debug($this->id_user, "sp_set_importar_cuenta_movimientos", "\n" . $sql );
                    $this->db->query($sql);
                    $last_id= (array) $this->db->query("SELECT @last_id;")->result()[0];
                    $id_producto= $last_id['@last_id'];

                    // $this->descargar_imagen_importando_xlsx($id_producto, $vc_foto);
                }
            }

        }

        $this->db->close();
    }

    public function delete_cuenta_movimientos($id)
    {
        $id= $this->encryption->decrypt($id);

        $sql  = "CALL sp_delete_cuenta_movimientos(";
        $sql .= intval( $id );
        $sql .= ", @i_internal_status";
        $sql .= ");";

        $this->db->query($sql);
        $query = $this->db->query("SELECT @i_internal_status");
        $data= $query->result()[0];
        
        $this->db->close();
        
        $this->Debug_model->set_debug($this->id_user, "sp_delete_cuenta_movimientos", $sql);

        return $this->load->response(true, $data);
    }

    public function undo_delete_cuenta_movimientos($id)
    {
        $id= $this->encryption->decrypt($id);

        $sql  = "CALL sp_undo_delete_cuenta_movimientos(";
        $sql .= intval($id );
        $sql .= ", @i_internal_status";
        $sql .= ");";

        $this->db->query($sql);
        $query = $this->db->query("SELECT @i_internal_status");
        $data= $query->result()[0];
        $this->db->close();
        
        $this->Debug_model->set_debug($this->id_user, "sp_undo_delete_cuenta_movimientos", $sql);

        return $this->load->response(true, $data);
    }

}

?>
