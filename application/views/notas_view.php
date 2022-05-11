<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
          <h5>Notas</h5>
            <input type="text" class="filtrar_nota" id="filtrar_nota">
            <a href="#modal_form_notas" data-toggle="modal" class="btn btn-sm btn-success m-r-35 float-right agregar-notas">+ Nuevo</a>
            <div class="card-header-right">
                <div class="btn-group card-option">
                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="feather icon-more-horizontal"></i>
                    </button>
                    <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                        <li class="dropdown-item full-card"><a href="#"><span><i class="feather icon-maximize"></i> maximize</span><span style="display:none"><i class="feather icon-minimize"></i> Restore</span></a></li>
                        <li class="dropdown-item minimize-card"><a href="#"><span><i class="feather icon-minus"></i> collapse</span><span style="display:none"><i class="feather icon-plus"></i> expand</span></a></li>
                        <li class="dropdown-item reload-card"><a href="#"><i class="feather icon-refresh-cw"></i> reload</a></li>
                        <li class="dropdown-item close-card"><a href="#"><i class="feather icon-trash"></i> remove</a></li>
                    </ul>
                </div>
            </div>            
        </div>        
        <div class="card-body">
            <div class="dt-responsive table-responsive">
                <table id="tb-datatable-notas"class="table table-dark table-striped table-bordered nowrap" width="100%">
                    <thead class="thead-light">
                       <tr>
                            <th style="width: 5%">id</th>
                            <th >id usuario</th>
                            <th >Nombre</th>
                            <th >Atajo</th>
                            <th >Descripción</th>
                            <th >vTema5_notas</th>
                            <th style="width: 9%">Acción</th>
                       </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="box-lumic">
    <div class="modal fade" id="modal_form_notas">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form class="form-material form-action-post" action="#notas" id="form_notas" method="post">
                    <div class="modal-body">
                        <div class="form-group form-primary">
                            <label class="col-lg-3 control-label">Nombre</label>
                            <div class="col-lg-12">
                                <input type="text" class="form-control" id="vc_nombre" name="vc_nombre" placeholder="Nombre" >
                            </div>
                        </div>
                        <div class="form-group form-primary">
                            <label class="col-lg-3 control-label">Atajo</label>
                            <div class="col-lg-12">
                                <input type="text" class="form-control" id="vc_atajo" name="vc_atajo" placeholder="Atajo" >
                            </div>
                        </div>
                        <div class="form-group form-primary">
                            <label class="col-lg-3 control-label">Descripción</label>
                            <div class="col-lg-12">
                                 <textarea id="vc_descripcion" name="vc_descripcion" ></textarea>
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

<script src="assets/js/lumic/notas.js?<?php echo rand()?>"></script>

<script>
  $(function () {
    Notas.init();
    Notas.datatable_Notas(stateSave= true, filtrar_nota= true, value= '');
    Notas.set_Notas();
  });
</script>