<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Core_controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Api_by_lumic_model');
    }

    public function APPLICATION_EXECUTE()
    {

        $name_ucfirst     = isset($this->input->post()['name_strtolower']) && !empty($this->input->post()['name_strtolower']) 
                            ? strtolower($this->input->post()['name_strtolower']) : "";
        
        $name_strtolower  = isset($this->input->post()['name_strtolower']) && !empty($this->input->post()['name_strtolower']) 
        ? strtolower($this->input->post()['name_strtolower']) : "";

        $tipo             = isset($this->input->post()['tipo'])       && !empty($this->input->post()['tipo'])       ? strtolower($this->input->post()['tipo']): "form5";
        $controller       = isset($this->input->post()['controller']) && !empty($this->input->post()['controller']) ? $name_strtolower: "";
        $model            = isset($this->input->post()['model'])      && !empty($this->input->post()['model'])      ? $name_strtolower : "";
        $view             = isset($this->input->post()['view'])       && !empty($this->input->post()['view'])       ? $name_strtolower : "";
        $js               = isset($this->input->post()['js'])         && !empty($this->input->post()['js'])         ? $name_strtolower : "";
        $proyecto                  = preg_replace("/[^a-zA-Z0-9]+/", "", $this->input->post()['proyecto']);
        $param                     = array();
        $param["tipo"]             = $tipo;
        $param["proyecto"]         = $proyecto;
        $param["model"]            = strtolower($model);
        $param["view"]             = ucfirst($view) . "_view";
        $param["title"]            = ucfirst($view) . "";
        $param["controller"]       = strtolower($controller);
        $param["name_strtolower"]  = strtolower($name_strtolower);
        $param["name_ucfirst"]     = ucfirst($name_ucfirst);

        if($proyecto === "teiker")
        {
            $proyecto= "../teiker";

            $param["file_view"]       = $proyecto."/resources/views/".$view.".blade.php";
            $param["file_js"]         = $proyecto."/public/js/".$js.".js";
            $param["file_controller"] = $proyecto."/app/Http/Controllers/".ucfirst($controller)."Controller.php";
            $param["bd"]="";

            $bd="";
            $file_model="";
            $file_bd="";
            $API_BD="";

            if ( !file_exists($param["file_controller"]) && !empty($controller) )
                $this->create_controller_laravel($param);

            if ( !file_exists($param["file_js"]) )
                $this->create_js_laravel($param);

            if ( !file_exists($param["file_view"]) )
                $this->create_view_laravel($param);

            $this->save_files_created($param);

            $rm= "cd /var/www/html/teiker \n php artisan make:migration ".$view." ";
            file_put_contents("sh/LarabelMigrate.sh", $rm );
            shell_exec('/var/www/html/console/sh/LarabelMigrate.sh');            

            print_r(json_encode($param));

            return;
        }

        if($proyecto === "TeikerQA")
        {
            $proyecto= "../Teiker_qa";

            $param["file_view"]       = $proyecto."/resources/views/".$view.".blade.php";
            $param["file_js"]         = $proyecto."/public/js/".$js.".js";
            $param["file_controller"] = $proyecto."/app/Http/Controllers/".ucfirst($controller)."Controller.php";
            $param["bd"]="";

            $bd="";
            $file_model="";
            $file_bd="";
            $API_BD="";

            if ( !file_exists($param["file_controller"]) && !empty($controller) )
                $this->create_controller_laravel($param);

            if ( !file_exists($param["file_js"]) )
                $this->create_js_laravel($param);

            if ( !file_exists($param["file_view"]) )
                $this->create_view_laravel($param);

            $this->save_files_created($param);

            $migration= "cd /var/www/html/Teiker_qa\nphp artisan make:migration ".$view." ";
            file_put_contents("sh/LarabelMigrate.sh", $migration );
            $execute= shell_exec('/var/www/html/console/sh/LarabelMigrate.sh');            

            print_r(json_encode($execute));

            return;
        }

        if($proyecto === "test")
        {   
            $proyecto= "../test";
            $file_model        = $proyecto."/application/models/".ucfirst($model)."_model.php";
            $file_view         = $proyecto."/application/views/".$view."_view.php";
            $file_controller   = $proyecto."/application/controllers/".ucfirst($controller).".php";
            $file_js           = $proyecto."/files/assets/js/lumic/".$js.".js";
            $file_bd           = $proyecto."/API_BD/new_bd.sql";
            $API_BD            = $proyecto."/API_BD/" . strtolower($name_strtolower) . ".sql";
            $bd                ="test";
            $proyecto= "test";
        }

        if($proyecto === "console")
        {
            $proyecto          = "console";
            $file_model        = "application/models/".ucfirst($model)."_model.php";
            $file_view         = "application/views/".$view."_view.php";
            $file_controller   = "application/controllers/".ucfirst($controller).".php";
            $file_js           = "assets/js/lumic/".$js.".js";
            $file_bd           = "API_BD/new_bd.sql";
            $API_BD            = "API_BD/" . strtolower($name_strtolower) . ".sql";            
            $bd                = "console";
            $proyecto          = "console";
        }

        $param["bd"]               = $bd;
        $param["file_model"]       = $file_model;
        $param["file_view"]        = $file_view;
        $param["file_controller"]  = $file_controller;
        $param["js"]               = $js;
        $param["file_js"]          = $file_js;
        $param["file_bd"]          = $file_bd;
        $param["API_BD"]           = $API_BD;
        $param["rehacer_bd"]       = $this->input->post()['rehacer_bd'];

        // Crear controller
        if ( !file_exists($file_controller) && !empty($controller) )
            $this->create_controller($param);

        // Crear model
        if ( !file_exists($file_model) && !empty($model) )
            $this->create_model($param);
            
        // Crear view
        if ( !file_exists($file_view) && !empty($view) )
            $this->create_view($param);

        // Crear js
        if ( !file_exists($file_js) && !empty($js) )
            $this->create_js($param);

        // CREAR BD
        if ( isset($this->input->post()['sql'])&& !empty($this->input->post()['sql']) )        
            $this->create_bd($param);

        $this->save_files_created($param);

        print_r(json_encode($param));
    }

 
    public function create_controller_laravel($param)
    {
        $file_controller = fopen($param["file_controller"], "w") or die("Unable to open file file_controller AA");
        $tipo= isset($param['tipo']) ? $param['tipo']. "/" : "";

        $param["proyecto"]= str_replace("../", "", $param["proyecto"]);

        $script = file_get_contents("../maquila/Teiker_qa/maquila_controller.php");

        $script = str_replace("%name_ucfirst%", $param["name_ucfirst"], $script);
        $script = str_replace("%name_strtolower%", $param["name_strtolower"], $script);
        $script = str_replace("%name_view%", $param["name_strtolower"], $script);
        
        fwrite($file_controller, $script);
        chmod($param["file_controller"] ,0777);
    }

    public function create_controller($param)
    {
        $file_controller = fopen($param["file_controller"], "w") or die("Unable to open file file_controller!");
        $tipo= isset($param['tipo']) ? $param['tipo']. "/" : "";

        $param["proyecto"]= str_replace("../", "", $param["proyecto"]);

        $script = file_get_contents("../maquila/maquila_controller.php");

        $script = str_replace("%name_ucfirst%", $param["name_ucfirst"], $script);
        $script = str_replace("%name_strtolower%", $param["name_strtolower"], $script);
        $script = str_replace("%name_view%", $param["name_strtolower"], $script);

        fwrite($file_controller, $script);
        chmod($param["file_controller"] ,0777);
    }

    public function create_model($param)
    {
        $file_model = fopen($param["file_model"], "w") or die("Unable to open file file_model!");
        $tipo= isset($param['tipo']) ? $param['tipo']. "/" : "";

        $param["proyecto"]= str_replace("../", "", $param["proyecto"]);
        $script = file_get_contents("../maquila/maquila_model.php");
        
        $script = str_replace("%name_ucfirst%", $param["name_ucfirst"], $script);
        $script = str_replace("%name_strtolower%", $param["name_strtolower"], $script);

        fwrite($file_model, $script);
        chmod($param["file_model"] ,0777);
    }

    public function create_view($param)
    {
        $tipo= $param['tipo'] . "/";        
        $param["proyecto"]= str_replace("../", "", $param["proyecto"]);
        $file_view = fopen($param["file_view"], "w") or die("Unable to open file file_view!");
        $script = file_get_contents("../maquila/". $param["proyecto"] ."/maquila_view.php");
        $script = str_replace("%name_strtolower%", $param["name_strtolower"], $script);
        $script = str_replace("%name_ucfirst%", $param["name_ucfirst"], $script);

        fwrite($file_view, $script);
        chmod($param["file_view"] ,0777);
    }

    public function create_view_laravel($param)
    {
        $tipo= $param['tipo'] . "/";        
        $param["proyecto"]= str_replace("../", "", $param["proyecto"]);
        $file_view = fopen($param["file_view"], "w") or die("Unable to open file file_view!");
        $script = file_get_contents("../maquila/teiker/maquila_view.php");
        $script = str_replace("%name_strtolower%", $param["name_strtolower"], $script);
        $script = str_replace("%name_ucfirst%", $param["name_ucfirst"], $script);

        fwrite($file_view, $script);
        chmod($param["file_view"] ,0777);
    }

    public function create_js($param)
    {

        $file_js = fopen($param["file_js"], "w") or die("Unable to open file file_js!");
        $tipo= isset($param['tipo']) ? $param['tipo']. "/" : "";

        $param["proyecto"]= str_replace("../", "", $param["proyecto"]);

        $script = file_get_contents("../maquila/maquila_js.js");
        
        $script = str_replace("%name_ucfirst%", $param["name_ucfirst"], $script);
        $script = str_replace("%name_strtolower%", $param["name_strtolower"], $script);
        $script = str_replace("%name_view%", $param["name_strtolower"], $script);
        
        fwrite($file_js, $script);
        chmod($param["file_js"] ,0777);
    }

    public function create_js_laravel($param)
    {

        $file_js = fopen($param["file_js"], "w") or die("Unable to open file file_js!");
        $tipo= isset($param['tipo']) ? $param['tipo']. "/" : "";

        $param["proyecto"]= str_replace("../", "", $param["proyecto"]);
        $script = file_get_contents("../maquila/teiker/maquila_js.js");
        $script = str_replace("%name_ucfirst%", $param["name_ucfirst"], $script);
        $script = str_replace("%name_strtolower%", $param["name_strtolower"], $script);
        $script = str_replace("%name_view%", $param["name_strtolower"], $script);
        
        fwrite($file_js, $script);
        chmod($param["file_js"] ,0777);
    }

    public function create_bd($param)
    {
        $file_bd = fopen($param["file_bd"], "w") or die("Unable to open file file_bd!" );
        $param["proyecto"]= str_replace("../", "", $param["proyecto"]);

        $script = file_get_contents("API_BD/bd.sql");
        $script = str_replace("%name_strtolower%", $param["name_strtolower"], $script);

        fwrite($file_bd, $script);

        copy($param["file_bd"], $param['API_BD']);

        if ($param['bd'] == 'test')
            $param['bd']= 'u733136234_test';

        if ($param['bd'] == 'console')
            $param['bd']= 'u733136234_console';

        $proyecto=  $param['proyecto'] == 'abogadosAdmin'? 'abogados': $param['proyecto'];

        $rm= "mysql -u adminBD -pF4I6^\\\$BDC-aEonn9 ".$param['bd']." < /var/www/html/".$proyecto."/API_BD/".$param["name_strtolower"].".sql";

        file_put_contents("sh/crearBD.sh", $rm );

        shell_exec('/var/www/html/console/sh/crearBD.sh');
    }

    public function save_files_created($postData)
    {
        $this->Api_by_lumic_model->set_api_by_lumic($postData);
    }

}


?>
