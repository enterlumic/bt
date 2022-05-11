<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
          <h5>Console</h5>
          <a href="#modal_form_console" data-toggle="modal" class="btn btn-sm btn-primary float-right agregar-console">+ Nuevo</a>
        </div>
        <div class="card-body">
            <div class="dt-responsive table-responsive">
                <table id="tb-datatable-console"class="table table-striped table-bordered nowrap" width="100%">
                    <thead class="thead-light">
                       <tr>
                            <th style="width: 5%">id</th>
                            <th >vTema1_console</th>
                            <th >vTema2_console</th>
                            <th >vTema3_console</th>
                            <th >vTema4_console</th>
                            <th >vTema5_console</th>
                            <th style="width: 9%">Acción</th>
                       </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="box-lumic">
    <div class="modal fade" id="modal_form_console">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form class="form-material form-action-post" action="#console" id="form_console" method="post">
                    <div class="modal-body">

                        <div class="form-group form-primary">
                            <input type="text" class="form-control form-control-capitalize" id="vCampo1_console" name="vCampo1_console" >
                            <span class="form-bar"></span>
                            <label class="float-label">vTema1_console</label>
                        </div>

                        <div class="form-group form-primary">
                            <input type="text" class="form-control" id="vCampo2_console" name="vCampo2_console" >
                            <span class="form-bar"></span>
                            <label class="float-label">vTema2_console</label>
                        </div>

                        <div class="form-group form-primary">
                            <input type="text" class="form-control" id="vCampo3_console" name="vCampo3_console" >
                            <span class="form-bar"></span>
                            <label class="float-label">vTema3_console</label>
                        </div>

                        <div class="form-group form-primary">
                            <input type="text" class="form-control" id="vCampo4_console" name="vCampo4_console" >
                            <span class="form-bar"></span>
                            <label class="float-label">vTema4_console</label>
                        </div>

                        <div class="form-group form-primary">
                            <input type="text" class="form-control" id="vCampo5_console" name="vCampo5_console" >
                            <span class="form-bar"></span>
                            <label class="float-label">vTema5_console</label>
                        </div>

                        <div class="form-group form-primary">
                            <input type="text" class="form-control" id="vCampo6_console" name="vCampo6_console" >
                            <span class="form-bar"></span>
                            <label class="float-label">vTema6_console</label>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary btn-action-form">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div style="position:absolute;top:40px;right: 40px">
    <div class="toast hide toast-right" role="alert" aria-live="assertive" data-delay="3000" aria-atomic="true">
        <div class="toast-header">
            <img src="assets/images/favicon.ico" alt="" class="img-fluid m-r-5" style="width:20px;">
            <strong class="mr-auto">Bootstrap</strong>
            <small class="text-muted">11 mins ago</small>
            <button type="button" class="m-l-5 mb-1 mt-1 close" data-dismiss="toast" aria-label="Close">
                <span>&times;</span>
            </button>
        </div>
        <div class="toast-body">
            Hello, world! This is a toast message.
        </div>
    </div>
</div>

<script src="assets/js/lumic/console.js?<?php echo rand()?>"></script>

<script>
  $(function () {
    Console.init();
    Console.datatable_Console();
    Console.set_Console();





// STM4WjVRMTNHUVJXMjZTV0owVkI2NTdYTzVBOURJVTE6MENLR1VTUUc1UUlBVDNHSzcxSUZGTVhLVkZTUEJISE4=
// curl https://api.eposnowhq.com/api/v4/Customer/GetByEmail
// curl https://api.eposnowhq.com/api/v4/AppSettings
// GET /api/v4/AppSettings


        var request = {
            url: "https://api.eposnowhq.com/api/v4/Product",
            type: "GET",
            contentType: "application/json",
            accepts: "application/json",
            dataType: 'json',
            data: JSON.stringify(data),
            crossDomain: true,
            beforeSend: function (xhr) {
                console.log("xhr", xhr);
                //Sets Basic Authorization header necessary for API calls using key defined at top
                xhr.setRequestHeader("Authorization", "Basic " + "STM4WjVRMTNHUVJXMjZTV0owVkI2NTdYTzVBOURJVTE6MENLR1VTUUc1UUlBVDNHSzcxSUZGTVhLVkZTUEJISE4=:");
            },
            error: function (jqXHR) {
                console.log("ajax error " + jqXHR.status);
            }
        };
        console.log($.ajax(request));    

  });
</script>


<?php
    $headers = array(
      'Authorization: Basic '.base64_encode("STM4WjVRMTNHUVJXMjZTV0owVkI2NTdYTzVBOURJVTE6MENLR1VTUUc1UUlBVDNHSzcxSUZGTVhLVkZTUEJISE4=".':'),
      'Content-Type: application/json'
      );

    $opts[CURLOPT_URL] = "https://api.eposnowhq.com/api/v4/Product";
    $opts[CURLOPT_RETURNTRANSFER] = true;
    $opts[CURLOPT_CONNECTTIMEOUT] = 30;
    $opts[CURLOPT_TIMEOUT] = 80;
    $opts[CURLOPT_RETURNTRANSFER] = true;
    $opts[CURLOPT_HTTPHEADER] = $headers;
    $opts[CURLOPT_SSLVERSION] = 6;
    $opts[CURLOPT_CAINFO] = dirname(__FILE__).'/../ssl_data/ca_bundle.crt';
    curl_setopt_array($curl, $opts);
    $response = curl_exec($curl);
    $responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    print_r($response);
    curl_close($curl);

?>
