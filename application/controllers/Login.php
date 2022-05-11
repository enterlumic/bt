<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Login_model');
        $this->load->helper('url');
        $this->load->library('UploadFiles');
    }

    public function index()
    {
        $params[]= array();
        $params["title"]= "Login";
        $params["sub_titulo"]= "Login";

        $this->load->view('login_view');
    }
    
    public function get_login()
    {
        if($this->input->post()['ID'] !== '104577212723884898938' )
            return false;

        echo $this->Login_model->get_login($this->input->post());
    }

}
