<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
    private $id_user;

    public function __construct()
    { 
		parent::__construct();
		$this->load->helper('url');
        $this->load->library('session');
    } 

	public function index()
	{
		$params[]= array();
		$params["title"]= "Dashboard";

		$this->load->view('init/header', $params);
		$this->load->view('init/dashboard');
		$this->load->view('init/footer');
	}
}
