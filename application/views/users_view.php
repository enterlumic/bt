<div class="col-sm-12">
    <div class="card">
        <div class="header">
            <h2>
                Users
            </h2>
            <ul class="header-dropdown m-r--5">
                <a href="#modal_form_users" data-toggle="modal" class="btn btn-sm btn-primary btn-nuevo float-right agregar-users m-r-10">+ Nuevo</a>
                <a href="javascript:void(0);" id="actualizar-tbl-users" class="btn btn-sm btn-success pull-right float-right m-r-10">Actualizar</a>
            </ul>
        </div>
        <div class="body">
            <div class="table-responsive">
                <table id="tb-datatable-users"class="table table-bordered table-striped table-hover js-basic-example dataTable" width="100%">
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
                    <tfoot>
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
                    </tfoot>
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

                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input type="text" id="name" name="name" class="form-control">
                                <label class="form-label">name</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input type="text" id="apellido" name="apellido" class="form-control">
                                <label class="form-label">apellido</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input type="text" id="email" name="email" class="form-control">
                                <label class="form-label">email</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input type="text" id="email_verified_at" name="email_verified_at" class="form-control">
                                <label class="form-label">email_verified_at</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input type="text" id="password" name="password" class="form-control">
                                <label class="form-label">password</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input type="text" id="pass_crypt" name="pass_crypt" class="form-control">
                                <label class="form-label">pass_crypt</label>
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

<script src="assets/js/lumic/users.js?<?php echo rand()?>"></script>

<script>
  $(function () {
    Users.init();
    Users.datatable_Users();
    Users.set_Users();
  });
</script>