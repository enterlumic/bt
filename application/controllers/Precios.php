<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Precios extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Precios_model');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('UploadFiles');
        $this->id_user= isset($this->session->userdata['id_user'])? $this->session->userdata['id_user']: 0;  
    }

    public function index()
    {
        $params[]= array();
        $params["title"]= "Precios";
        $params["sub_titulo"]= "Precios";

        // // Test
        // $this->load->view('header', $params);
        // $this->load->view('precios_view');
        // $this->load->view('footer');

        // #Console
        $this->load->view('init/header', $params);
        $this->load->view('precios_view');
        $this->load->view('init/footer'); 
    }
    
    public function set_precios()
    {
        $postData= $this->input->post();

        if (is_array($_FILES) && !empty($_FILES))
        {
            $config['upload_path']= 'uploads/set_precios/';
            $upload_files= $this->uploadfiles->upload($config);
            $postData= is_array($upload_files) && !empty($upload_files) ? array_merge($upload_files, $postData) : $postData;
        }

        if (isset($this->input->post()['id']) &&  $this->input->post()['id'] !== "")
        {
            $this->set_update_precios($postData); return;
        }

        $result= $this->Precios_model->set_precios($postData);
        print_r($result);
    }

    public function importar_precios()
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
                        $arr[]= array(   "IdTipoEnvio"  => $value['A']
                                        ,"Precio"  => $value['B']
                                        ,"PesoInicio"  => $value['D']
                                        ,"PesoFin"  => $value['C']
                                        ,"MedidaMaxima"  => $value['E']
                                        ,"DimensionMaxima"  => $value['F']
                                        ,"costo_extra_kg"  => $value['G']
                                        ,"peso_maximo"  => $value['H']
                                        ,"Activo"  => $value['I']
                                        ,"Creado" => $value['J']
                        );
                    }
                }
            }

            $result= $this->Precios_model->importar_precios($arr);
            print_r($result);
        }
    }

    public function get_precios_by_id()
    {
        
        $result= $this->Precios_model->get_precios_by_id($this->input->post());
        print_r($result);
    }

    public function get_precios_by_datatable()
    {
        $result= $this->Precios_model->get_precios_by_datatable($_REQUEST);
        print_r($result);
    }

    public function set_update_precios($postData)
    {
        $result= $this->Precios_model->set_update_precios($postData);
        print_r($result);        
    }

    public function delete_precios()
    {
        $result= $this->Precios_model->delete_precios($this->input->post()['id']);
        print_r($result);
    }
    
    public function undo_delete_precios()
    {
        $result= $this->Precios_model->undo_delete_precios($this->input->post()['id']);
        print_r($result);
    }
}
