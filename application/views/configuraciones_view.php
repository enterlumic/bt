<div class="col-xl-6">
    <div class="card">
        <div class="card-header">
          <h5>Temas</h5>
        </div>
        <div class="card-body">
            <div class="m-style-scroller" >
                <form>
                    <div class="form-group mb-3">
                        <label class="floating-label" for="To">Titulo</label>
                        <input type="text" class="form-control" id="vc_titulo">
                    </div>
<!--                     <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="floating-label" for="Cc">Cc</label>
                                    <input type="text" class="form-control" id="Cc">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="floating-label" for="Bcc">Bcc</label>
                                    <input type="text" class="form-control" id="Bcc">
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <div class="float-right mt-3">
                        <button type="button" class="btn waves-effect waves-light btn-primary btn-sm">Guardar</button>
                    </div>
                </form>
            </div>
        </div>        

    </div>
</div>


<div class="col-xl-6">
    <div class="card">
        <div class="card-header">
          <h5>Posiciones</h5>
        </div>
        <div class="card-body">
            <div class="m-style-scroller" >
                <div class="form-group mb-2 hide">
                    <div class="switch switch-primary d-inline m-r-10">
                        <input type="checkbox" id="theme-rtl" name="theme-rtl"><label for="theme-rtl" class="cr"></label>
                    </div>
                    <label>RTL</label>
                </div>
                <div class="form-group mb-2">
                    <div class="switch switch-primary d-inline m-r-10"><input type="checkbox" id="b_Sidebar_Fixed" name="b_Sidebar_Fixed"><label for="b_Sidebar_Fixed" class="cr"></label></div>
                    <label>Barra lateral fija</label>
                </div>
                <div class="form-group mb-2">
                    <div class="switch switch-primary d-inline m-r-10"><input type="checkbox" id="b_Header_Fixed" name="b_Header_Fixed"><label for="b_Header_Fixed" class="cr"></label></div>
                    <label>Encabezado fijo</label>
                </div>
                <div class="form-group mb-2">
                    <div class="switch switch-primary d-inline m-r-10"><input type="checkbox" id="b_Box_Layouts" name="b_Box_Layouts"><label for="b_Box_Layouts" class="cr"></label></div>
                    <label> Diseños de caja</label>
                </div>
                <div class="form-group mb-2 hide">
                    <div class="switch switch-primary d-inline m-r-10"><input type="checkbox" id="b_Breadcumb_sticky" name="b_Breadcumb_sticky"><label for="b_Breadcumb_sticky" class="cr"></label></div>
                    <label>Pan de pan pegajoso</label>
                </div>

                <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                    <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                </div>
                <div class="ps__rail-y" style="top: 0px; height: 516px; right: 0px;">
                    <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 482px;"></div>
                </div>
            </div>
        </div>        

    </div>
</div>


<div class="col-xl-6">
    <div class="card">
        <div class="card-header">
          <h5>Plantilla</h5>
        </div>
        <div class="card-body">
            <div class="m-style-scroller" >
                <div class="theme-color layout-type">
                    <a href="javascript:void(0);" class="" data-value="menu-dark" title="Default Layout"></a>
                    <a href="javascript:void(0);" class="" data-value="menu-light" title="Light"></a>
                    <a href="javascript:void(0);" class="" data-value="dark" title="Dark"></a>
                    <a href="javascript:void(0);" class="" data-value="reset" title="Reset">Reset</a>
                </div>
                <h6>color de fondo</h6>
                <div class="theme-color background-color flat">
                    <a href="javascript:void(0);" class="" data-value="background-blue"></a>
                    <a href="javascript:void(0);" class="" data-value="background-red"></a>
                    <a href="javascript:void(0);" class="" data-value="background-purple"></a>
                    <a href="javascript:void(0);" class="" data-value="background-info"></a>
                    <a href="javascript:void(0);" class="" data-value="background-green"></a>
                    <a href="javascript:void(0);" class="" data-value="background-dark"></a>
                </div>
                <h6>gradiente de fondo</h6>
                <div class="theme-color background-color gradient">
                    <a href="javascript:void(0);" class="" data-value="background-grd-blue"></a>
                    <a href="javascript:void(0);" class="" data-value="background-grd-red"></a>
                    <a href="javascript:void(0);" class="" data-value="background-grd-purple"></a>
                    <a href="javascript:void(0);" class="" data-value="background-grd-info"></a>
                    <a href="javascript:void(0);" class="" data-value="background-grd-green"></a>
                    <a href="javascript:void(0);" class="" data-value="background-grd-dark"></a>
                </div>
                <h6>imagen de fondo</h6>
                <div class="theme-color background-color image">
                    <a href="javascript:void(0);" class="" data-value="background-img-1"></a>
                    <a href="javascript:void(0);" class="" data-value="background-img-2"></a>
                    <a href="javascript:void(0);" class="" data-value="background-img-3"></a>
                    <a href="javascript:void(0);" class="" data-value="background-img-4"></a>
                    <a href="javascript:void(0);" class="" data-value="background-img-5"></a>
                    <a href="javascript:void(0);" class="" data-value="background-img-6"></a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/lumic/configuraciones.js?<?php echo rand()?>"></script>

<script>
  $(function () {
    Configuraciones.init();
    Configuraciones.datatable_Configuraciones();
    Configuraciones.set_Configuraciones();
  });
</script>