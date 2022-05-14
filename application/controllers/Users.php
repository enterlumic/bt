<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Users_model');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('UploadFiles');
        $this->id_user= isset($this->session->userdata['id_user'])? $this->session->userdata['id_user']: 0;  
    }

    public function index()
    {
        $params[]= array();
        $params["title"]= "Users";
        $params["sub_titulo"]= "Users";

        // // Test
        // $this->load->view('header', $params);
        // $this->load->view('users_view');
        // $this->load->view('footer');

        // #Console
        $this->load->view('init/header', $params);
        $this->load->view('users_view');
        $this->load->view('init/footer'); 
    }
    
    public function set_users()
    {
        $postData= $this->input->post();

        if (is_array($_FILES) && !empty($_FILES))
        {
            $config['upload_path']= 'uploads/set_users/';
            $upload_files= $this->uploadfiles->upload($config);
            $postData= is_array($upload_files) && !empty($upload_files) ? array_merge($upload_files, $postData) : $postData;
        }

        if (isset($this->input->post()['id']) &&  $this->input->post()['id'] !== "")
        {
            $this->set_update_users($postData); return;
        }

        $result= $this->Users_model->set_users($postData);
        print_r($result);
    }

    public function importar_users()
    {
        if (file_exists($this->input->post()['path']))
        {
            $reader = new Xlsx();
            $spreadsheet = $reader->load($this->input->post()['path']);
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

            if (is_array($sheetData) && count($sheetData) > 0)
            {
                unset($arr);
                foreach ($sheetData as $key => $value)
                {
                    if ($key > 2 && !empty($value['A']))
                    {
                        $arr[]= array(   "name"  => $value['A']
                                        ,"apellido"  => $value['B']
                                        ,"email"  => $value['D']
                                        ,"email_verified_at"  => $value['C']
                                        ,"password"  => $value['E']
                                        ,"pass_crypt"  => $value['F']
                                        ,"referido"  => $value['G']
                                        ,"myrefcode"  => $value['H']
                                        ,"admin"  => $value['I']
                                        ,"telefono" => $value['J']
                        );
                    }
                }
            }

            $result= $this->Users_model->importar_users($arr);
            print_r($result);
        }
    }

    public function get_users_by_id()
    {
        
        $result= $this->Users_model->get_users_by_id($this->input->post());
        print_r($result);
    }

    public function get_users_by_datatable()
    {
        $result= $this->Users_model->get_users_by_datatable($_REQUEST);
        print_r($result);
    }

    public function set_update_users($postData)
    {
        $result= $this->Users_model->set_update_users($postData);
        print_r($result);        
    }

    public function delete_users()
    {
        $result= $this->Users_model->delete_users($this->input->post()['id']);
        print_r($result);
    }
    
    public function undo_delete_users()
    {
        $result= $this->Users_model->undo_delete_users($this->input->post()['id']);
        print_r($result);
    }
}
