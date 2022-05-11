<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qwe extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Qwe_model');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('UploadFiles');
        $this->id_user= isset($this->session->userdata['id_user'])? $this->session->userdata['id_user']: 0;  
    }

    public function index()
    {
        $params[]= array();
        $params["title"]= "Qwe";
        $params["sub_titulo"]= "Qwe";

        $this->Debug_model->set_debug($this->id_user, "Qwe", "Solo entra en la pantalla");

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://external.driv.in/api/external/v2/scenarios',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{ "description": "Escenario por API",
          "date": "2021-06-12",
          "fleet_name": null,
          "schema_name": "NO DEPOSIT",
           "clients":[
              {
                 "code":null,
                 "address":"La Oración 43",
                 "reference":"Departamento 208",
                 "city":"Las Condes",
                 "country":"Chile",
                 "lat":-33.401779,
                 "lng":-70.556216,
                 "name":"Dirección de Prueba",
                 "client_name":"Juan Perez",
                 "client_code":null,
                 "address_type":"Departamento",
                 "contact_name":"Juan Perez",
                 "contact_phone":"999999999",
                 "contact_email":"email@contacto.com",
                 "service_time":null,
                 "time_windows":[
                    {
                       "start":"09:00",
                       "end":"11:00"
                    }
                 ],
                 "tags":[
                 ],
                 "orders":[
                    {
                       "code":"00098765",
                       "alt_code":null,
                       "description":"Compra de prueba",
                       "units_1":null,
                       "units_2":null,
                       "units_3":null,
                       "position":null,
                       "vehicle_code":"NICO01",
                       "delivery_date":"2021-06-11",
                       "custom_1":null,
                       "custom_2":null,
                       "custom_3":null,
                       "suppler_code":null,
                          "items":[
                       {     "code": "99965234",
                             "description": "item de prueba",
                             "units":1,
                             "units_1": 3,
                             "units_2": null,
                             "units_3": null
                       },
                       {     "code": "999890923",
                             "description": "segundo item de prueba",
                             "units":3,
                             "units_1": 2,
                             "units_2": null,
                             "units_3": null
                       }
                          ]

                    }
                 ]
              },
              {
                 "code":null,
                 "address":"Felix de Amesti 157",
                 "reference":"Oficina 43 ",
                 "city":"Las Condes",
                 "country":"Chile",
                 "lat":-33.414839,
                 "lng":-70.582102,
                 "name":"Segunda Direccion de Prueba",
                 "client_name":"Diego Perez",
                 "client_code":null,
                 "address_type":"Oficina",
                 "contact_name":"Diego Perez",
                 "contact_phone":"888888888",
                 "contact_email":"email2@contacto.com",
                 "service_time":null,
                 "time_windows":[
                    {
                       "start":"10:00",
                       "end":"13:00"
                    }
                 ],
                 "tags":[
                    
                 ],
                 "orders":[
                    {
                       "code":"00089827",
                       "alt_code":null,
                       "description":"Segunda orden de compra de prueba",
                       "units_1":null,
                       "units_2":null,
                       "units_3":null,
                       "position":null,
                       "vehicle_code":"NICO01",
                       "delivery_date":"2021-06-11",
                       "custom_1":null,
                       "custom_2":null,
                       "custom_3":null,
                       "suppler_code":null,
                          "items":[
                       {     "code": "99973829",
                             "description": "item de prueba segundo cliente",
                             "units":1,
                             "units_1": 1,
                             "units_2": null,
                             "units_3": null
                       },
                       {     "code": "999890103",
                             "description": "item para segundo cliente de prueba",
                             "units":5,
                             "units_1": 2,
                             "units_2": null,
                             "units_3": null
                       }
                          ]

                    }
                 ]
              }
           ]
        }',
          CURLOPT_HTTPHEADER => array(
            'X-API-Key: {{api_key}}',
            'Content-Type: application/json'
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $qwe['qwe']=$response;

        // #Console
        $this->load->view('init/header', $params);
        $this->load->view('qwe_view', $qwe);
        $this->load->view('init/footer'); 
    }
    
    public function set_qwe()
    {
        $postData= $this->input->post();

        if (is_array($_FILES) && !empty($_FILES))
        {
            $config['upload_path']= 'uploads/set_qwe/';
            $upload_files= $this->uploadfiles->upload($config);
            $postData= is_array($upload_files) && !empty($upload_files) ? array_merge($upload_files, $postData) : $postData;
        }

        if (isset($this->input->post()['id_qwe']) &&  $this->input->post()['id_qwe'] !== "")
        {
            $this->set_update_qwe($postData); return;
        }

        $result= $this->Qwe_model->set_qwe($postData);
        print_r($result);
    }

    public function get_qwe_by_id()
    {
        
        $result= $this->Qwe_model->get_qwe_by_id($this->input->post());
        print_r($result);
    }

    public function get_qwe_by_datatable()
    {
        $result= $this->Qwe_model->get_qwe_by_datatable($_REQUEST);
        print_r($result);
    }

    public function set_update_qwe($postData)
    {
        $result= $this->Qwe_model->set_update_qwe($postData);
        print_r($result);        
    }

    public function delete_qwe()
    {
        $result= $this->Qwe_model->delete_qwe($this->input->post()['id_qwe']);
        print_r($result);
    }
    
    public function undo_delete_qwe()
    {
        $result= $this->Qwe_model->undo_delete_qwe($this->input->post()['id_qwe']);
        print_r($result);
    }
    
}
