<?php

 class Precios_model extends CI_Model {

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

    public function get_precios_by_id($postData)
    {
        $postData["id_precios"]= $this->encryption->decrypt($postData["id_precios"]);

        if (empty($postData["id_precios"]))
            return $this->load->response(false, array("vc_message" => "El id es altamente requerido ") );

        if (!is_numeric($postData["id_precios"]))
            return $this->load->response(false, array("vc_message" => "Se espera un valor numérico en: id ") );

        $sql= "CALL sp_get_precios_by_id(".intval( $postData["id_precios"] ).");";
        $query = $this->db->query($sql);
        $error = $this->db->error();

        if ($error['code'] === 0 && is_object($query->result_id))
        {
            foreach ($query->result() as $key => $value) 
            {
                $data= array("id_precios"=> $this->encryption->encrypt($value->id) 
                              ,"IdPrecios" => $value->IdPrecios
                              ,"IdTipoEnvio" => $value->IdTipoEnvio
                              ,"Precio" => $value->Precio
                              ,"PesoInicio" => $value->PesoInicio
                              ,"PesoFin" => $value->PesoFin
                              ,"MedidaMaxima" => $value->MedidaMaxima
                              ,"DimensionMaxima" => $value->DimensionMaxima
                              ,"costo_extra_kg" => $value->costo_extra_kg
                              ,"peso_maximo" => $value->peso_maximo
                              ,"active" => $value->active
                              ,"Creado" => $value->Creado
                              ,"CreadoPor" => $value->CreadoPor
                              ,"Modificado" => $value->Modificado
                              ,"ModificadoPor" => $value->ModificadoPor
                              ,"vCampo15_precios" => $value->vCampo15_precios
                              ,"vCampo16_precios" => $value->vCampo16_precios
                              ,"vCampo17_precios" => $value->vCampo17_precios
                              ,"vCampo18_precios" => $value->vCampo18_precios
                              ,"vCampo19_precios" => $value->vCampo19_precios
                              ,"vCampo20_precios" => $value->vCampo20_precios
                              ,"vCampo21_precios" => $value->vCampo21_precios
                              ,"vCampo22_precios" => $value->vCampo22_precios
                              ,"vCampo23_precios" => $value->vCampo23_precios
                              ,"vCampo24_precios" => $value->vCampo24_precios
                              ,"vCampo25_precios" => $value->vCampo25_precios
                              ,"vCampo26_precios" => $value->vCampo26_precios
                              ,"vCampo27_precios" => $value->vCampo27_precios
                              ,"vCampo28_precios" => $value->vCampo28_precios
                              ,"vCampo29_precios" => $value->vCampo29_precios
                              ,"IdPrecios" => $value->IdPrecios
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

    public function get_precios_by_datatable($postData) 
    {
        $sql  = "CALL sp_get_precios(";
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

        $this->Debug_model->set_debug($this->id_user, "sp_get_precios", "\n" . $sql);

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
                              , $value->IdPrecios
                              , $value->IdTipoEnvio
                              , $value->Precio
                              , $value->PesoInicio
                              , $value->PesoFin
                              , $value->MedidaMaxima
                              , $value->DimensionMaxima
                              , $value->costo_extra_kg
                              , $value->peso_maximo
                              , $value->active
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

    public function set_precios($postData)
    {
        $IdPrecios= isset($postData['IdPrecios']) ? $postData['IdPrecios'] : ""; 
        $IdTipoEnvio= isset($postData['IdTipoEnvio']) ? $postData['IdTipoEnvio'] : ""; 
        $Precio= isset($postData['Precio']) ? $postData['Precio'] : ""; 
        $PesoInicio= isset($postData['PesoInicio']) ? $postData['PesoInicio'] : ""; 
        $PesoFin= isset($postData['PesoFin']) ? $postData['PesoFin'] : ""; 
        $MedidaMaxima= isset($postData['MedidaMaxima']) ? $postData['MedidaMaxima'] : ""; 
        $DimensionMaxima= isset($postData['DimensionMaxima']) ? $postData['DimensionMaxima'] : ""; 
        $costo_extra_kg= isset($postData['costo_extra_kg']) ? $postData['costo_extra_kg'] : ""; 
        $peso_maximo= isset($postData['peso_maximo']) ? $postData['peso_maximo'] : ""; 
        $active= isset($postData['active']) ? $postData['active'] : ""; 
        $Creado= isset($postData['Creado']) ? $postData['Creado'] : ""; 
        $CreadoPor= isset($postData['CreadoPor']) ? $postData['CreadoPor'] : ""; 
        $Modificado= isset($postData['Modificado']) ? $postData['Modificado'] : ""; 
        $ModificadoPor= isset($postData['ModificadoPor']) ? $postData['ModificadoPor'] : ""; 
        $vCampo15_precios= isset($postData['vCampo15_precios']) ? $postData['vCampo15_precios'] : ""; 
        $vCampo16_precios= isset($postData['vCampo16_precios']) ? $postData['vCampo16_precios'] : ""; 
        $vCampo17_precios= isset($postData['vCampo17_precios']) ? $postData['vCampo17_precios'] : ""; 
        $vCampo18_precios= isset($postData['vCampo18_precios']) ? $postData['vCampo18_precios'] : ""; 
        $vCampo19_precios= isset($postData['vCampo19_precios']) ? $postData['vCampo19_precios'] : ""; 
        $vCampo20_precios= isset($postData['vCampo20_precios']) ? $postData['vCampo20_precios'] : ""; 
        $vCampo21_precios= isset($postData['vCampo21_precios']) ? $postData['vCampo21_precios'] : ""; 
        $vCampo22_precios= isset($postData['vCampo22_precios']) ? $postData['vCampo22_precios'] : ""; 
        $vCampo23_precios= isset($postData['vCampo23_precios']) ? $postData['vCampo23_precios'] : ""; 
        $vCampo24_precios= isset($postData['vCampo24_precios']) ? $postData['vCampo24_precios'] : ""; 
        $vCampo25_precios= isset($postData['vCampo25_precios']) ? $postData['vCampo25_precios'] : ""; 
        $vCampo26_precios= isset($postData['vCampo26_precios']) ? $postData['vCampo26_precios'] : ""; 
        $vCampo27_precios= isset($postData['vCampo27_precios']) ? $postData['vCampo27_precios'] : ""; 
        $vCampo28_precios= isset($postData['vCampo28_precios']) ? $postData['vCampo28_precios'] : ""; 
        $vCampo29_precios= isset($postData['vCampo29_precios']) ? $postData['vCampo29_precios'] : ""; 
        $IdPrecios= isset($postData['IdPrecios']) ? $postData['IdPrecios'] : ""; 

        $sql  = "CALL sp_set_precios(";
        $sql .=      $this->db->escape( trim( $IdPrecios ) );
        $sql .= "," .$this->db->escape( trim( $IdTipoEnvio ) );
        $sql .= "," .$this->db->escape( trim( $Precio ) );
        $sql .= "," .$this->db->escape( trim( $PesoInicio ) );
        $sql .= "," .$this->db->escape( trim( $PesoFin ) );
        $sql .= "," .$this->db->escape( trim( $MedidaMaxima ) );
        $sql .= "," .$this->db->escape( trim( $DimensionMaxima ) );
        $sql .= "," .$this->db->escape( trim( $costo_extra_kg ) );
        $sql .= "," .$this->db->escape( trim( $peso_maximo ) );
        $sql .= "," .$this->db->escape( trim( $active ) );
        $sql .= "," .$this->db->escape( trim( $Creado ) );
        $sql .= "," .$this->db->escape( trim( $CreadoPor ) );
        $sql .= "," .$this->db->escape( trim( $Modificado ) );
        $sql .= "," .$this->db->escape( trim( $ModificadoPor ) );
        $sql .= "," .$this->db->escape( trim( $vCampo15_precios ) );
        $sql .= "," .$this->db->escape( trim( $vCampo16_precios ) );
        $sql .= "," .$this->db->escape( trim( $vCampo17_precios ) );
        $sql .= "," .$this->db->escape( trim( $vCampo18_precios ) );
        $sql .= "," .$this->db->escape( trim( $vCampo19_precios ) );
        $sql .= "," .$this->db->escape( trim( $vCampo20_precios ) );
        $sql .= "," .$this->db->escape( trim( $vCampo21_precios ) );
        $sql .= "," .$this->db->escape( trim( $vCampo22_precios ) );
        $sql .= "," .$this->db->escape( trim( $vCampo23_precios ) );
        $sql .= "," .$this->db->escape( trim( $vCampo24_precios ) );
        $sql .= "," .$this->db->escape( trim( $vCampo25_precios ) );
        $sql .= "," .$this->db->escape( trim( $vCampo26_precios ) );
        $sql .= "," .$this->db->escape( trim( $vCampo27_precios ) );
        $sql .= "," .$this->db->escape( trim( $vCampo28_precios ) );
        $sql .= "," .$this->db->escape( trim( $vCampo29_precios ) );
        $sql .= "," .$this->db->escape( trim( $IdPrecios ) );
        $sql .= ", @last_id";
        $sql .= ");";

        $this->db->query($sql);

        $last_id= (array) $this->db->query("SELECT @last_id;")->result()[0];
        $data= array("last_id"=> $this->encryption->encrypt($last_id['@last_id']));

        $error = $this->db->error();
        $this->db->close();

        $this->Debug_model->set_debug($this->id_user, "sp_set_precios", "\n" . $sql);
        $this->db->close();

        return $error['code'] === 0 ? $this->load->response(true, $data) : $this->load->response(false, json_encode($error) );
    }

    public function set_update_precios($postData)
    {
        $postData["id_precios"]= $this->encryption->decrypt($postData["id_precios"]);

        if (empty($postData["id_precios"]))
            return $this->load->response(false, array("vc_message" => "El id es altamente requerido ") );

        if (!is_numeric($postData["id_precios"]))
            return $this->load->response(false, array("vc_message" => "Se espera un valor numérico en: id ") );

        $IdPrecios= isset($postData['IdPrecios']) ? $postData['IdPrecios'] : ""; 
        $IdTipoEnvio= isset($postData['IdTipoEnvio']) ? $postData['IdTipoEnvio'] : ""; 
        $Precio= isset($postData['Precio']) ? $postData['Precio'] : ""; 
        $PesoInicio= isset($postData['PesoInicio']) ? $postData['PesoInicio'] : ""; 
        $PesoFin= isset($postData['PesoFin']) ? $postData['PesoFin'] : ""; 
        $MedidaMaxima= isset($postData['MedidaMaxima']) ? $postData['MedidaMaxima'] : ""; 
        $DimensionMaxima= isset($postData['DimensionMaxima']) ? $postData['DimensionMaxima'] : ""; 
        $costo_extra_kg= isset($postData['costo_extra_kg']) ? $postData['costo_extra_kg'] : ""; 
        $peso_maximo= isset($postData['peso_maximo']) ? $postData['peso_maximo'] : ""; 
        $active= isset($postData['active']) ? $postData['active'] : ""; 
        $Creado= isset($postData['Creado']) ? $postData['Creado'] : ""; 
        $CreadoPor= isset($postData['CreadoPor']) ? $postData['CreadoPor'] : ""; 
        $Modificado= isset($postData['Modificado']) ? $postData['Modificado'] : ""; 
        $ModificadoPor= isset($postData['ModificadoPor']) ? $postData['ModificadoPor'] : ""; 
        $vCampo15_precios= isset($postData['vCampo15_precios']) ? $postData['vCampo15_precios'] : ""; 
        $vCampo16_precios= isset($postData['vCampo16_precios']) ? $postData['vCampo16_precios'] : ""; 
        $vCampo17_precios= isset($postData['vCampo17_precios']) ? $postData['vCampo17_precios'] : ""; 
        $vCampo18_precios= isset($postData['vCampo18_precios']) ? $postData['vCampo18_precios'] : ""; 
        $vCampo19_precios= isset($postData['vCampo19_precios']) ? $postData['vCampo19_precios'] : ""; 
        $vCampo20_precios= isset($postData['vCampo20_precios']) ? $postData['vCampo20_precios'] : ""; 
        $vCampo21_precios= isset($postData['vCampo21_precios']) ? $postData['vCampo21_precios'] : ""; 
        $vCampo22_precios= isset($postData['vCampo22_precios']) ? $postData['vCampo22_precios'] : ""; 
        $vCampo23_precios= isset($postData['vCampo23_precios']) ? $postData['vCampo23_precios'] : ""; 
        $vCampo24_precios= isset($postData['vCampo24_precios']) ? $postData['vCampo24_precios'] : ""; 
        $vCampo25_precios= isset($postData['vCampo25_precios']) ? $postData['vCampo25_precios'] : ""; 
        $vCampo26_precios= isset($postData['vCampo26_precios']) ? $postData['vCampo26_precios'] : ""; 
        $vCampo27_precios= isset($postData['vCampo27_precios']) ? $postData['vCampo27_precios'] : ""; 
        $vCampo28_precios= isset($postData['vCampo28_precios']) ? $postData['vCampo28_precios'] : ""; 
        $vCampo29_precios= isset($postData['vCampo29_precios']) ? $postData['vCampo29_precios'] : ""; 
        $IdPrecios= isset($postData['IdPrecios']) ? $postData['IdPrecios'] : ""; 

        $sql  = "CALL sp_set_update_precios(";
        $sql .=      $this->db->escape( $postData["id_precios"] );
        $sql .= "," .$this->db->escape( trim( $IdPrecios ) );
        $sql .= "," .$this->db->escape( trim( $IdTipoEnvio ) );
        $sql .= "," .$this->db->escape( trim( $Precio ) );
        $sql .= "," .$this->db->escape( trim( $PesoInicio ) );
        $sql .= "," .$this->db->escape( trim( $PesoFin ) );
        $sql .= "," .$this->db->escape( trim( $MedidaMaxima ) );
        $sql .= "," .$this->db->escape( trim( $DimensionMaxima ) );
        $sql .= "," .$this->db->escape( trim( $costo_extra_kg ) );
        $sql .= "," .$this->db->escape( trim( $peso_maximo ) );
        $sql .= "," .$this->db->escape( trim( $active ) );
        $sql .= "," .$this->db->escape( trim( $Creado ) );
        $sql .= "," .$this->db->escape( trim( $CreadoPor ) );
        $sql .= "," .$this->db->escape( trim( $Modificado ) );
        $sql .= "," .$this->db->escape( trim( $ModificadoPor ) );
        $sql .= "," .$this->db->escape( trim( $vCampo15_precios ) );
        $sql .= "," .$this->db->escape( trim( $vCampo16_precios ) );
        $sql .= "," .$this->db->escape( trim( $vCampo17_precios ) );
        $sql .= "," .$this->db->escape( trim( $vCampo18_precios ) );
        $sql .= "," .$this->db->escape( trim( $vCampo19_precios ) );
        $sql .= "," .$this->db->escape( trim( $vCampo20_precios ) );
        $sql .= "," .$this->db->escape( trim( $vCampo21_precios ) );
        $sql .= "," .$this->db->escape( trim( $vCampo22_precios ) );
        $sql .= "," .$this->db->escape( trim( $vCampo23_precios ) );
        $sql .= "," .$this->db->escape( trim( $vCampo24_precios ) );
        $sql .= "," .$this->db->escape( trim( $vCampo25_precios ) );
        $sql .= "," .$this->db->escape( trim( $vCampo26_precios ) );
        $sql .= "," .$this->db->escape( trim( $vCampo27_precios ) );
        $sql .= "," .$this->db->escape( trim( $vCampo28_precios ) );
        $sql .= "," .$this->db->escape( trim( $vCampo29_precios ) );
        $sql .= "," .$this->db->escape( trim( $IdPrecios ) );
        $sql .= ", @i_internal_status";
        $sql .= ");";

        $this->db->query($sql);
        $i_internal_status= (array) $this->db->query("SELECT @i_internal_status;")->result()[0];
        $data= array("id_user"=> $this->encryption->encrypt($i_internal_status['@i_internal_status']));
        $this->db->close();

        $error = $this->db->error();
        $this->db->close();

        $this->Debug_model->set_debug($this->id_user, "sp_set_update_precios", "\n" . $sql);
        $this->db->close();
        
        return $error['code'] === 0 ? $this->load->response(true, $data) : $this->load->response(false, json_encode($error) );
    }

    public function importar_precios($postData)
    {
        if (is_array($postData) && count($postData)> 0)
        {
            foreach ($postData as $key => $value) 
            {
                if ($value['vc_precio'] > 0 )
                {
                    $IdPrecios= isset($postData['IdPrecios']) ? $postData['IdPrecios'] : ""; 
                    $IdTipoEnvio= isset($postData['IdTipoEnvio']) ? $postData['IdTipoEnvio'] : ""; 
                    $Precio= isset($postData['Precio']) ? $postData['Precio'] : ""; 
                    $PesoInicio= isset($postData['PesoInicio']) ? $postData['PesoInicio'] : ""; 
                    $PesoFin= isset($postData['PesoFin']) ? $postData['PesoFin'] : ""; 
                    $MedidaMaxima= isset($postData['MedidaMaxima']) ? $postData['MedidaMaxima'] : ""; 
                    $DimensionMaxima= isset($postData['DimensionMaxima']) ? $postData['DimensionMaxima'] : ""; 
                    $costo_extra_kg= isset($postData['costo_extra_kg']) ? $postData['costo_extra_kg'] : ""; 
                    $peso_maximo= isset($postData['peso_maximo']) ? $postData['peso_maximo'] : ""; 
                    $active= isset($postData['active']) ? $postData['active'] : 
                    $Creado= isset($postData['Creado']) ? $postData['Creado'] : ""; 
                    $CreadoPor= isset($postData['CreadoPor']) ? $postData['CreadoPor'] : ""; 
                    $Modificado= isset($postData['Modificado']) ? $postData['Modificado'] : ""; 
                    $ModificadoPor= isset($postData['ModificadoPor']) ? $postData['ModificadoPor'] : ""; 
                    $vCampo15_precios= isset($postData['vCampo15_precios']) ? $postData['vCampo15_precios'] : ""; 
                    $vCampo16_precios= isset($postData['vCampo16_precios']) ? $postData['vCampo16_precios'] : ""; 
                    $vCampo17_precios= isset($postData['vCampo17_precios']) ? $postData['vCampo17_precios'] : ""; 
                    $vCampo18_precios= isset($postData['vCampo18_precios']) ? $postData['vCampo18_precios'] : ""; 
                    $vCampo19_precios= isset($postData['vCampo19_precios']) ? $postData['vCampo19_precios'] : ""; 
                    $vCampo20_precios= isset($postData['vCampo20_precios']) ? $postData['vCampo20_precios'] : ""; 
                    $vCampo21_precios= isset($postData['vCampo21_precios']) ? $postData['vCampo21_precios'] : ""; 
                    $vCampo22_precios= isset($postData['vCampo22_precios']) ? $postData['vCampo22_precios'] : ""; 
                    $vCampo23_precios= isset($postData['vCampo23_precios']) ? $postData['vCampo23_precios'] : ""; 
                    $vCampo24_precios= isset($postData['vCampo24_precios']) ? $postData['vCampo24_precios'] : ""; 
                    $vCampo25_precios= isset($postData['vCampo25_precios']) ? $postData['vCampo25_precios'] : ""; 
                    $vCampo26_precios= isset($postData['vCampo26_precios']) ? $postData['vCampo26_precios'] : ""; 
                    $vCampo27_precios= isset($postData['vCampo27_precios']) ? $postData['vCampo27_precios'] : ""; 
                    $vCampo28_precios= isset($postData['vCampo28_precios']) ? $postData['vCampo28_precios'] : ""; 
                    $vCampo29_precios= isset($postData['vCampo29_precios']) ? $postData['vCampo29_precios'] : ""; 
                    $IdPrecios= isset($postData['IdPrecios']) ? $postData['IdPrecios'] : ""; 

                    $sql  = "CALL sp_set_importar_precios(";
                    $sql .=      intval($this->id_user);
                    $sql .= "," .$this->db->escape( trim( $IdPrecios ) );
                    $sql .= "," .$this->db->escape( trim( $IdTipoEnvio ) );
                    $sql .= "," .$this->db->escape( trim( $Precio ) );
                    $sql .= "," .$this->db->escape( trim( $PesoInicio ) );
                    $sql .= "," .$this->db->escape( trim( $PesoFin ) );
                    $sql .= "," .$this->db->escape( trim( $MedidaMaxima ) );
                    $sql .= "," .$this->db->escape( trim( $DimensionMaxima ) );
                    $sql .= "," .$this->db->escape( trim( $costo_extra_kg ) );
                    $sql .= "," .$this->db->escape( trim( $peso_maximo ) );
                    $sql .= "," .$this->db->escape( trim( $active ) );
                    $sql .= "," .$this->db->escape( trim( $Creado ) );
                    $sql .= "," .$this->db->escape( trim( $CreadoPor ) );
                    $sql .= "," .$this->db->escape( trim( $Modificado ) );
                    $sql .= "," .$this->db->escape( trim( $ModificadoPor ) );
                    $sql .= "," .$this->db->escape( trim( $vCampo15_precios ) );
                    $sql .= "," .$this->db->escape( trim( $vCampo16_precios ) );
                    $sql .= "," .$this->db->escape( trim( $vCampo17_precios ) );
                    $sql .= "," .$this->db->escape( trim( $vCampo18_precios ) );
                    $sql .= "," .$this->db->escape( trim( $vCampo19_precios ) );
                    $sql .= "," .$this->db->escape( trim( $vCampo20_precios ) );
                    $sql .= "," .$this->db->escape( trim( $vCampo21_precios ) );
                    $sql .= "," .$this->db->escape( trim( $vCampo22_precios ) );
                    $sql .= "," .$this->db->escape( trim( $vCampo23_precios ) );
                    $sql .= "," .$this->db->escape( trim( $vCampo24_precios ) );
                    $sql .= "," .$this->db->escape( trim( $vCampo25_precios ) );
                    $sql .= "," .$this->db->escape( trim( $vCampo26_precios ) );
                    $sql .= "," .$this->db->escape( trim( $vCampo27_precios ) );
                    $sql .= "," .$this->db->escape( trim( $vCampo28_precios ) );
                    $sql .= "," .$this->db->escape( trim( $vCampo29_precios ) );
                    $sql .= "," .$this->db->escape( trim( $IdPrecios ) );                    
                    $sql .= ", @last_id";
                    $sql .= ");";

                    $this->Debug_model->set_debug($this->id_user, "sp_set_importar_precios", "\n" . $sql );
                    $this->db->query($sql);
                    $last_id= (array) $this->db->query("SELECT @last_id;")->result()[0];
                    $id_producto= $last_id['@last_id'];

                    // $this->descargar_imagen_importando_xlsx($id_producto, $vc_foto);
                }
            }

        }

        $this->db->close();
    }

    public function delete_precios($id)
    {
        $id= $this->encryption->decrypt($id);

        $sql  = "CALL sp_delete_precios(";
        $sql .= intval( $id );
        $sql .= ", @i_internal_status";
        $sql .= ");";

        $this->db->query($sql);
        $query = $this->db->query("SELECT @i_internal_status");
        $data= $query->result()[0];
        
        $this->db->close();
        
        $this->Debug_model->set_debug($this->id_user, "sp_delete_precios", $sql);

        return $this->load->response(true, $data);
    }

    public function undo_delete_precios($id)
    {
        $id= $this->encryption->decrypt($id);

        $sql  = "CALL sp_undo_delete_precios(";
        $sql .= intval($id );
        $sql .= ", @i_internal_status";
        $sql .= ");";

        $this->db->query($sql);
        $query = $this->db->query("SELECT @i_internal_status");
        $data= $query->result()[0];
        $this->db->close();
        
        $this->Debug_model->set_debug($this->id_user, "sp_undo_delete_precios", $sql);

        return $this->load->response(true, $data);
    }

}

?>
