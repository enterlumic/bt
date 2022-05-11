<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comandos extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Comandos_model');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('UploadFiles');
        $this->id_user= isset($this->session->userdata['id_user'])? $this->session->userdata['id_user']: 0;  
    }

    public function index()
    {
        $params[]= array();
        $params["title"]= "Comandos";
        $params["sub_titulo"]= "Comandos";

        // // #Console
        $this->load->view('init/header', $params);
        $this->load->view('comandos_view');
        $this->load->view('init/footer'); 
    }
    
    public function set_comandos()
    {
        $postData= $this->input->post();

        if (is_array($_FILES) && !empty($_FILES))
        {
            $config['upload_path']= 'uploads/set_comandos/';
            $upload_files= $this->uploadfiles->upload($config);
            $postData= is_array($upload_files) && !empty($upload_files) ? array_merge($upload_files, $postData) : $postData;
        }

        if (isset($this->input->post()['id_comandos']) &&  $this->input->post()['id_comandos'] !== "")
        {
            $this->set_update_comandos($postData); return;
        }

        $result= $this->Comandos_model->set_comandos($postData);
        print_r($result);
    }

    public function set_log_comando()
    {
        print_r($this->Comandos_model->set_log_comando($this->input->post()));
        return;
    }

    public function get_comandos_by_id()
    {
        $result= $this->Comandos_model->get_comandos_by_id($this->input->post());
        print_r($result);
    }
    
    public function get_comandos_all()
    {
        $result= $this->Comandos_model->get_comandos_all($this->input->post());
        print_r($result);
    }
    
    public function get_comandos_all_by_id()
    {
        $result= $this->Comandos_model->get_comandos_all_by_id($this->input->post());
        print_r($result);
    }

    public function get_comandos_by_datatable()
    {
        $result= $this->Comandos_model->get_comandos_by_datatable($_REQUEST);
        print_r($result);
    }

    public function set_update_comandos($postData)
    {
        $result= $this->Comandos_model->set_update_comandos($postData);
        print_r($result);        
    }

    public function delete_comandos()
    {
        $result= $this->Comandos_model->delete_comandos($this->input->post()['id_comandos']);
        print_r($result);
    }
    
    public function undo_delete_comandos()
    {
        $result= $this->Comandos_model->undo_delete_comandos($this->input->post()['id_comandos']);
        print_r($result);
    }
    
}
