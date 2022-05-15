<div class="col-sm-12">
    <div class="card">
        <div class="header">
            <h2>
                Direccion_woocommerce
            </h2>
            <ul class="header-dropdown m-r--5">
                <a href="#modal_form_direccion_woocommerce" data-toggle="modal" class="btn btn-sm btn-primary btn-nuevo float-right agregar-direccion_woocommerce m-r-10">+ Nuevo</a>
                <a href="javascript:void(0);" id="actualizar-tbl-direccion_woocommerce" class="btn btn-sm btn-success pull-right float-right m-r-10">Actualizar</a>
            </ul>
        </div>
        <div class="body">
            <div class="table-responsive">
                <table id="tb-datatable-direccion_woocommerce"class="table table-bordered table-striped table-hover js-basic-example dataTable" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 5%">id</th>
                            <th >id_cliente</th>
                            <th >url</th>
                            <th >nombre</th>
                            <th >empresa</th>
                            <th >correo</th>
                            <th >telefono</th>
                            <th >calle</th>
                            <th >colonia</th>
                            <th >ciudad</th>
                            <th >codigo_postal</th>                            
                            <th >Acción</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="box-lumic">
    <div class="modal fade" id="modal_form_direccion_woocommerce">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form class="form-material form-action-post" action="#direccion_woocommerce" id="form_direccion_woocommerce" method="post">
                    <div class="modal-body">

                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input type="text" id="id_cliente" name="id_cliente" class="form-control">
                                <label class="form-label">id_cliente</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input type="text" id="url" name="url" class="form-control">
                                <label class="form-label">url</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input type="text" id="nombre" name="nombre" class="form-control">
                                <label class="form-label">nombre</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input type="text" id="empresa" name="empresa" class="form-control">
                                <label class="form-label">empresa</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input type="text" id="correo" name="correo" class="form-control">
                                <label class="form-label">correo</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input type="text" id="telefono" name="telefono" class="form-control">
                                <label class="form-label">telefono</label>
                            </div>
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

<script src="assets/js/lumic/direccion_woocommerce.js?<?php echo rand()?>"></script>

<script>
  $(function () {
    Direccion_woocommerce.init();
    Direccion_woocommerce.datatable_Direccion_woocommerce();
    Direccion_woocommerce.set_Direccion_woocommerce();
  });
</script>