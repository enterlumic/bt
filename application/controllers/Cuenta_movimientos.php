<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cuenta_movimientos extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Cuenta_movimientos_model');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('UploadFiles');
        $this->id_user= isset($this->session->userdata['id_user'])? $this->session->userdata['id_user']: 0;  
    }

    public function index()
    {
        $params[]= array();
        $params["title"]= "Cuenta_movimientos";
        $params["sub_titulo"]= "Cuenta_movimientos";

        // // Test
        // $this->load->view('header', $params);
        // $this->load->view('cuenta_movimientos_view');
        // $this->load->view('footer');

        // #Console
        $this->load->view('init/header', $params);
        $this->load->view('cuenta_movimientos_view');
        $this->load->view('init/footer'); 
    }
    
    public function set_cuenta_movimientos()
    {
        $postData= $this->input->post();

        if (is_array($_FILES) && !empty($_FILES))
        {
            $config['upload_path']= 'uploads/set_cuenta_movimientos/';
            $upload_files= $this->uploadfiles->upload($config);
            $postData= is_array($upload_files) && !empty($upload_files) ? array_merge($upload_files, $postData) : $postData;
        }

        if (isset($this->input->post()['id']) &&  $this->input->post()['id'] !== "")
        {
            $this->set_update_cuenta_movimientos($postData); return;
        }

        $result= $this->Cuenta_movimientos_model->set_cuenta_movimientos($postData);
        print_r($result);
    }

    public function importar_cuenta_movimientos()
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
                                        ,"id_paypal"  => $value['B']
                                        ,"id_movimiento"  => $value['D']
                                        ,"tipo_movimiento"  => $value['C']
                                        ,"saldo_anterior"  => $value['E']
                                        ,"saldo_nuevo"  => $value['F']
                                        ,"importe"  => $value['G']
                                        ,"monto_total"  => $value['H']
                                        ,"titular_cuenta"  => $value['I']
                                        ,"refvc" => $value['J']
                        );
                    }
                }
            }

            $result= $this->Cuenta_movimientos_model->importar_cuenta_movimientos($arr);
            print_r($result);
        }
    }

    public function get_cuenta_movimientos_by_id()
    {
        
        $result= $this->Cuenta_movimientos_model->get_cuenta_movimientos_by_id($this->input->post());
        print_r($result);
    }

    public function get_cuenta_movimientos_by_datatable()
    {
        $result= $this->Cuenta_movimientos_model->get_cuenta_movimientos_by_datatable($_REQUEST);
        print_r($result);
    }

    public function set_update_cuenta_movimientos($postData)
    {
        $result= $this->Cuenta_movimientos_model->set_update_cuenta_movimientos($postData);
        print_r($result);        
    }

    public function delete_cuenta_movimientos()
    {
        $result= $this->Cuenta_movimientos_model->delete_cuenta_movimientos($this->input->post()['id']);
        print_r($result);
    }
    
    public function undo_delete_cuenta_movimientos()
    {
        $result= $this->Cuenta_movimientos_model->undo_delete_cuenta_movimientos($this->input->post()['id']);
        print_r($result);
    }
}
