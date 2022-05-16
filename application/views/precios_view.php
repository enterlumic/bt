<div class="col-sm-12">
    <div class="card">
        <div class="header">
            <h2>
                Precios
            </h2>
            <ul class="header-dropdown m-r--5">
                <a href="#modal_form_precios" data-toggle="modal" class="btn btn-sm btn-primary btn-nuevo float-right agregar-precios m-r-10">+ Nuevo</a>
                <a href="javascript:void(0);" id="actualizar-tbl-precios" class="btn btn-sm btn-success pull-right float-right m-r-10">Actualizar</a>
            </ul>
        </div>
        <div class="body">

            <div class="row clearfix">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <form>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" id="idTipoEnvioMin" class="form-control">
                                <label class="form-label">idTipoEnvioMin</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" id="idTipoEnvioMax" class="form-control">
                                <label class="form-label">idTipoEnvioMax</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <form>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" id="PrecioMin" class="form-control">
                                <label class="form-label">PrecioMin</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" id="PrecioMax" class="form-control">
                                <label class="form-label">PrecioMax</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <form>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" id="PesoInicioMin" class="form-control">
                                <label class="form-label">PesoInicioMin</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" id="PesoInicioMax" class="form-control">
                                <label class="form-label">PesoInicioMax</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <form>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" id="PesoFinMin" class="form-control">
                                <label class="form-label">PesoFinMin</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" id="PesoFinMax" class="form-control">
                                <label class="form-label">PesoFinMax</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <form>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" id="MedidaFinMin" class="form-control">
                                <label class="form-label">MedidaFinMin</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" id="MedidaFinMax" class="form-control">
                                <label class="form-label">MedidaFinMax</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <form>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" id="DimensionFinMin" class="form-control">
                                <label class="form-label">DimensionFinMin</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" id="DimensionFinMax" class="form-control">
                                <label class="form-label">DimensionFinMax</label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table id="tb-datatable-precios"class="table table-bordered table-striped table-hover js-basic-example dataTable" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 5%">id</th>
                            <th >IdTipoEnvio</th>
                            <th >Precio</th>
                            <th >PesoInicio</th>
                            <th >PesoFin</th>
                            <th >MedidaMaxima</th>
                            <th >DimensionMaxima</th>
                            <th >costo_extra_kg</th>
                            <th >peso_maximo</th>
                            <th >Activo</th>
                            <th >Creado</th>                            
                            <th >Acción</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th style="width: 5%">id</th>
                            <th >IdTipoEnvio</th>
                            <th >Precio</th>
                            <th >PesoInicio</th>
                            <th >PesoFin</th>
                            <th >MedidaMaxima</th>
                            <th >DimensionMaxima</th>
                            <th >costo_extra_kg</th>
                            <th >peso_maximo</th>
                            <th >Activo</th>
                            <th >Creado</th>                            
                            <th >Acción</th>
                        </tr>                        
                    </tfoot>
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

                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input type="text" id="IdTipoEnvio" name="IdTipoEnvio" class="form-control">
                                <label class="form-label">IdTipoEnvio</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input type="text" id="Precio" name="Precio" class="form-control">
                                <label class="form-label">Precio</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input type="text" id="PesoInicio" name="PesoInicio" class="form-control">
                                <label class="form-label">PesoInicio</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input type="text" id="PesoFin" name="PesoFin" class="form-control">
                                <label class="form-label">PesoFin</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input type="text" id="MedidaMaxima" name="MedidaMaxima" class="form-control">
                                <label class="form-label">MedidaMaxima</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input type="text" id="DimensionMaxima" name="DimensionMaxima" class="form-control">
                                <label class="form-label">DimensionMaxima</label>
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

<script src="assets/js/lumic/precios.js?<?php echo rand()?>"></script>

<script>
  $(function () {
    Precios.init();
    Precios.datatable_Precios();
    Precios.set_Precios();
  });
</script>