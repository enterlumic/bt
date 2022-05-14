<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <a href="#modal_form_precios" data-toggle="modal" class="btn btn-sm btn-primary btn-nuevo  agregar-precios">+ Nuevo</a>
            <a href="javascript:void(0);" id="actualizar-tbl-precios" class="btn btn-sm btn-success  m-r-10">Actualizar</a>
        </div>
        <div class="body">
            <div class="table-responsive">
                <table id="tb-datatable-precios"class="table table-bordered table-striped table-hover js-basic-example dataTable" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 5%">id</th>
                            <th >IdPrecios</th>
                            <th >IdTipoEnvio</th>
                            <th >Precio</th>
                            <th >PesoInicio</th>
                            <th >PesoFin</th>
                            <th >MedidaMaxima</th>
                            <th >DimensionMaxima</th>
                            <th >costo_extra_kg</th>
                            <th >peso_maximo</th>
                            <th >active</th>                            
                            <th style="width: 9%">Acción</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="box-lumic">
    <div class="modal fade" id="modal_form_precios">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form class="form-material form-action-post" action="#precios" id="form_precios" method="post">
                    <div class="modal-body">

                        <div class="form-group form-primary">
                            <label class="float-label">IdPrecios</label>
                            <span class="form-bar"></span>
                            <input type="text" class="form-control form-control-capitalize" id="IdPrecios" name="IdPrecios" >
                        </div>

                        <div class="form-group form-primary">
                            <label class="float-label">IdTipoEnvio</label>
                            <span class="form-bar"></span>
                            <input type="text" class="form-control" id="IdTipoEnvio" name="IdTipoEnvio" >
                        </div>

                        <div class="form-group form-primary">
                            <label class="float-label">Precio</label>
                            <span class="form-bar"></span>
                            <input type="text" class="form-control" id="Precio" name="Precio" >
                        </div>

                        <div class="form-group form-primary">
                            <label class="float-label">PesoInicio</label>
                            <span class="form-bar"></span>
                            <input type="text" class="form-control" id="PesoInicio" name="PesoInicio" >
                        </div>

                        <div class="form-group form-primary">
                            <label class="float-label">PesoFin</label>
                            <span class="form-bar"></span>
                            <input type="text" class="form-control" id="PesoFin" name="PesoFin" >
                        </div>

                        <div class="form-group form-primary">
                            <label class="float-label">MedidaMaxima</label>
                            <span class="form-bar"></span>
                            <input type="text" class="form-control" id="MedidaMaxima" name="MedidaMaxima" >
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

<script src="assets/js/lumic/precios.js?<?php echo rand()?>"></script>

<script>
  $(function () {
    Precios.init();
    Precios.datatable_Precios();
    Precios.set_Precios();
  });
</script>