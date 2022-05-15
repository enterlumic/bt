<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Direccion_woocommerce extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Direccion_woocommerce_model');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('UploadFiles');
        $this->id_user= isset($this->session->userdata['id_user'])? $this->session->userdata['id_user']: 0;  
    }

    public function index()
    {
        $params[]= array();
        $params["title"]= "Direccion_woocommerce";
        $params["sub_titulo"]= "Direccion_woocommerce";

        // // Test
        // $this->load->view('header', $params);
        // $this->load->view('direccion_woocommerce_view');
        // $this->load->view('footer');

        // #Console
        $this->load->view('init/header', $params);
        $this->load->view('direccion_woocommerce_view');
        $this->load->view('init/footer'); 
    }
    
    public function set_direccion_woocommerce()
    {
        $postData= $this->input->post();

        if (is_array($_FILES) && !empty($_FILES))
        {
            $config['upload_path']= 'uploads/set_direccion_woocommerce/';
            $upload_files= $this->uploadfiles->upload($config);
            $postData= is_array($upload_files) && !empty($upload_files) ? array_merge($upload_files, $postData) : $postData;
        }

        if (isset($this->input->post()['id']) &&  $this->input->post()['id'] !== "")
        {
            $this->set_update_direccion_woocommerce($postData); return;
        }

        $result= $this->Direccion_woocommerce_model->set_direccion_woocommerce($postData);
        print_r($result);
    }

    public function importar_direccion_woocommerce()
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
                        $arr[]= array(   "id_cliente"  => $value['A']
                                        ,"url"  => $value['B']
                                        ,"nombre"  => $value['D']
                                        ,"empresa"  => $value['C']
                                        ,"correo"  => $value['E']
                                        ,"telefono"  => $value['F']
                                        ,"calle"  => $value['G']
                                        ,"colonia"  => $value['H']
                                        ,"ciudad"  => $value['I']
                                        ,"codigo_postal" => $value['J']
                        );
                    }
                }
            }

            $result= $this->Direccion_woocommerce_model->importar_direccion_woocommerce($arr);
            print_r($result);
        }
    }

    public function get_direccion_woocommerce_by_id()
    {
        
        $result= $this->Direccion_woocommerce_model->get_direccion_woocommerce_by_id($this->input->post());
        print_r($result);
    }

    public function get_direccion_woocommerce_by_datatable()
    {
        $result= $this->Direccion_woocommerce_model->get_direccion_woocommerce_by_datatable($_REQUEST);
        print_r($result);
    }

    public function set_update_direccion_woocommerce($postData)
    {
        $result= $this->Direccion_woocommerce_model->set_update_direccion_woocommerce($postData);
        print_r($result);        
    }

    public function delete_direccion_woocommerce()
    {
        $result= $this->Direccion_woocommerce_model->delete_direccion_woocommerce($this->input->post()['id']);
        print_r($result);
    }
    
    public function undo_delete_direccion_woocommerce()
    {
        $result= $this->Direccion_woocommerce_model->undo_delete_direccion_woocommerce($this->input->post()['id']);
        print_r($result);
    }
}
