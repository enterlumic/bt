<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_by_lumic extends CI_Controller {

    public function __construct()
    {
		parent::__construct();
        $this->load->model('Api_by_lumic_model');
		$this->load->library('session');
        $this->load->helper('url');
    } 

	public function index()
	{
		$data['x'] = $this->Api_by_lumic_model->get_api_by_lumic();
		
		$params[]= array();
		$params["title"]= "api_by_lumic";
		$this->load->view('header', $params);
		$this->load->view('api_by_lumic_view', $data);
		$this->load->view('footer');
	}

	public function set_api_by_lumic()
	{
		$result= $this->Api_by_lumic_model->set_api_by_lumic($this->input->post());
		print_r($result);        
	}

	public function api_by_id()
	{
		$result= $this->Api_by_lumic_model->api_by_id($this->input->post());
		print_r($result);        
	}

	public function get_api_by_lumic()
	{
		$get_api_by_lumic= $this->Api_by_lumic_model->get_api_by_lumic();
		$get_api_by_lumic= json_decode($get_api_by_lumic, true);

        if (is_array($get_api_by_lumic) && !empty($get_api_by_lumic)){

			foreach ($get_api_by_lumic as $key => $value) {
				$data[]= array(	$value["id"]
					, $value["vc_name"]
				);
			}
			print_r(json_encode(array("data"=>$data)));
		}else{
            print_r(json_encode(array("data"=>""))); 
            return ;
        }
	}

	public function set_update_api_by_lumic()
	{
		$result= $this->Api_by_lumic_model->set_update_api_by_lumic($this->input->post());
		print_r($result);        
	}
	
	public function delete_api_by_lumic()
	{
		$result= $this->Api_by_lumic_model->delete_api_by_lumic($this->input->post()['id']);
		print_r($result);
	}

	public function reset_api()
	{
		$result= $this->Api_by_lumic_model->reset_api();
		print_r($result);
	}
	
	public function undo_delete_api_by_lumic()
	{
		$result= $this->Api_by_lumic_model->undo_delete_api_by_lumic($this->input->post()['id']);
		print_r($result);
	}

	public function guardar_sh()
	{
		file_put_contents("sh/sh.sh", $this->input->post()['textSSH']);
		echo shell_exec('/var/www/html/console/sh/sh.sh');
	}

	public function dump_bd()
	{
		$dump= $this->input->post()['dump'];
		$dump= str_replace("&gt;", ">", $dump);
		
		$get_rehacerSP= file_get_contents('sh/dump.sh');
		$str_replace= "grep -wrl 'DEFINER=`u733136234_console`@`%`' /var/www/html/console/bd.sql | xargs sed -i 's/DEFINER=`u733136234_console`@`%`//g';";
		file_put_contents('sh/dump.sh', $get_rehacerSP."\n".$str_replace , FILE_APPEND);
		$r= shell_exec('/var/www/html/console/sh/dump.sh');
		echo $dump;
	}

	public function RunSQL()
	{
		$RunSQL= $this->input->post()['RunSQL'];
		$RunSQL= str_replace("&lt;", "<", $RunSQL);
		file_put_contents("sh/RunSQL.sh", $RunSQL ."\n");
		$r= shell_exec('/var/www/html/console/sh/RunSQL.sh');
		echo $r;
	}

	public function rehacerSP()
	{
		$rehacerSP= $this->input->post()['rehacerSP'];
		$rehacerSP= str_replace("&lt;", "<", $rehacerSP);
		file_put_contents("sh/rehacerSP.sh", $rehacerSP ."\n");
		
		$get_rehacerSP= file_get_contents('sh/rehacerSP.sh');
		$str_replace= "grep -wrl 'DEFINER=`u733136234_console`@`%`' /var/www/html/console/bd.sql | xargs sed -i 's/DEFINER=`u733136234_console`@`%`//g';";
		file_put_contents('sh/rehacerSP.sh', $get_rehacerSP."\n".$str_replace ,FILE_APPEND);

		$r= shell_exec('/var/www/html/console/sh/rehacerSP.sh');
		echo $r;
	}

	public function eliminar_proyecto()
	{
		$rm= "cd /var/www/html/".$this->input->post()['proyecto']." \n find -iname *".$this->input->post()['fileName']."*  -type f -exec rm {} \\;";
		file_put_contents("sh/del.sh", $rm );
		shell_exec('/var/www/html/console/sh/del.sh');
	}

	public function eliminar_bd()
	{
		$nombre_tabla= $this->input->post()['nombre_tabla'];
		$sql= "	mysql -u adminBD -pF4I6^\\\$BDC-aEonn9 -e 'USE ".$this->input->post()['proyecto']."; DROP TABLE IF EXISTS tbl_".$nombre_tabla."; DROP PROCEDURE IF EXISTS sp_delete_".$nombre_tabla."; DROP PROCEDURE IF EXISTS sp_get_".$nombre_tabla.";  DROP PROCEDURE IF EXISTS sp_get_".$nombre_tabla."_by_id; DROP PROCEDURE IF EXISTS sp_set_update_".$nombre_tabla."; DROP PROCEDURE IF EXISTS sp_set_".$nombre_tabla."; DROP PROCEDURE IF EXISTS sp_undo_delete_".$nombre_tabla."; DROP PROCEDURE IF EXISTS sp_set_importar_".$nombre_tabla."; ';";

		file_put_contents("sh/delBD.sh", $sql );
		shell_exec('/var/www/html/console/sh/delBD.sh');
	}

}
