<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notas extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Notas_model');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('UploadFiles');
        $this->id_user= isset($this->session->userdata['id_user'])? $this->session->userdata['id_user']: 0;  
    }

    public function index()
    {
        $params[]= array();
        $params["title"]= "Notas";
        $params["sub_titulo"]= "Notas";

        $this->Debug_model->set_debug($this->id_user, "Notas", "Solo entra en la pantalla");

        // $this->load->view('system/header', $params);
        // $this->load->view('system/notas_view');
        // $this->load->view('system/footer');

        // $this->load->view('header', $params);
        // $this->load->view('notas_view');
        // $this->load->view('footer'); 

        $this->load->view('init/header', $params);
        $this->load->view('notas_view');
        $this->load->view('init/footer'); 
    }
    
    public function set_notas()
    {
        $postData= $this->input->post();

        if (is_array($_FILES) && !empty($_FILES))
        {
            $config['upload_path']= 'uploads/set_notas/';
            $upload_files= $this->uploadfiles->upload($config);
            $postData= is_array($upload_files) && !empty($upload_files) ? array_merge($upload_files, $postData) : $postData;
        }

        if (isset($this->input->post()['id_notas']) &&  $this->input->post()['id_notas'] !== "")
        {
            $this->set_update_notas($postData); return;
        }

        $result= $this->Notas_model->set_notas($postData);
        print_r($result);
    }

    public function get_notas_by_id()
    {
        
        $result= $this->Notas_model->get_notas_by_id($this->input->post());
        print_r($result);
    }

    public function get_notas_by_datatable()
    {
        $result= $this->Notas_model->get_notas_by_datatable($_REQUEST);
        print_r($result);
    }

    public function set_update_notas($postData)
    {
        $result= $this->Notas_model->set_update_notas($postData);
        print_r($result);        
    }

    public function delete_notas()
    {
        $result= $this->Notas_model->delete_notas($this->input->post()['id_notas']);
        print_r($result);
    }
    
    public function undo_delete_notas()
    {
        $result= $this->Notas_model->undo_delete_notas($this->input->post()['id_notas']);
        print_r($result);
    }
    
}
