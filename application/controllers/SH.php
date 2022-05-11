<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SH extends CI_Controller {
	
	public function dump_bd_local()
	{
		$dump= $this->input->post()['dump'];		
		$str_replace=  "grep -wrl 'DEFINER=`u733136234_console`@`%`' /var/www/html/console/bd.sql | xargs sed -i 's/DEFINER=`u733136234_console`@`%`//g';" ."\n";
		$str_replace.= "grep -wrl 'DEFINER=`adminBD`@`%`' /var/www/html/console/bd.sql | xargs sed -i 's/DEFINER=`adminBD`@`%`//g';" . "\n";

		file_put_contents("sh/dump_bd_local.sh", $dump . $str_replace);
		$r= shell_exec('/var/www/html/console/sh/dump_bd_local.sh');
		echo $r;
	}

	public function ejecutar_sql_local()
	{
		$dump= $this->input->post()['dump'];		
		file_put_contents("sh/ejecutar_sql_local.sh", $dump ."\n");
		$r= shell_exec('/var/www/html/console/sh/ejecutar_sql_local.sh');
		echo $r;
	}

	public function rehacer_bd_local()
	{
		$dump= $this->input->post()['dump'];		
		file_put_contents("sh/rehacer_bd_local.sh", $dump ."\n");
		$r= shell_exec('/var/www/html/console/sh/rehacer_bd_local.sh');
		echo $r;
	}
}
