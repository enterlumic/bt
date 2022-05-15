var Users = {

    init: function(){

      Users.modalShow();
      Users.modalHide();
      Users.AgregarNuevo();
      Users.actualizarTabla();
      // Users.importar_Users();
    },

    datatable_Users: function(){

      // $('#tb-datatable-users tfoot th').each(function () {
      //     var title = $(this).text();
      //     $(this).html('<input type="text" placeholder="' + title + '" />');
      // });

      var table = $('#tb-datatable-users').DataTable( 
      {
            "stateSave": true
          , "responsive": true
          , "serverSide": true
          , "pageLength": 10
          , "scrollCollapse": true
          , "lengthMenu": [ 10, 25, 50, 75, 100 ]
          , "ajax": {
               "url": "users/get_users_by_datatable"
              ,"type": "POST"
              ,"data": {"extra":1}
          }
          , "processing": true
          // , initComplete: function () {
          //     this.api()
          //         .columns()
          //         .every(function () {
          //             var that = this;

          //             $('input', this.footer()).on('keyup change clear', function () {
          //                 if (that.search() !== this.value) {
          //                     that.search(this.value).draw();
          //                 }
          //             });
          //         });
          // }
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
                  ,"width": "60"
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

    importar_Users: function() {

        // define the form and the file input
        var $form = $('#FormImportarUsers');

        // enable fileuploader plugin
        $form.find('input:file').fileuploader({
            addMore: true,
            changeInput: '<div class="fileuploader-input">' +
                '<div class="fileuploader-input-inner">' +
                '<div>${captions.feedback} ${captions.or} <span>${captions.button}</span></div>' +
                '</div>' +
                '</div>',
            theme: 'dropin',
            upload: true,
            enableApi: true,
            onSelect: function(item) {
                item.upload = null;
                $(".btn-importar").removeClass('btn-disabled disabled');
                $(".btn-importar").removeAttr('disabled');            
            },
            onRemove: function(item) {
                if (item.data.uploaded)
                    $.post('files/assets/js/lumic/fileuploader-2.2/examples/drag-drop-form/php/ajax_remove_file_users.php', {
                        file: item.name
                    }, function(data) {
                        // if (data)
                            // $(".text-success").html("");
                    });
            },
            captions: $.extend(true, {}, $.fn.fileuploader.languages['en'], {
                feedback: 'Arrastra y suelta aquí',
                or: 'ó <br>',
                button: 'Buscar archivo'
            })
          });

        // form submit
        $form.on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(),
                _fileuploaderFields = [];

            // append inputs to FormData
            $.each($form.serializeArray(), function(key, field) {
                formData.append(field.name, field.value);
            });
            // append file inputs to FormData
            $.each($form.find("input:file"), function(index, input) {
                var $input = $(input),
                    name = $input.attr('name'),
                    files = $input.prop('files'),
                    api = $.fileuploader.getInstance($input);


                // add fileuploader files to the formdata
                if (api) {
                    if ($.inArray(name, _fileuploaderFields) > -1)
                        return;
                    files = api.getChoosedFiles();
                    _fileuploaderFields.push($input);
                }

                for (var i = 0; i < files.length; i++) {
                    formData.append(name, (files[i].file ? files[i].file : files[i]), (files[i].name ? files[i].name : false));
                }
            });

            $.ajax({
                url: $form.attr('action') || '#',
                data: formData,
                type: $form.attr('method') || 'POST',
                enctype: $form.attr('enctype') || 'multipart/form-data',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $form.find('.form-status').html('<div class="progressbar-holder"><div class="progressbar"></div></div>');
                    $form.find('input[type="submit"]').attr('disabled', 'disabled');
                },
                xhr: function() {
                    var xhr = $.ajaxSettings.xhr();

                    if (xhr.upload) {
                        xhr.upload.addEventListener("progress", this.progress, false);
                    }

                    return xhr;
                },
                success: function(result, textStatus, jqXHR) {
                    // update input values
                    try {
                        var data = JSON.parse(result);

                        for (var key in data) {
                            var field = data[key],
                                api;

                            // if fileuploader input
                            if (field.files) {
                                var input = _fileuploaderFields.filter(function(element) {
                                        return key == element.attr('name').replace('[]', '');
                                    }).shift(),
                                    api = input ? $.fileuploader.getInstance(input) : null;

                                if (field.hasWarnings) {
                                    for (var warning in field.warnings) {
                                        alert(field.warnings[warning]);
                                    }

                                    return this.error ? this.error(jqXHR, textStatus, field.warnings) : null;
                                }

                                if (api) {
                                    // update the fileuploader's file names
                                    for (var i = 0; i < field.files.length; i++) {
                                        $.each(api.getChoosedFiles(), function(index, item) {
                                            if (field.files[i].old_name == item.name) {
                                                item.name = field.files[i].name;
                                                item.html.find('.column-title > div:first-child').text(field.files[i].name).attr('title', field.files[0].name);
                                            }
                                            item.data.uploaded = true;
                                        });
                                    }

                                    api.updateFileList();
                                }
                            } else {
                                $form.find('[name="' + key + '"]:input').val(field);
                            }
                        }
                    } catch (e) {}

                    $form.find('input[type="submit"]').removeAttr('disabled');

                    $("#modal_form_importar").modal("hide");
                    $('#modal_importar_success').modal({
                        show : true,
                        backdrop: 'static',
                        keyboard: false
                    });

                    let path= data['files']['files'][0]['file'];
                    $.post( "users/importar_users", {"path": path} ,function( data )
                    {
                        console.log(data);
                    });

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $form.find('.form-status').html('<p class="text-error">Error!</p>');
                    $form.find('input[type="submit"]').removeAttr('disabled');
                    $(".btn-importar").removeClass('btn-disabled disabled');
                    $(".btn-importar").removeAttr('disabled');                     
                },
                progress: function(e) {
                    if (e.lengthComputable) {
                        var t = Math.round(e.loaded * 100 / e.total).toString();

                        $form.find('.form-status .progressbar').css('width', t + '%');
                    }
                }
            });
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
