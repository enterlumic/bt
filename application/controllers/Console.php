<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Console extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Console_model');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('UploadFiles');
        $this->id_user= isset($this->session->userdata['id_user'])? $this->session->userdata['id_user']: 0;  
    }

    public function index()
    {
        $params[]= array();
        $params["title"]= "Console";
        $params["sub_title"]= "Console";

        $this->Debug_model->set_debug($this->id_user, "Console", "Solo entra en la pantalla");

        $this->load->view('init/header', $params);
        $this->load->view('console_view', $params);
        $this->load->view('init/footer'); 
    }
    
    public function set_console()
    {
        $postData= $this->input->post();

        if (is_array($_FILES) && !empty($_FILES))
        {
            $config['upload_path']= 'uploads/set_console/';
            $upload_files= $this->uploadfiles->upload($config);
            $postData= is_array($upload_files) && !empty($upload_files) ? array_merge($upload_files, $postData) : $postData;
        }

        if (isset($this->input->post()['id_console']) &&  $this->input->post()['id_console'] !== "")
        {
            $this->set_update_console($postData); return;
        }

        $result= $this->Console_model->set_console($postData);
        print_r($result);
    }

    public function get_console_by_id()
    {
        
        $result= $this->Console_model->get_console_by_id($this->input->post());
        print_r($result);
    }

    public function get_console_by_datatable()
    {
        $result= $this->Console_model->get_console_by_datatable($_REQUEST);
        print_r($result);
    }

    public function set_update_console($postData)
    {
        $result= $this->Console_model->set_update_console($postData);
        print_r($result);        
    }

    public function delete_console()
    {
        $result= $this->Console_model->delete_console($this->input->post()['id_console']);
        print_r($result);
    }
    
    public function undo_delete_console()
    {
        $result= $this->Console_model->undo_delete_console($this->input->post()['id_console']);
        print_r($result);
    }
    
}
