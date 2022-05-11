<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Debug extends CI_Controller 
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('debug_model');
        $this->load->library('session');        
        $this->load->helper('url');
    }

    public function index()
    {
        $this->load->view('init/header', $params);
        $this->load->view('debug_view');
        $this->load->view('init/footer');         
    }

    public function reset_debug()
    {
        $this->debug_model->reset_debug();  
    }

    public function get_debug()
    {
        $postData= $_REQUEST;
        $get_Debug= $this->debug_model->getDataDynamic(
                          "tbl_debug"
                        , isset($postData['search']['value']) && !empty($postData['search']['value']) ? true:false
                        , addslashes($postData['search']['value'])
                        , $postData['start']
                        , $postData['length']
                        , $postData["order"][0]["column"]
                        , $postData["order"][0]["dir"]
                    );

        $get_Debug= json_decode($get_Debug, true);
    
        if (is_array($get_Debug) && !empty($get_Debug))
        {
            $get_Debug=$get_Debug["data"];
            
            foreach ($get_Debug as $key => $value) 
            {
                $data[]= array( $value["id"]
                              , $value["vc_email"]
                              , $value["vc_query"]
                              , $value["dt_request"]
                              , $value["vc_event"]
                );
            }

            $totalRecords="SELECT COUNT(*) AS TOTAL FROM tbl_debug";
            $totalRecords= $this->db->query($totalRecords)->result();
            $totalRecords=($totalRecords[0]->TOTAL) <= 0 ? 1 : $totalRecords[0]->TOTAL;

            if(count($data) <=0)
            {
               print_r(json_encode(array("data"=>""))); 
               return ;
            }
                        
            $json_data = array(
                "draw"            => intval( $postData['draw'] ),   
                "recordsTotal"    => intval( $totalRecords ),  
                "recordsFiltered" => intval( $totalRecords ),
                "data"            => $data
            );

            print_r(json_encode($json_data));
        }
        else
        {
           print_r(json_encode(array("data"=>""))); 
           return ;
        }
    }


}



