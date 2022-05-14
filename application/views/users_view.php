<div class="col-sm-12">
    <div class="card">
        <div class="header">
            <h2>
                Usuarios
            </h2>
            <ul class="header-dropdown m-r--5">
                <a href="#modal_form_users" data-toggle="modal" class="btn btn-sm btn-primary btn-nuevo float-right agregar-users m-r-10">+ Nuevo</a>
                <a href="javascript:void(0);" id="actualizar-tbl-users" class="btn btn-sm btn-success pull-right float-right m-r-10">Actualizar</a>
            </ul>
        </div>
        <div class="body">
            <div class="table-responsive">
                <table id="tb-datatable-users"class="table table-bordered table-striped table-hover dataTable js-exportable" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 5%">id</th>
                            <th >name</th>
                            <th >apellido</th>
                            <th >email</th>
                            <th >email_verified_at</th>
                            <th >password</th>
                            <th >pass_crypt</th>
                            <th >referido</th>
                            <th >myrefcode</th>
                            <th >admin</th>
                            <th >telefono</th>                            
                            <th >Acción</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="box-lumic">
    <div class="modal fade" id="modal_form_users">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form class="form-material form-action-post" action="#users" id="form_users" method="post">
                    <div class="modal-body">

                        <div class="form-group form-primary">
                            <label class="float-label">name</label>
                            <span class="form-bar"></span>
                            <input type="text" class="form-control form-control-capitalize" id="name" name="name" >
                        </div>

                        <div class="form-group form-primary">
                            <label class="float-label">apellido</label>
                            <span class="form-bar"></span>
                            <input type="text" class="form-control" id="apellido" name="apellido" >
                        </div>

                        <div class="form-group form-primary">
                            <label class="float-label">email</label>
                            <span class="form-bar"></span>
                            <input type="text" class="form-control" id="email" name="email" >
                        </div>

                        <div class="form-group form-primary">
                            <label class="float-label">email_verified_at</label>
                            <span class="form-bar"></span>
                            <input type="text" class="form-control" id="email_verified_at" name="email_verified_at" >
                        </div>

                        <div class="form-group form-primary">
                            <label class="float-label">password</label>
                            <span class="form-bar"></span>
                            <input type="text" class="form-control" id="password" name="password" >
                        </div>

                        <div class="form-group form-primary">
                            <label class="float-label">pass_crypt</label>
                            <span class="form-bar"></span>
                            <input type="text" class="form-control" id="pass_crypt" name="pass_crypt" >
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

<script src="assets/js/lumic/users.js?<?php echo rand()?>"></script>

<script>
  $(function () {
    Users.init();
    Users.datatable_Users();
    Users.set_Users();
  });
</script>