<?php

 class Debug_model extends CI_Model {

    public function __construct(){ 
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }
  
    public function getDataDynamic($tabla="",$filtro=false,$substring="",$i_limit_init=0,$i_limit_end=0,$i_colum_order=0,$vc_order_direct="")
    {

        $sql = "CALL sp_server_side(";
        $sql .=      $this->db->escape($tabla);
        $sql .= "," .$this->db->escape($filtro);
        $sql .= "," .$this->db->escape($substring);
        $sql .= "," .$this->db->escape($i_limit_init);
        $sql .= "," .$this->db->escape($i_limit_end);
        $sql .= "," .$this->db->escape($i_colum_order);
        $sql .= "," .$this->db->escape($vc_order_direct);
        $sql.=")";

        $data=$this->db->query($sql);     
        $error = $this->db->error();
        $this->db->close();

        return $error['code'] === 0 ? $this->load->response(true, $data->result()) : $this->load->response(false, json_encode($error) );

    }

    public function set_debug($id_user, $vc_event, $vc_query) {

        $arr_find= array("'", "\\", "<a");
        $arr_replace= array("''", "\\\\", "<a target=\"_blank\" ");

        $vc_query= trim($vc_query);
        $vc_query= str_replace($arr_find, $arr_replace, $vc_query);

        $HTTP_USER_AGENT= isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT']: "";
        $SCRIPT_FILENAME= isset($_SERVER['SCRIPT_FILENAME']) ? $_SERVER['SCRIPT_FILENAME']: "";

        $info= array ("HTTP_USER_AGENT"=> $HTTP_USER_AGENT, "SCRIPT_FILENAME"=> $SCRIPT_FILENAME);

        $info= json_encode($info, JSON_PRETTY_PRINT );

        $info= isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] === "https" ? $info : ""; 

        $sql  = "CALL sp_set_debug(";
        $sql .=        $id_user;
        $sql .= " ,'" .trim($vc_event);
        $sql .= "','" .trim($vc_query);
        $sql .= "','" .$info."'";
        $sql .= ");";

        $this->db->query($sql);
        $this->db->close();
    }

    public function reset_debug() {
        $this->db->query("CALL sp_reset_debug();");
    }

} 

?>