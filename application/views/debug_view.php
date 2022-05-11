<div class="card">
    <div class="card-header">
        <h5>Debug</h5>
        <a href="javascript:void(0);" id="reset-reload" class="btn btn-success pull-right m-l-10">Reload</a>&nbsp;&nbsp;
        <a href="javascript:void(0);" id="reset-debug" class="btn btn-danger pull-right">Reset</a>
    </div>
    <div class="card-block">
         <div class="dt-responsive table-responsive">
            <table id="tbl_debug" class="table table-striped table-bordered nowrap" width="100%">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Event</th>
                        <th>Ejecución</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<style type="text/css">
    #tb_notes_filter label .form-control{width: auto !important; display: initial !important}
    .btn-group{margin-left: 4%;}
</style>

<script src="assets/js/lumic/debug.js?<?php echo rand();?>"></script>

<script>
  $(function () {
    Debug.datatable();
    Debug.events_datatable();
  })
  
</script>
