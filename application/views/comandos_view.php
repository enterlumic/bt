
<div class="col-sm-12">
    <div class="card">
        <?php
        require 'vendor/autoload.php';
        use Luecano\NumeroALetras\NumeroALetras;

        $formatter = new NumeroALetras();
        $formatter->conector = 'Y';
        // echo $formatter->toMoney(450.50, 2, 'pesos', 'centavos');
        ?>
        <div class="card-body">
            <div class="row align-items-center m-l-0">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-6 text-right">
                    <a href="#modal_form_comandos" data-toggle="modal" class="btn btn-nuevo btn-sm btn-primary float-right agregar-comandos">+ Nuevo</a>
                    <a href="javascript:void(0);" id="actualizar-tbl-comandos" class="btn btn-sm btn-success pull-right float-right m-r-10">Actualizar</a>
                </div>
            </div>
            <div class="dt-responsive table-responsive">
                <table id="tb-datatable-comandos"class="table table-dark table-striped table-bordered nowrap" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th >id</th>
                            <th >Atajo teclado</th>
                            <th >Comando</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="box-lumic">
    <div class="modal fade" id="modal_form_comandos">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form class="form-material form-action-post" action="#comandos" id="form_comandos" method="post">
                    <div class="modal-body">
                        <div class="form-group form-primary">
                            <label class="float-label">Atajo teclado</label>
                            <span class="form-bar"></span>
                            <input type="text" class="form-control form-control-capitalize" id="vc_atajo_teclado" name="vc_atajo_teclado" required>
                        </div>
                        <div class="form-group form-primary">
                            <label class="float-label">Comando</label>
                            <span class="form-bar"></span>
                            <textarea id="vc_comando" name="vc_comando" class="form-control" rows="2" ></textarea>
                        </div>
                        <div class="form-group form-primary">
                            <label class="float-label">Comentarios</label>
                            <span class="form-bar"></span>
                            <textarea id="vc_comentario" name="vc_comentario" class="form-control" rows="2" ></textarea>
                        </div>
                        <div class="form-group form-primary">
                            <label class="float-label">Script</label>
                            <span class="form-bar"></span>
                            <input type="text" class="form-control" id="vc_path_script" name="vc_path_script" >
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-action-form">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/lumic/comandos.js?<?php echo rand()?>"></script>














<script>
  $(function () {
    Comandos.datatable_Comandos();
    Comandos.set_Comandos();

        let url;
        url= "https://api.eposnowhq.com/api/v4/Device";
        url= "https://api.eposnowhq.com/api/v4/Transaction";
        url= "https://api.eposnowhq.com/api/V2/DailySales/ProductID";
        url= "https://api.eposnowhq.com/api/v4/Product";

        var request = {
            url: url,
            type: "GET",
            contentType: "application/json",
            accepts: "application/json",
            dataType: 'json',
            crossDomain: true,
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Authorization", "Basic " + "STM4WjVRMTNHUVJXMjZTV0owVkI2NTdYTzVBOURJVTE6MENLR1VTUUc1UUlBVDNHSzcxSUZGTVhLVkZTUEJISE4=");
            },
            success: function(data) {
                console.log("data", data);
            },
            error: function (jqXHR) {
                console.log("ajax error " + jqXHR.status);
            }
        };
        
        $.ajax(request);

  });
</script>


<?php

// Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
// $ch = curl_init();

// curl_setopt($ch, CURLOPT_URL, 'https://api.eposnowhq.com/api/v4/Product');
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


// $headers = array();
// $headers[] = 'Content-Type: application/json';
// $headers[] = 'Authorization: Basic STM4WjVRMTNHUVJXMjZTV0owVkI2NTdYTzVBOURJVTE6MENLR1VTUUc1UUlBVDNHSzcxSUZGTVhLVkZTUEJISE4=';
// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// $result = curl_exec($ch);
// if (curl_errno($ch)) {
//     echo 'Error:' . curl_error($ch);
// }
// curl_close($ch);

// $result= json_decode($result, true);


// foreach($result as $key=>$value){
//     print_r($value['Id']) ."\n";
// }

// $ch = curl_init();

// curl_setopt($ch, CURLOPT_URL, 'https://api.eposnowhq.com/api/V2/DailySales/ProductID');
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


// $headers = array();
// $headers[] = 'Content-Type: application/json';
// $headers[] = 'Authorization: Basic STM4WjVRMTNHUVJXMjZTV0owVkI2NTdYTzVBOURJVTE6MENLR1VTUUc1UUlBVDNHSzcxSUZGTVhLVkZTUEJISE4=';
// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// $result = curl_exec($ch);
// if (curl_errno($ch)) {
//     echo 'Error:' . curl_error($ch);
// }
// curl_close($ch);

// print_r($result);

// 65428

?>

