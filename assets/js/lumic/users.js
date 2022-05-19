var Users = {

    init: function(){

      Users.modalShow();
      Users.modalHide();
      Users.AgregarNuevo();
      Users.actualizarTabla();
    },

    datatable_Users: function(){

      var table = $('#tb-datatable-users').DataTable( 
      {
            "stateSave": false
          , "responsive": true
          , "serverSide": true
          , "pageLength": 10
          , "scrollCollapse": true
          , "lengthMenu": [ 10, 10, 25, 50, 75, 100 ]
          , "ajax": {
               "url": "users/get_users_by_datatable"
              ,"type": "POST"
              ,"data": {"extra":1}
          }
          , "processing": true
          , "language": {
              "processing": '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Cargando...</span>',
              "sProcessing":     "Procesando...",
              "sLengthMenu":     "Mostrar _MENU_ registros",
              "sZeroRecords":    "No se encontraron resultados",
              "sEmptyTable":     "Ningún dato disponible en esta tabla",
              "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
              "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
              "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
              "sInfoPostFix":    "",
              "sSearch":         "Buscar:",
              "sUrl":            "",
              "sInfoThousands":  ",",
              "sLoadingRecords": "Cargando...",
              "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
              },
              "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
              }
          }
          , stateSaveCallback: function(settings,data) {
              localStorage.setItem( 'DataTables_' + settings.sInstance, JSON.stringify(data) )
          }
          , stateLoadCallback: function(settings) {
              return JSON.parse( localStorage.getItem( 'DataTables_' + settings.sInstance ) )
          }
          , "columnDefs": [
              {
                  "targets": 0,
                  "render": function(data, type, row, meta){
                      var contador= meta.row + 1;
                      return contador;
                  },
                  "class": "text-center"
              },
              {
                  "targets": 5,
                  "visible": false,
              },

              {
                  "targets": 6,
                  "visible": false,
              },
              {
                   "targets": 11
                  ,"width": "10%"
                  ,"render": function(data, type, row, meta ){
                    return '<a data-toggle="modal" href="#modal_form_users" id="'+row[0]+'" class="update-users btn btn-error">\
                              <i class="material-icons">edit</i>\
                            </a> \
                            <a href="javascript:void(0);" id="'+row[0]+'" class="delete-users btn btn-danger " ><i class="material-icons">delete</i></a>';
                  }
                  ,"class": "text-center"
              }
          ]
      } );

      // setInterval( function () {
      //     table.ajax.reload( null, false );
      // }, 5000 );

      $('#tb-datatable-users tbody').on( 'click', '.delete-users', function () {

          document.getElementById("form_users").reset();
          $("label.error").hide();
          $(".error").removeClass("error");

          var id = this.id;

          $.post( "users/delete_users",{"id" : id}
              , function( data )
              {
                  try {
                      var result = JSON.stringify(result);
                      var json   = JSON.parse(data);
                  } catch (e) {
                      console.log(data);
                  }

                  if (data)
                  {
                      $('#tb-datatable-users').DataTable().ajax.reload();

                      // if ($(".noty_layout").length)
                      //   $(".noty_layout").remove();
                      
                      var n = new Noty({
                       type: "warning",
                          close: false,
                          text: "<b>Se movio a la papelera<b>" ,
                          timeout: 20e3,
                            buttons: [
                              Noty.button('Deshacer', 'btn btn-success', function () {
                                  $.post( "users/undo_delete_users"
                                      ,{"id" : id}
                                      , function( data )
                                      {
                                        if (data)
                                        {
                                          n.close();
                                          $('#tb-datatable-users').DataTable().ajax.reload();
                                        }
                                        else
                                        {
                                          alert("Ocurrio un error");
                                        }
                                      }
                                  );// post
                              }
                              ,{
                                  'id'         : 'id-'+json['data']['id']
                                , 'data-status': 'ok'
                              }
                              )
                              , Noty.button('Cerrar', 'btn btn-error', function () {
                                    n.close();
                                })
                            ]
                      });
                      n.show();
                  }
                  else
                  {
                    alert("Ocurrio un error");
                  }
              }
          );
      } );

      $('#tb-datatable-users tbody').on( 'click', '.update-users', function () {
          var id = this.id;
          document.getElementById("form_users").reset();
          $("#id").remove();
          $("#form_users").prepend("<input type=\"hidden\" name=\"id\" id=\"id\" value="+id+">");

          $("#modal_form_users .modal-title").html("Editar users");

          $.post( "Users/get_users_by_id", {"id" : id } , function( data )
          {
              try {
                  var result = JSON.stringify(result);
                  var json   = JSON.parse(data);
              } catch (e) {
                  console.log(data);
              }

              if (json["b_status"]){
                  var p= json['data'];
                  for (var key in p) 
                  {
                      if (p.hasOwnProperty(key)) 
                      {
                          if (p[key] !=="")
                          {
                              $("#"+key).addClass("fill");

                              if ( $("#"+key).prop('type') == "text"
                                || $("#"+key).prop('type') == "textarea"
                                || $("#"+key).prop('type') == "number"
                                || $("#"+key).prop('type') == "url"
                                || $("#"+key).prop('type') == "tel"
                              )
                              {
                                $("#"+key).val(p[key]);
                              }

                              if ( $("#"+key).prop('type') == "file")
                              {

                                if (p[key] !=="" )
                                {
                                    $("#" + key).attr("required", false);
                                }

                                if (p[key] !== null){
                                  var filename = p[key].replace(/^.*[\\\/]/, '')
                                  $("#" + key).after("<a href=\"" + p[key] + "\" target=\"_blank\" class=\"external_link  abrir-"+key+" \"> "+filename.substr(0, 15)+" </a>");
                                }

                              }

                              if ( $("#"+key).prop('nodeName') == "SELECT")
                              {
                                  $('#'+key+' option[value="'+p[key]+'"]').prop('selected', true);
                              }
                          }
                      }
                  }
              }
              else{
                  alert("Revisar console para mas detalle");
                  console.log(json);
              }
              $(".btn-action-form").attr("value","Actualizar");
              $(".btn-action-form").prop("disabled",false);
          }); //  Fin $.post
      } );
    },

    set_Users: function(){
      $("#form_users").validate(
      {
          submitHandler:function(form)
          {
              var get_form = document.getElementById("form_users");
              var postData = new FormData( get_form );

              $.ajax({
                  url:"users/set_users",
                  data: postData,
                  cache: false,
                  processData: false,
                  contentType: false,
                  type: 'POST',
                      success: function(response)
                      {
                          try {
                              var json   = JSON.parse(response);
                          } catch (e) {
                              alert(response);
                              return ;
                          }

                          if (json["b_status"]){
                              $('#tb-datatable-users').DataTable().ajax.reload();
                              document.getElementById("form_users").reset();
                              $('#modal_form_users').modal('hide');
                          }else{
                              alert(json);
                          }
                      }
                });
          }
          , errorPlacement: function(error, element) {
            error.insertAfter($("#"+element.attr("name")).next("span"));
          }
          // , rules: {
          //   name: {
          //     required: true,
          //   }
          //   ,apellido: {
          //     required: true,
          //   }
          // }
          // , messages: {
          //     name: {
          //         minlength: "Ingrese un RFC válido"
          //     }
          //   }
      });
    },

    modalShow: function(){
      $('#modal_form_users').on('shown.bs.modal', function (e) {
          $('#name', e.target).focus();
      });
    },

    modalHide: function(){
      $('#modal_form_users').on('hidden.bs.modal', function (e) {
          var validator = $( "#form_users" ).validate();
          validator.resetForm();
          $("label.error").hide();
          $(".error").removeClass("error");
      });
    },

    AgregarNuevo: function(){
      $(document).on("click", ".agregar-users", function(){
          document.getElementById("form_users").reset();
          $("#id").remove();
          $("#modal_form_users .modal-title").html("Nuevo Users");
      });      
    },

    actualizarTabla: function(){
      $(document).on("click", "#actualizar-tbl-users", function(){
          $('#tb-datatable-users').DataTable().ajax.reload();
      });
    }
};
