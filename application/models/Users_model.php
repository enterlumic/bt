<?php

 class Users_model extends CI_Model {

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

    public function get_users_by_id($postData)
    {
        $postData["id"]= $this->encryption->decrypt($postData["id"]);

        if (empty($postData["id"]))
            return $this->load->response(false, array("vc_message" => "El id es altamente requerido ") );

        if (!is_numeric($postData["id"]))
            return $this->load->response(false, array("vc_message" => "Se espera un valor numérico en: id ") );

        $sql= "CALL sp_get_users_by_id(".intval( $postData["id"] ).");";
        $query = $this->db->query($sql);
        $error = $this->db->error();

        if ($error['code'] === 0 && is_object($query->result_id))
        {
            foreach ($query->result() as $key => $value) 
            {
                $data= array("id"=> $this->encryption->encrypt($value->id) 
                              ,"name" => $value->name
                              ,"apellido" => $value->apellido
                              ,"email" => $value->email
                              ,"email_verified_at" => $value->email_verified_at
                              ,"password" => $value->password
                              ,"pass_crypt" => $value->pass_crypt
                              ,"referido" => $value->referido
                              ,"myrefcode" => $value->myrefcode
                              ,"admin" => $value->admin
                              ,"telefono" => $value->telefono
                              ,"empresa" => $value->empresa
                              ,"remember_token" => $value->remember_token
                              ,"active" => $value->active
                              ,"created_at" => $value->created_at
                              ,"updated_at" => $value->updated_at
                              ,"usuario_legacy" => $value->usuario_legacy
                              ,"medio_de_contacto" => $value->medio_de_contacto
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

    public function get_users_by_datatable($postData) 
    {
        $sql  = "CALL sp_get_users(";
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

        $this->Debug_model->set_debug($this->id_user, "sp_get_users", "\n" . $sql);

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
                              , $value->name.  " (".$value->id.")"
                              , $value->apellido
                              , $value->email
                              , $value->email_verified_at
                              , $value->password
                              , $value->pass_crypt
                              , $value->referido
                              , $value->myrefcode
                              , $value->admin
                              , $value->telefono
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

    public function set_users($postData)
    {
        $name= isset($postData['name']) ? $postData['name'] : ""; 
        $apellido= isset($postData['apellido']) ? $postData['apellido'] : ""; 
        $email= isset($postData['email']) ? $postData['email'] : ""; 
        $email_verified_at= isset($postData['email_verified_at']) ? $postData['email_verified_at'] : ""; 
        $password= isset($postData['password']) ? $postData['password'] : ""; 
        $pass_crypt= isset($postData['pass_crypt']) ? $postData['pass_crypt'] : ""; 
        $referido= isset($postData['referido']) ? $postData['referido'] : ""; 
        $myrefcode= isset($postData['myrefcode']) ? $postData['myrefcode'] : ""; 
        $admin= isset($postData['admin']) ? $postData['admin'] : ""; 
        $telefono= isset($postData['telefono']) ? $postData['telefono'] : ""; 
        $empresa= isset($postData['empresa']) ? $postData['empresa'] : ""; 
        $remember_token= isset($postData['remember_token']) ? $postData['remember_token'] : ""; 
        $active= isset($postData['active']) ? $postData['active'] : ""; 
        $created_at= isset($postData['created_at']) ? $postData['created_at'] : ""; 
        $updated_at= isset($postData['updated_at']) ? $postData['updated_at'] : ""; 
        $usuario_legacy= isset($postData['usuario_legacy']) ? $postData['usuario_legacy'] : ""; 
        $medio_de_contacto= isset($postData['medio_de_contacto']) ? $postData['medio_de_contacto'] : ""; 

        $sql  = "CALL sp_set_users(";
        $sql .=      $this->db->escape( trim( $name ) );
        $sql .= "," .$this->db->escape( trim( $apellido ) );
        $sql .= "," .$this->db->escape( trim( $email ) );
        $sql .= "," .$this->db->escape( trim( $email_verified_at ) );
        $sql .= "," .$this->db->escape( trim( $password ) );
        $sql .= "," .$this->db->escape( trim( $pass_crypt ) );
        $sql .= "," .$this->db->escape( trim( $referido ) );
        $sql .= "," .$this->db->escape( trim( $myrefcode ) );
        $sql .= "," .$this->db->escape( trim( $admin ) );
        $sql .= "," .$this->db->escape( trim( $telefono ) );
        $sql .= "," .$this->db->escape( trim( $empresa ) );
        $sql .= "," .$this->db->escape( trim( $remember_token ) );
        $sql .= "," .$this->db->escape( trim( $active ) );
        $sql .= "," .$this->db->escape( trim( $created_at ) );
        $sql .= "," .$this->db->escape( trim( $updated_at ) );
        $sql .= "," .$this->db->escape( trim( $usuario_legacy ) );
        $sql .= "," .$this->db->escape( trim( $medio_de_contacto ) );
        $sql .= ", @last_id";
        $sql .= ");";

        $this->db->query($sql);

        $last_id= (array) $this->db->query("SELECT @last_id;")->result()[0];
        $data= array("last_id"=> $this->encryption->encrypt($last_id['@last_id']));

        $error = $this->db->error();
        $this->db->close();

        $this->Debug_model->set_debug($this->id_user, "sp_set_users", "\n" . $sql);
        $this->db->close();

        return $error['code'] === 0 ? $this->load->response(true, $data) : $this->load->response(false, json_encode($error) );
    }

    public function set_update_users($postData)
    {
        $postData["id"]= $this->encryption->decrypt($postData["id"]);

        if (empty($postData["id"]))
            return $this->load->response(false, array("vc_message" => "El id es altamente requerido ") );

        if (!is_numeric($postData["id"]))
            return $this->load->response(false, array("vc_message" => "Se espera un valor numérico en: id ") );

        $name= isset($postData['name']) ? $postData['name'] : ""; 
        $apellido= isset($postData['apellido']) ? $postData['apellido'] : ""; 
        $email= isset($postData['email']) ? $postData['email'] : ""; 
        $email_verified_at= isset($postData['email_verified_at']) ? $postData['email_verified_at'] : ""; 
        $password= isset($postData['password']) ? $postData['password'] : ""; 
        $pass_crypt= isset($postData['pass_crypt']) ? $postData['pass_crypt'] : ""; 
        $referido= isset($postData['referido']) ? $postData['referido'] : ""; 
        $myrefcode= isset($postData['myrefcode']) ? $postData['myrefcode'] : ""; 
        $admin= isset($postData['admin']) ? $postData['admin'] : ""; 
        $telefono= isset($postData['telefono']) ? $postData['telefono'] : ""; 
        $empresa= isset($postData['empresa']) ? $postData['empresa'] : ""; 
        $remember_token= isset($postData['remember_token']) ? $postData['remember_token'] : ""; 
        $active= isset($postData['active']) ? $postData['active'] : ""; 
        $created_at= isset($postData['created_at']) ? $postData['created_at'] : ""; 
        $updated_at= isset($postData['updated_at']) ? $postData['updated_at'] : ""; 
        $usuario_legacy= isset($postData['usuario_legacy']) ? $postData['usuario_legacy'] : ""; 
        $medio_de_contacto= isset($postData['medio_de_contacto']) ? $postData['medio_de_contacto'] : ""; 

        $sql  = "CALL sp_set_update_users(";
        $sql .=      $this->db->escape( $postData["id"] );
        $sql .= "," .$this->db->escape( trim( $name ) );
        $sql .= "," .$this->db->escape( trim( $apellido ) );
        $sql .= "," .$this->db->escape( trim( $email ) );
        $sql .= "," .$this->db->escape( trim( $email_verified_at ) );
        $sql .= "," .$this->db->escape( trim( $password ) );
        $sql .= "," .$this->db->escape( trim( $pass_crypt ) );
        $sql .= "," .$this->db->escape( trim( $referido ) );
        $sql .= "," .$this->db->escape( trim( $myrefcode ) );
        $sql .= "," .$this->db->escape( trim( $admin ) );
        $sql .= "," .$this->db->escape( trim( $telefono ) );
        $sql .= "," .$this->db->escape( trim( $empresa ) );
        $sql .= "," .$this->db->escape( trim( $remember_token ) );
        $sql .= "," .$this->db->escape( trim( $active ) );
        $sql .= "," .$this->db->escape( trim( $created_at ) );
        $sql .= "," .$this->db->escape( trim( $updated_at ) );
        $sql .= "," .$this->db->escape( trim( $usuario_legacy ) );
        $sql .= "," .$this->db->escape( trim( $medio_de_contacto ) );
        $sql .= ", @i_internal_status";
        $sql .= ");";

        $this->db->query($sql);
        $i_internal_status= (array) $this->db->query("SELECT @i_internal_status;")->result()[0];
        $data= array("id_user"=> $this->encryption->encrypt($i_internal_status['@i_internal_status']));
        $this->db->close();

        $error = $this->db->error();
        $this->db->close();

        $this->Debug_model->set_debug($this->id_user, "sp_set_update_users", "\n" . $sql);
        $this->db->close();
        
        return $error['code'] === 0 ? $this->load->response(true, $data) : $this->load->response(false, json_encode($error) );
    }

    public function importar_users($postData)
    {
        if (is_array($postData) && count($postData)> 0)
        {
            foreach ($postData as $key => $value) 
            {
                if ($value['vc_precio'] > 0 )
                {
                    $name= isset($postData['name']) ? $postData['name'] : ""; 
                    $apellido= isset($postData['apellido']) ? $postData['apellido'] : ""; 
                    $email= isset($postData['email']) ? $postData['email'] : ""; 
                    $email_verified_at= isset($postData['email_verified_at']) ? $postData['email_verified_at'] : ""; 
                    $password= isset($postData['password']) ? $postData['password'] : ""; 
                    $pass_crypt= isset($postData['pass_crypt']) ? $postData['pass_crypt'] : ""; 
                    $referido= isset($postData['referido']) ? $postData['referido'] : ""; 
                    $myrefcode= isset($postData['myrefcode']) ? $postData['myrefcode'] : ""; 
                    $admin= isset($postData['admin']) ? $postData['admin'] : ""; 
                    $telefono= isset($postData['telefono']) ? $postData['telefono'] : 
                    $empresa= isset($postData['empresa']) ? $postData['empresa'] : ""; 
                    $remember_token= isset($postData['remember_token']) ? $postData['remember_token'] : ""; 
                    $active= isset($postData['active']) ? $postData['active'] : ""; 
                    $created_at= isset($postData['created_at']) ? $postData['created_at'] : ""; 
                    $updated_at= isset($postData['updated_at']) ? $postData['updated_at'] : ""; 
                    $usuario_legacy= isset($postData['usuario_legacy']) ? $postData['usuario_legacy'] : ""; 
                    $medio_de_contacto= isset($postData['medio_de_contacto']) ? $postData['medio_de_contacto'] : ""; 

                    $sql  = "CALL sp_set_importar_users(";
                    $sql .=      intval($this->id_user);
                    $sql .= "," .$this->db->escape( trim( $name ) );
                    $sql .= "," .$this->db->escape( trim( $apellido ) );
                    $sql .= "," .$this->db->escape( trim( $email ) );
                    $sql .= "," .$this->db->escape( trim( $email_verified_at ) );
                    $sql .= "," .$this->db->escape( trim( $password ) );
                    $sql .= "," .$this->db->escape( trim( $pass_crypt ) );
                    $sql .= "," .$this->db->escape( trim( $referido ) );
                    $sql .= "," .$this->db->escape( trim( $myrefcode ) );
                    $sql .= "," .$this->db->escape( trim( $admin ) );
                    $sql .= "," .$this->db->escape( trim( $telefono ) );
                    $sql .= "," .$this->db->escape( trim( $empresa ) );
                    $sql .= "," .$this->db->escape( trim( $remember_token ) );
                    $sql .= "," .$this->db->escape( trim( $active ) );
                    $sql .= "," .$this->db->escape( trim( $created_at ) );
                    $sql .= "," .$this->db->escape( trim( $updated_at ) );
                    $sql .= "," .$this->db->escape( trim( $usuario_legacy ) );
                    $sql .= "," .$this->db->escape( trim( $medio_de_contacto ) );
                    $sql .= ", @last_id";
                    $sql .= ");";

                    $this->Debug_model->set_debug($this->id_user, "sp_set_importar_users", "\n" . $sql );
                    $this->db->query($sql);
                    $last_id= (array) $this->db->query("SELECT @last_id;")->result()[0];
                    $id_producto= $last_id['@last_id'];

                    // $this->descargar_imagen_importando_xlsx($id_producto, $vc_foto);
                }
            }

        }

        $this->db->close();
    }

    public function delete_users($id)
    {
        $id= $this->encryption->decrypt($id);

        $sql  = "CALL sp_delete_users(";
        $sql .= intval( $id );
        $sql .= ", @i_internal_status";
        $sql .= ");";

        $this->db->query($sql);
        $query = $this->db->query("SELECT @i_internal_status");
        $data= $query->result()[0];
        
        $this->db->close();
        
        $this->Debug_model->set_debug($this->id_user, "sp_delete_users", $sql);

        return $this->load->response(true, $data);
    }

    public function undo_delete_users($id)
    {
        $id= $this->encryption->decrypt($id);

        $sql  = "CALL sp_undo_delete_users(";
        $sql .= intval($id );
        $sql .= ", @i_internal_status";
        $sql .= ");";

        $this->db->query($sql);
        $query = $this->db->query("SELECT @i_internal_status");
        $data= $query->result()[0];
        $this->db->close();
        
        $this->Debug_model->set_debug($this->id_user, "sp_undo_delete_users", $sql);

        return $this->load->response(true, $data);
    }

}

?>
