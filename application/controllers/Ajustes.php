<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajustes extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Ajustes_model');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('UploadFiles');
        $this->id_user= isset($this->session->userdata['id_user'])? $this->session->userdata['id_user']: 0;  
    }

    public function index()
    {
        $params[]= array();
        $params["title"]= "Ajustes";
        $params["sub_titulo"]= "Ajustes";

        // // Test
        // $this->load->view('header', $params);
        // $this->load->view('ajustes_view');
        // $this->load->view('footer');

        // #Console
        $this->load->view('init/header', $params);
        $this->load->view('ajustes_view');
        $this->load->view('init/footer'); 
    }
    
    public function set_ajustes()
    {
        $postData= $this->input->post();

        if (is_array($_FILES) && !empty($_FILES))
        {
            $config['upload_path']= 'uploads/set_ajustes/';
            $upload_files= $this->uploadfiles->upload($config);
            $postData= is_array($upload_files) && !empty($upload_files) ? array_merge($upload_files, $postData) : $postData;
        }

        if (isset($this->input->post()['id']) &&  $this->input->post()['id'] !== "")
        {
            $this->set_update_ajustes($postData); return;
        }

        $result= $this->Ajustes_model->set_ajustes($postData);
        print_r($result);
    }

    public function importar_ajustes()
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
                        $arr[]= array(   "nombre"  => $value['A']
                                        ,"valor"  => $value['B']
                                        ,"valor_encrypt"  => $value['D']
                                        ,"descripcion"  => $value['C']
                                        ,"activo"  => $value['E']
                                        ,"creado"  => $value['F']
                                        ,"creado_por"  => $value['G']
                                        ,"modificado"  => $value['H']
                                        ,"modificado_por"  => $value['I']
                                        ,"vCampo10_ajustes" => $value['J']
                        );
                    }
                }
            }

            $result= $this->Ajustes_model->importar_ajustes($arr);
            print_r($result);
        }
    }

    public function get_ajustes_by_id()
    {
        
        $result= $this->Ajustes_model->get_ajustes_by_id($this->input->post());
        print_r($result);
    }

    public function get_ajustes_by_datatable()
    {
        $result= $this->Ajustes_model->get_ajustes_by_datatable($_REQUEST);
        print_r($result);
    }

    public function set_update_ajustes($postData)
    {
        $result= $this->Ajustes_model->set_update_ajustes($postData);
        print_r($result);        
    }

    public function delete_ajustes()
    {
        $result= $this->Ajustes_model->delete_ajustes($this->input->post()['id']);
        print_r($result);
    }
    
    public function undo_delete_ajustes()
    {
        $result= $this->Ajustes_model->undo_delete_ajustes($this->input->post()['id']);
        print_r($result);
    }
}
