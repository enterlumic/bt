<div class="col-sm-12">
    <div class="card">
        <div class="header">
            <h2>
                Ajustes
            </h2>
            <ul class="header-dropdown m-r--5">
                <a href="#modal_form_ajustes" data-toggle="modal" class="btn btn-sm btn-primary btn-nuevo float-right agregar-ajustes m-r-10">+ Nuevo</a>
                <a href="javascript:void(0);" id="actualizar-tbl-ajustes" class="btn btn-sm btn-success pull-right float-right m-r-10">Actualizar</a>
            </ul>
        </div>
        <div class="body">
            <div class="table-responsive">
                <table id="tb-datatable-ajustes"class="table table-bordered table-striped table-hover js-basic-example dataTable" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 5%">id</th>
                            <th >nombre</th>
                            <th >valor</th>
                            <th >valor_encrypt</th>
                            <th >descripcion</th>
                            <th >activo</th>
                            <th >creado</th>
                            <th >creado_por</th>
                            <th >modificado</th>
                            <th >modificado_por</th>
                            <th >vTema10_ajustes</th>                            
                            <th >Acción</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="box-lumic">
    <div class="modal fade" id="modal_form_ajustes">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form class="form-material form-action-post" action="#ajustes" id="form_ajustes" method="post">
                    <div class="modal-body">

                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input type="text" id="nombre" name="nombre" class="form-control">
                                <label class="form-label">nombre</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input type="text" id="valor" name="valor" class="form-control">
                                <label class="form-label">valor</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input type="text" id="valor_encrypt" name="valor_encrypt" class="form-control">
                                <label class="form-label">valor_encrypt</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input type="text" id="descripcion" name="descripcion" class="form-control">
                                <label class="form-label">descripcion</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input type="text" id="activo" name="activo" class="form-control">
                                <label class="form-label">activo</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input type="text" id="creado" name="creado" class="form-control">
                                <label class="form-label">creado</label>
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

<script src="assets/js/lumic/ajustes.js?<?php echo rand()?>"></script>

<script>
  $(function () {
    Ajustes.init();
    Ajustes.datatable_Ajustes();
    Ajustes.set_Ajustes();
  });
</script>