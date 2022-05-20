<div class="col-sm-12">
    <div class="card">
        <div class="header">
            <h2>
                Cuenta_movimientos
            </h2>
            <ul class="header-dropdown m-r--5">
                <a href="#modal_form_cuenta_movimientos" data-toggle="modal" class="btn btn-sm btn-primary btn-nuevo float-right agregar-cuenta_movimientos m-r-10">+ Nuevo</a>
                <a href="javascript:void(0);" id="actualizar-tbl-cuenta_movimientos" class="btn btn-sm btn-success pull-right float-right m-r-10">Actualizar</a>
            </ul>
        </div>
        <div class="body">
            <div class="table-responsive">
                <table id="tb-datatable-cuenta_movimientos"class="table table-bordered table-striped table-hover js-basic-example dataTable" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 5%">id</th>
                            <th >id_cliente</th>
                            <th >id_paypal</th>
                            <th >id_movimiento</th>
                            <th >tipo_movimiento</th>
                            <th >saldo_anterior</th>
                            <th >saldo_nuevo</th>
                            <th >importe</th>
                            <th >monto_total</th>
                            <th >titular_cuenta</th>
                            <th >refvc</th>                            
                            <th >Acción</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="box-lumic">
    <div class="modal fade" id="modal_form_cuenta_movimientos">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form class="form-material form-action-post" action="#cuenta_movimientos" id="form_cuenta_movimientos" method="post">
                    <div class="modal-body">

                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input type="text" id="id_cliente" name="id_cliente" class="form-control">
                                <label class="form-label">id_cliente</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input type="text" id="id_paypal" name="id_paypal" class="form-control">
                                <label class="form-label">id_paypal</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input type="text" id="id_movimiento" name="id_movimiento" class="form-control">
                                <label class="form-label">id_movimiento</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input type="text" id="tipo_movimiento" name="tipo_movimiento" class="form-control">
                                <label class="form-label">tipo_movimiento</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input type="text" id="saldo_anterior" name="saldo_anterior" class="form-control">
                                <label class="form-label">saldo_anterior</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input type="text" id="saldo_nuevo" name="saldo_nuevo" class="form-control">
                                <label class="form-label">saldo_nuevo</label>
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

<script src="assets/js/lumic/cuenta_movimientos.js?<?php echo rand()?>"></script>

<script>
  $(function () {
    Cuenta_movimientos.init();
    Cuenta_movimientos.datatable_Cuenta_movimientos();
    Cuenta_movimientos.set_Cuenta_movimientos();
  });
</script>