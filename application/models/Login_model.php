<?php

 class Login_model extends CI_Model {

    private $id_user;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Debug_model');        
        $this->load->library('session');
        $this->load->library('encryption');
        $this->encryption->initialize( array( 'cipher' => 'aes-256', 'mode' => 'ctr', 'key' => '<a 32-character random string>') );
        $this->load->database();
    }

    public function get_login($param) 
    {
        if($param['ID'] !== '104577212723884898938' )
            return false;

        $this->session->vc_foto= $param["vc_foto"];
        return $this->session->id_user= $param["ID"];
    }

}

?>
