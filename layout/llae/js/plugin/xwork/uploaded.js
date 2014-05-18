/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery.fn.resetForm = function() {
          $(this).each(function() {
                    this.reset();
          });
};

$.uploaded = function(objIn, objOut, destino, download) {
          objIn = $(objIn);
          var d = objIn.html(), fk = 0, desc, fileDir;
          var senForm = objIn.find('form');
          senForm.submit(function(e) {
                    e.preventDefault();
                    fk = $("#idrespuestaFK").val();
                    desc = $("#descripcionFile").val();
                    fileDir = $("#NameOfFile").val();
                    var data = new FormData($(senForm)[0]);
                    var dataForm = $(senForm).serialize();
                    if (desc != "") {
                              if (fileDir != "") {
                                        if (fk != 0) {
                                                  $.blackout.show("Guardando...");
                                                  $.ajax({
                                                            type: "POST",
                                                            url: destino,
                                                            data: data,
                                                            cache: false,
                                                            contentType: false,
                                                            processData: false
                                                  }).done(function(data) {
                                                            setTimeout(function() {
                                                                      try {
                                                                                var arr_response = JSON.parse(data);
                                                                                //onsole.log(arr_response);
                                                                                if (arr_response.status === 1) {
                                                                                          $.uploaded.success(objOut, objIn, arr_response,download);
                                                                                } else {
                                                                                          $.uploaded.error(objOut, objIn, 'No hemos podido cargar directamente el archivo');
                                                                                }
                                                                      } catch (e) {
                                                                                $.uploaded.error(objOut, objIn, 'Ha ocurrido un error desconocido cargando el archivo');
                                                                      }
                                                            }, 200);
                                                  });
                                        } else {
                                                  //error id
                                        }
                              } else {
                                        //error file
                              }
                    } else {
                              //error desc
                    }
          });
};
//clientebancario.cl
$.uploaded.success = function(objOut, objIn, json, download,delete_doc) {
          var r = '<fieldset style="display:none" id="containerDoc' + json.id + '">\n' +
                  '<div class="clearfix">\n' +
                  '<section style="float: left;width: 57px;padding: 6px 10px;">\n' +
                  '          <img width="38" src="' + json.file + '">\n' +
                  '</section>\n' +
                  '<section style="float: left;padding: 7px;max-width: 265px;">\n' +
                  '          <p>' + json.desc + '</p>\n' +
                  '</section>\n' +
                  '<section style="float: right;padding: 7px; width:180px;text-align:right;">\n' +
                  '          <a class="btn btn-success btn-xs" href="' + download + '/' + json.id + '" target="_blank"><i class="fa fa-download"></i> Descargar</a>\n';
                  if(typeof delete_doc === "undefined"){
                              r +='          <a class="btn btn-danger btn-xs" href="#" onclick="deleteDoc(this,\'' + json.id + '\');return false;"><i class="fa fa-times"></i> Eliminar</a>\n';
                    }
                  r += '</section>\n' +
                  '</div>\n' +
                  '</fieldset>';
          $(objOut).append(r);
          $(objIn).find('form').resetForm();
          $.blackout.hide(function(){$("#containerDoc" + json.id).slideDown();});
};

$.uploaded.error = function(objOut, objIn, str) {
          var r = '<div class="alert alert-danger fade in">\n'+
                              '<button class="close" data-dismiss="alert">\n'+
                              '          ×\n'+
                              '</button>\n'+
                              '<i class="fa-fw fa fa-times"></i>\n'+
                              '<strong>Error!</strong> '+str+'.\n'+
                    '</div>';
          $(objOut).append(r);
          $(objIn).find('form').resetForm();
};

