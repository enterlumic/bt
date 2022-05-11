<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configuraciones extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Configuraciones_model');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('UploadFiles');
        $this->id_user= isset($this->session->userdata['id_user'])? $this->session->userdata['id_user']: 0;  
    }

    public function index()
    {
        $params[]= array();
        $params["title"]= "Configuraciones";
        $params["sub_title"]= "Configuraciones";

        $this->Debug_model->set_debug($this->id_user, "Configuraciones", "Solo entra en la pantalla");

        $this->load->view('init/header', $params);
        $this->load->view('configuraciones_view', $params);
        $this->load->view('init/footer'); 
    }
    
    public function set_configuraciones()
    {
        $postData= $this->input->post();
        $result= $this->set_update_configuraciones($postData);
        print_r($result);
    }

    public function get_configuraciones()
    {
        
        $result= $this->Configuraciones_model->get_configuraciones();
        print_r($result);
    }

    public function get_configuraciones_by_datatable()
    {
        $result= $this->Configuraciones_model->get_configuraciones_by_datatable($_REQUEST);
        print_r($result);
    }

    public function set_update_configuraciones($postData)
    {
        $result= $this->Configuraciones_model->set_update_configuraciones($postData);
        print_r($result);        
    }

    public function delete_configuraciones()
    {
        $result= $this->Configuraciones_model->delete_configuraciones($this->input->post()['id_configuraciones']);
        print_r($result);
    }
    
    public function undo_delete_configuraciones()
    {
        $result= $this->Configuraciones_model->undo_delete_configuraciones($this->input->post()['id_configuraciones']);
        print_r($result);
    }
    
}
