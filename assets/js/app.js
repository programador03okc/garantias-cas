$(document).ready(function(){
    seleccionarMenu(window.location);
    var pathname = window.location.pathname;
    if (pathname == '/lista' || pathname == '/equipo' || pathname == '/asignacion'){
        $('.sidebar-mini').addClass('sidebar-collapse');
    }else if (pathname == '/registro'){
        $('#fecha_sol').val(moment().format('YYYY-MM-DD'));
        $('#aten_fecha').val(moment().format('YYYY-MM-DD'));
    }else if (pathname == '/asignacion'){
        $('input[type="date"]').val(moment().format('YYYY-MM-DD'));
    }
	/* Utilitys */
	idioma = {
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
        "oPaginate":
        {
            "sFirst":    "Primero",
            "sLast":     "Último",
            "sNext":     "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria":
        {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
    }

    $.ui.autocomplete.prototype._renderItem = function (ul, item){
        item.label = item.label.replace(new RegExp("(?![^&;]+;)(?!<[^<>]*)(" + $.ui.autocomplete.escapeRegex(this.term) + ")(?![^<>]*>)(?![^&;]+;)", "gi"), '<strong style="color:#0174DF;">$1</strong>');
        return $("<li></li>").data("item.autocomplete", item).append('<a>' + item.label + "</a>").appendTo(ul);
    };

    /* Estilos para Web */
    $('.mytable').css('width', '100%');
    $('[data-toggle="tooltip"]').tooltip();

    /* Autocomplete */
    $('[name=cliente]').autocomplete({
        source: baseUrl + 'registro/loadCustomer',
        select: function(event, ui){
            var id = ui.item.id;
            var name = ui.item.name;
            $('[name=id_cliente]').val(ui.item.id);
        }
    });

    /* starPage de DataTables */
        /* starPage de DataTables */
    $('#tablaSolicitud').DataTable({
        'language' : idioma,
        "lengthMenu": [[5, 15, 30, -1], [5, 15, 30, "Todos"]],
        'responsive': true,
        "processing": true,
        'ajax' : baseUrl + 'lista/start/1',
        'columnDefs': [{'aTargets': [1, 3, 4, 5, 6, 8, 9], 'sClass': 'text-center'}],
        'order' : []
    });
    $('#tablaSolicitudCerrada').DataTable({
        'language' : idioma,
        "lengthMenu": [[5, 15, 30, -1], [5, 15, 30, "Todos"]],
        'responsive': true,
        "processing": true,
        'ajax' : baseUrl + 'lista/start/2',
        'columnDefs': [{'aTargets': [1, 3, 4, 5, 6, 8, 9], 'sClass': 'text-center'}],
        'order' : []
    });
    $('#tablaMarca').DataTable({
        'language' : idioma,
        'responsive': true,
        "processing": true,
        'ajax' : baseUrl + 'marca/start',
        'order' : []
    });
    $('#tablaCategoria').DataTable({
        'language' : idioma,
        'responsive': true,
        "processing": true,
        'ajax' : baseUrl + 'categoria/start',
        'order' : []
    });
    $('#tablaTipo').DataTable({
        'language' : idioma,
        'responsive': true,
        "processing": true,
        'ajax' : baseUrl + 'tipo/start',
        'order' : []
    });
    $('#tablaEquipo').DataTable({
        'language' : idioma,
        'responsive': true,
        "processing": true,
        'ajax' : baseUrl + 'equipo/start',
        'columnDefs': [{'aTargets': [0, 1, 2, 3, 4, 5, 6, 7], 'sClass': 'text-center'}],
        'order' : []
    });

    /* Register warranty */
    $('#fomRegister').on('submit', function(){
        var emp = $('#empresa').val();
        var cat = $('#categoria').val();
        var pro = $('#producto').val();
        var sol = $('#fecha_sol').val();
        var question = confirm('¿Desea grabar esta solicitud?');
        if (question == true){
            var data = $(this).serialize() + '&id_empresa=' + emp + '&id_categoria=' + cat + '&producto=' + pro + '&fecha_sol=' + sol;
            $.ajax({
                type: 'POST',
                url: baseUrl + 'registro/registerRequest',
                data: data,
                dataType: 'JSON',
                beforeSend: function(){
                    $(document.body).append('<span class="loading"><div></div></span>');
                },
                success: function(response){
                    $('.loading').remove();
                    if (response == 'ok'){
                        swal({title: "Exito!", text: "Se guardo la solicitud correctamente.", type: "success"}).then(
                            function(){ location.reload(); }
                        );
                    }else{
                        swal("Error!", "Inténtelo mas tarde.", "error");
                    }
                }
            });
            return false;
        }else{
            return false;
        }
    });

    $('#formEdition').on('submit', function(){
        var question = confirm('¿Desea editar esta solicitud?');
        var data = $(this).serialize();
        if (question == true){
            $.ajax({
                type: 'POST',
                url: baseUrl + 'registro/editionAction',
                data: data,
                dataType: 'JSON',
                beforeSend: function(){
                    $(document.body).append('<span class="loading"><div></div></span>');
                },
                success: function(response){
                    $('.loading').remove();
                    if (response == 'ok'){
                        $('#formHistory')[0].reset();
                        swal({title: "Exito!", text: "Se editó la información correctamente.", type: "success"}).then(
                            function(){
                                $('#modal-edition').modal('hide'); 
                                $('#tablaSolicitud').DataTable().ajax.reload();
                                $('#tablaSolicitudCerrada').DataTable().ajax.reload();
                            }
                        );
                    }else{
                        swal("Error!", "Inténtelo mas tarde.", "error");
                    }
                }
            });
            return false;
        }else{
            return false;
        }
    });

    $('#formHistory').on('submit', function(){
        var question = confirm('¿Desea grabar este registro?');
        var data = $(this).serialize();
        if (question == true){
            $.ajax({
                type: 'POST',
                url: baseUrl + 'registro/registerAction',
                data: data,
                dataType: 'JSON',
                beforeSend: function(){
                    $(document.body).append('<span class="loading"><div></div></span>');
                },
                success: function(response){
                    $('.loading').remove();
                    if (response == 'ok'){
                        $('#formHistory')[0].reset();
                        swal({title: "Exito!", text: "Se guardo la información correctamente.", type: "success"}).then(
                            function(){
                                $('#modal-historial').modal('hide'); 
                                $('#tablaSolicitud').DataTable().ajax.reload();
                                $('#tablaSolicitudCerrada').DataTable().ajax.reload();
                            }
                        );
                    }else{
                        swal("Error!", "Inténtelo mas tarde.", "error");
                    }
                }
            });
            return false;
        }else{
            return false;
        }
    });

    $('#formulario').on('submit', function(){
        var data = $(this).serialize();
        var form = $(this).attr('form');
        var type = $(this).attr('type');
        var page = 'formulario';
        var ask = confirm('¿Desea guardar este registro?');

        var url;
        var msj;
        if (ask == true){
            switch(form){
                case 'marca':
                    var table = '#tablaMarca';
                    if (type == 'register'){
                        var url = baseUrl + 'marca/register';
                        var msj = 'Marca agregada con éxito.';
                        actionForms(data, table, url, msj, page, form);
                        return false;
                    }else if(type == 'edition'){
                        var url = baseUrl + 'marca/edition/updateData';
                        var msj = 'Marca editada con éxito.';
                        actionForms(data, table, url, msj, page, form);
                        return false;
                    }
                break;
                case 'categoria':
                    var table = '#tablaCategoria';
                    if (type == 'register'){
                        var url = baseUrl + 'categoria/register';
                        var msj = 'Categoría agregada con éxito.';
                        actionForms(data, table, url, msj, page, form);
                        return false;
                    }else if(type == 'edition'){
                        var url = baseUrl + 'categoria/edition/updateData';
                        var msj = 'Categoría editada con éxito.';
                        actionForms(data, table, url, msj, page, form);
                        return false;
                    }
                break;
                case 'tipo':
                    var table = '#tablaTipo';
                    if (type == 'register'){
                        var url = baseUrl + 'tipo/register';
                        var msj = 'Tipo de equipo agregado con éxito.';
                        actionForms(data, table, url, msj, page, form);
                        return false;
                    }else if(type == 'edition'){
                        var url = baseUrl + 'tipo/edition/updateData';
                        var msj = 'Tipo de equipo editado con éxito.';
                        actionForms(data, table, url, msj, page, form);
                        return false;
                    }
                break;
                case 'equipo':
                    var table = '#tablaEquipo';
                    if (type == 'register'){
                        var url = baseUrl + 'equipo/register';
                        var msj = 'Equipo agregaoa con éxito.';
                        actionForms(data, table, url, msj, page, form);
                        return false;
                    }else if(type == 'edition'){
                        var url = baseUrl + 'equipo/edition/updateData';
                        var msj = 'Equipo editado con éxito.';
                        actionForms(data, table, url, msj, page, form);
                        return false;
                    }
                break;
            }
        }else{
            return false;
        }
    });

    /* Configuration password */
    $('#formSettingsPassword').on('submit', function(){
        var question = confirm('¿Desea actualizar su contraseña?');
        if(question == true){
            var pass = $('[name=pass_2]').val();
            var repass = $('[name=pass_3]').val();
            if(pass == repass){
                var data = $(this).serialize();
                $.ajax({
                    type: 'POST',
                    url: baseUrl + 'registro/updatePassword',
                    data: data,
                    dataType: 'JSON',
                    beforeSend: function(){
                        $(document.body).append('<span class="loading"><div></div></span>');
                    },
                    success: function(response){
                        $('.loading').remove();
                        if(response == 'ok'){
                            alert('Contraseña correctamente actualizada.');
                            $('#formSettingsPassword')[0].reset();
                        }else if(response == 'null'){
                            alert('La contraseña actual no es correcta.');
                            $('[name=pass_1]').focus();
                        }else{
                            alert('Problemas al actualizar la contraseña, intentelo mas tarde.');
                        }
                    }
                });
                return false;
            }else{
                alert('Las contraseñas no son iguales, confirme porfavor.');
                $('[name=pass-3]').focus();
                return false;
            }
        }else{
            return false;
        }
    });

    $('#formAccesory').on('submit', function(){
        var data = $(this).serialize();
        var question = confirm('¿Desea agregar el accesorio?');
        if(question == true){
            $.ajax({
                type: 'POST',
                url: baseUrl + 'equipo/register_accesory',
                data: data,
                dataType: 'JSON',
                beforeSend: function(){
                    $(document.body).append('<span class="loading"><div></div></span>');
                },
                success: function(response){
                    $('.loading').remove();
                    if (response.response == 'ok'){
                        swal("EXITO", "Se registró el accesorio correctamente.", "success").then(
                            function(){ $('#tablaEquipo').DataTable().ajax.reload(); $('#modal-add-accesory').modal('hide');  }
                        );
                    }else{
                        swal("ERROR", "Problemas al cargar el accesorio, intentelo mas tarde.", "error");
                    }
                }
            });
            return false;
        }else{
            return false;
        }
    });
    
    $('#formRepower').on('submit', function(){
        var data = $(this).serialize();
        var question = confirm('¿Desea guardar la información?');
        if(question == true){
            $.ajax({
                type: 'POST',
                url: baseUrl + 'equipo/register_repower',
                data: data,
                dataType: 'JSON',
                beforeSend: function(){
                    $(document.body).append('<span class="loading"><div></div></span>');
                },
                success: function(response){
                    $('.loading').remove();
                    if (response.response == 'ok'){
                        swal("EXITO", "Se registró la repotenciación correctamente.", "success").then(
                            function(){ $('#tablaEquipo').DataTable().ajax.reload(); $('#modal-repower').modal('hide');  }
                        );
                    }else{
                        swal("ERROR", "Problemas al cargar la repotenciación, intentelo mas tarde.", "error");
                    }
                }
            });
            return false;
        }else{
            return false;
        }
    });

    $('#formModify').on('submit', function(){
        var data = $(this).serialize();
        var question = confirm('¿Desea guardar la información?');
        if(question == true){
            $.ajax({
                type: 'POST',
                url: baseUrl + 'equipo/register_modify',
                data: data,
                dataType: 'JSON',
                beforeSend: function(){
                    $(document.body).append('<span class="loading"><div></div></span>');
                },
                success: function(response){
                    $('.loading').remove();
                    if (response.response == 'ok'){
                        swal("EXITO", "Se registró la modificación correctamente.", "success").then(
                            function(){ $('#tablaEquipo').DataTable().ajax.reload(); $('#modal-modify-pc').modal('hide');  }
                        );
                    }else{
                        swal("ERROR", "Problemas al cargar la modificación, intentelo mas tarde.", "error");
                    }
                }
            });
            return false;
        }else{
            return false;
        }
    });

    $('#formAccess').on('submit', function(){
        var data = $(this).serialize();
        var question = confirm('¿Desea agregar el acceso?');
        if(question == true){
            $.ajax({
                type: 'POST',
                url: baseUrl + 'equipo/register_acceso',
                data: data,
                dataType: 'JSON',
                beforeSend: function(){
                    $(document.body).append('<span class="loading"><div></div></span>');
                },
                success: function(response){
                    $('.loading').remove();
                    if (response.response == 'ok'){
                        swal("EXITO", "Se registró el acceso correctamente.", "success").then(
                            function(){ $('#tableAccesos').html(response.view);  }
                        );
                    }else{
                        swal("ERROR", "Problemas al cargar el acceso, intentelo mas tarde.", "error");
                    }
                }
            });
            return false;
        }else{
            return false;
        }
    });

    $('#formAsign').on('submit', function(){
        var data = $(this).serialize();
        var question = confirm('¿Desea registrar la asignación?');
        if(question == true){
            $.ajax({
                type: 'POST',
                url: baseUrl + 'asignacion/register',
                data: data,
                dataType: 'JSON',
                beforeSend: function(){
                    $(document.body).append('<span class="loading"><div></div></span>');
                },
                success: function(response){
                    $('.loading').remove();
                    if (response.response == 'ok'){
                        swal("EXITO", "Se registró la asignación correctamente.", "success").then(
                            function(){ $('#tbodyAsig').html(response.view);  }
                        );
                    }else{
                        swal("ERROR", "Problemas al cargar la asignación, intentelo mas tarde.", "error");
                    }
                }
            });
            return false;
        }else{
            return false;
        }
    });

});

function actionForms(data, table, urls, msj, page, form){
    $.ajax({
        type: 'POST',
        url: urls,
        data: data,
        dataType: 'JSON',
        beforeSend: function(){
            $(document.body).append('<span class="loading"><div></div></span>');
        },
        success: function(response){
            $('.loading').remove();
            var status = response.response;
            if (status == 'ok'){
                $('#'+page)[0].reset();
                swal({title: "Exito!", text: msj, type: "success"}).then(
                    function(){
                        $('#modal-'+form).modal('hide'); 
                        $(table).DataTable().ajax.reload();
                    }
                );
            }else{
                swal("Error!", "Inténtelo mas tarde.", "error");
            }
        }
    }).fail( function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR);
        console.log(textStatus);
        console.log(errorThrown);
    });
}

function clearCab(){
    $('#empresa').val(0);
    $('#categoria').val(0);
    $('#producto').val('');
    $('#fecha_sol').val(moment().format('YYYY-MM-DD'));
}

/* Open Modal */
function openModal(type){
    $('.formPage')[0].reset();
    $('.formPage').attr('type', 'register');

    switch(type){
        case 'empresa':
            $('#modal-empresa').modal({show: true, backdrop: 'static'});
            $('#modal-empresa').on('shown.bs.modal', function(){
                $('[name=document]').focus();
            });
        break;
        case 'categoria':
            $('#modal-categoria').modal({show: true, backdrop: 'static'});
            $('#modal-categoria').on('shown.bs.modal', function(){
                $('[name=desc]').focus();
            });
        break;
        case 'marca':
            $('#modal-marca').modal({show: true, backdrop: 'static'});
            $('#modal-marca').on('shown.bs.modal', function(){
                $('[name=desc]').focus();
            });
        break;
        case 'tipo':
            $('#modal-tipo').modal({show: true, backdrop: 'static'});
            $('#modal-tipo').on('shown.bs.modal', function(){
                $('[name=desc]').focus();
            });
        break;
        case 'producto':
            $('#modal-producto').modal({show: true, backdrop: 'static'});
            $('#modal-producto').on('shown.bs.modal', function(){
                $('[name=marca]').focus();
            });
        break;
        case 'equipo':
            $('#modal-equipo').modal({show: true, backdrop: 'static'});
            $('#modal-equipo').on('shown.bs.modal', function(){
                $('[name=codigo]').focus();
            });
        break;
    }
}

function openModalSettings() {
    $('#modalSettings').modal({show: true, backdrop: 'static'});
}

/* Loads */
function loadProvince(value){
    $.ajax({
        type: 'GET',
        url: baseUrl + 'registro/loadProvince/' + value,
        dataType: 'JSON',
        success: function(response){
            $('#provin').html('<option value="0" selected disabled>Elija una opción</option>' + response);
        }
    }).fail( function(jqXHR, textStatus, errorThrown){
        console.log(jqXHR);
        console.log(textStatus);
        console.log(errorThrown);
    });
}

function loadDistrict(value){
    $.ajax({
        type: 'GET',
        url: baseUrl + 'registro/loadDistrict/' + value,
        dataType: 'JSON',
        success: function(response){
            $('#dist').html('<option value="0" selected disabled>Elija una opción</option>' + response);
        }
    }).fail( function(jqXHR, textStatus, errorThrown){
        console.log(jqXHR);
        console.log(textStatus);
        console.log(errorThrown);
    });
}

function clearCustomer(){
    $('#cliente').val('');
    $('#id_cliente').val('0');
    $('#cliente').focus();
}

function ProcessRequest(){
    var emp = $('#empresa').val();
    var cat = $('#categoria').val();
    var pro = $('#producto').val();
    var fec = $('#fecha_sol').val();

    if (emp > 0){
        if(cat > 0){
            if (pro != ''){
                if (fec != ''){
                    $('.panel-okc .input-sm').removeAttr('disabled');
                    $('.panel-okc-head .input-sm').attr('disabled', true);
                    $('#fecha_rec').val(fec);
                }else{
                    alert('Debe ingresar la fecha de solicitud');
                    $('#fecha_sol').focus(); 
                }
            }else{
                alert('Debe ingresar la serie del producto');
                $('#producto').focus();
            }
        }else{
            alert('Debe seleccionar la categoria del producto');
            $('#categoria').focus();
        }
    }else{
        alert('Debe seleccionar la empresa');
        $('#empresa').focus();
    }
}

function detailRequest(id){
    $.ajax({
        type: 'GET',
        url: baseUrl + 'lista/detailRequest/' + id,
        dataType: 'JSON',
        beforeSend: function(){
            $(document.body).append('<span class="loading"><div></div></span>');
        },
        success: function(response){
            $('.loading').remove();
            $('#titleCodigo').text(response.codigo);
            $('#bodyDetail').html(response.response);
            $('#modal-detalle-solicitud').modal({show: true, backdrop: 'static'});
        }
    });
    return false;
}

function historialRequest(id){
    $('#id_solicitud').val(id);
    $('#status').val(2);
    $('#formHistory').attr('type', 'pendiente');
    $('#titleHistorial').text('Historial de Pendientes');
    $('#fecha_hist').val(moment().format('YYYY-MM-DD'));
    $('#modal-historial').modal({show: true, backdrop: 'static'});
}

function closeRequest(id){
    $('#id_solicitud').val(id);
    $('#status').val(3);
    $('#formHistory').attr('type', 'cierre');
    $('#titleHistorial').text('Cierre de Solicitud');
    $('#fecha_hist').val(moment().format('YYYY-MM-DD'));
    $('#modal-historial').modal({show: true, backdrop: 'static'});
}

function deleteRequest(id){
    var ask = confirm('¿Desea eliminar este registro');
    if (ask == true){
        $.ajax({
            type: 'GET',
            url: baseUrl + 'lista/delete/' + id,
            beforeSend: function(){
                $(document.body).append('<span class="loading"><div></div></span>');
            },
            success: function(response){
                $('.loading').remove();
                if(response > 0){
                    swal("Exito!", "Solicitud eliminada con éxito", "success");
                    $('#tablaSolicitud').DataTable().ajax.reload();
                }else{
                    swal("Error!", "Inténtelo mas tarde.", "error");
                }
            }
        });
        return false;
    }else{
        return false;
    }
}

function detailTotalRequest(id, codigo){
    $.ajax({
        type: 'GET',
        url: baseUrl + 'lista/detailHistoryRequest/' + id,
        dataType: 'JSON',
        beforeSend: function(){
            $(document.body).append('<span class="loading"><div></div></span>');
        },
        success: function(response){
            $('.loading').remove();
            $('#bodyHistoryDetail').html(response);
            $('#SolHistTitle').text('Solicitud: ' + codigo);
            $('#modal-historial-solicitud').modal({show: true, backdrop: 'static'});
        }
    });
    return false;
}

function selectProd(){
    var marca = $('#marca').val();
    var model = $('#modelo').val();
    var serie = $('#serie').val();

    if (marca > 0){
        if (model != ''){
            if (serie != ''){
                enviarData(marca, model, serie);
            }else{
                alert('Ingresar la serie del producto');
                $('#serie').focus();
            }
        }else{
            alert('Ingresar el modelo del producto');
            $('#modelo').focus();
        }
    }else{
        alert('Seleccionar la marca del producto');
        $('#marca').focus();
    }
}

function enviarData(mark, model, serie){
    $('#id_marca').val(mark);
    $('#model_producto').val(model);
    $('#producto').val(serie);
    $('#modal-producto').modal('hide');
}

function deletePage(id, type){
    var ask = confirm('¿Desea eliminar este registro');
    switch(type){
        case 'marca':
            if (ask == true){
                $.ajax({
                    type: 'GET',
                    url: baseUrl + 'marca/delete/' + id,
                    beforeSend: function(){
                        $(document.body).append('<span class="loading"><div></div></span>');
                    },
                    success: function(response){
                        $('.loading').remove();
                        if(response > 0){
                            swal("Exito!", "Marca eliminada con éxito", "success");
                            $('#tablaMarca').DataTable().ajax.reload();
                        }else{
                            swal("Error!", "Inténtelo mas tarde.", "error");
                        }
                    }
                });
                return false;
            }else{
                return false;
            }
        break;
        case 'categoria':
            if (ask == true){
                $.ajax({
                    type: 'GET',
                    url: baseUrl + 'categoria/delete/' + id,
                    beforeSend: function(){
                        $(document.body).append('<span class="loading"><div></div></span>');
                    },
                    success: function(response){
                        $('.loading').remove();
                        if(response > 0){
                            swal("Exito!", "Categoria eliminada con éxito", "success");
                            $('#tablaCategoria').DataTable().ajax.reload();
                        }else{
                            swal("Error!", "Inténtelo mas tarde.", "error");
                        }
                    }
                });
                return false;
            }else{
                return false;
            }
        break;
        case 'tipo':
            if (ask == true){
                $.ajax({
                    type: 'GET',
                    url: baseUrl + 'tipo/delete/' + id,
                    beforeSend: function(){
                        $(document.body).append('<span class="loading"><div></div></span>');
                    },
                    success: function(response){
                        $('.loading').remove();
                        if(response > 0){
                            swal("Exito!", "Tipo de Equipo eliminado con éxito", "success");
                            $('#tablaTipo').DataTable().ajax.reload();
                        }else{
                            swal("Error!", "Inténtelo mas tarde.", "error");
                        }
                    }
                });
                return false;
            }else{
                return false;
            }
        break;
    }
}

function editarRequest(id, idc){
    $.ajax({
        type: 'GET',
        url: baseUrl + 'registro/loadInfo/' + id + '/' + idc,
        dataType: 'JSON',
        success: function(response){
            $('[name=id_solicit]').val(id);
            $('[name=id_contac]').val(idc);

            $('[name=cont_reporta]').val(response.dts_rpor);
            $('[name=tlf_reporta]').val(response.tlf_rpor);
            $('[name=mail_reporta]').val(response.mai_rpor);
            $('[name=cont_princ]').val(response.dts_prin);
            $('[name=tlf_princ]').val(response.tlf_prin);
            $('[name=mail_princ]').val(response.mai_prin);
            $('[name=direccion]').val(response.direc);
            $('[name=problema]').val(response.des_prob);
            $('[name=orden_cc]').val(response.ord_comp);
            $('[name=cuadro_cc]').val(response.num_ccoo);
			if (response.tipo_int) {
                $('[name=tipo_interv]').val(response.tipo_int);
            }
            $('#modal-edition').modal({show: true, backdrop: 'static'});
        }
    });
}

function createSlot(value){
    var html = '';
    for (var i = 1; i <= value; i++){
        html+=
        '<div class="col-md-12">'+
            '<h5>Slot #'+i+'</h5>'+
            '<input type="text" class="form-control input-sm" name="cant_slot[]" placeholder="Ingrese la descripción">'+
        '</div>';
    }
    $('#cantSlot').html(html);
}

function addAccesory(id){
    $('#id_equipo_acc').val(id);
    $('#modal-add-accesory').modal({show: true, backdrop: 'static'});
}

function addPiece(id){
    $('#id_equipo_acc_rpw').val(id);
    $('#modal-repower').modal({show: true, backdrop: 'static'});
}

function addModify(id){
    $('#id_equipo_acc_mod').val(id);
    $('#modal-modify-pc').modal({show: true, backdrop: 'static'});
}

function addAccess(id){
    $.ajax({
        type: 'GET',
        url: baseUrl + 'equipo/loadDataAccess/' + id + '/echo',
        dataType: 'JSON',
        success: function(response){
            $('#modal-add-access').modal({show: true, backdrop: 'static'});
            $('#modal-add-access').on('shown.bs.modal', function(){
                $('#id_equipo_acs').val(id);
                $('#tableAccesos').html(response);
            });
        }
    });
}

function searchComputer(){
    var equipo = $('#equipo').val();
    $.ajax({
        type: 'GET',
        url: baseUrl + 'asignacion/searchComputer/' + equipo,
        dataType: 'JSON',
        success: function(response){
            console.log(response);
            if (response.id > 0){
                $('#id_equipo').val(response.id);
                $('#tbodyAsig').html(response.view);
                $('#new-asign').removeAttr('disabled');
            }else{
                alert('El equipo no se encuentra registrado');
                $('#equipo').focus();
            }
        }
    });
}

function newAsign(){
    var id_equipo = $('#id_equipo').val();
    var equipo = $('#equipo').val();
    $('#id_equipo_asg').val(id_equipo);
    $('#equipo_asg').val(equipo);
    $('#modal-asignacion').modal({show: true, backdrop: 'static'});
}

function printComputer(id){
    window.open(baseUrl + 'equipo/imprimir/' + id);
}

function editPage(id, types){
    switch(types){
        case 'marca':
            $.ajax({
                type: 'POST',
                url: baseUrl + 'marca/edition/bringData',
                data: 'id=' + id,
                dataType: 'JSON',
                beforeSend: function(){
                    $(document.body).append('<span class="loading"><div></div></span>');
                },
                success: function(response){
                    $('.loading').remove();
                    $('[name=id]').val(response.id);
                    $('[name=desc]').val(response.nom);

                    $('#formulario').attr('type', 'edition');
                    $('#modal-marca').modal({ show: true, backdrop: 'static'});
                }
            });
        break;
        case 'categoria':
            $.ajax({
                type: 'POST',
                url: baseUrl + 'categoria/edition/bringData',
                data: 'id=' + id,
                dataType: 'JSON',
                beforeSend: function(){
                    $(document.body).append('<span class="loading"><div></div></span>');
                },
                success: function(response){
                    $('.loading').remove();
                    $('[name=id]').val(response.id);
                    $('[name=desc]').val(response.nom);

                    $('#formulario').attr('type', 'edition');
                    $('#modal-categoria').modal({ show: true, backdrop: 'static'});
                }
            });
        break;
        case 'tipo':
            $.ajax({
                type: 'POST',
                url: baseUrl + 'tipo/edition/bringData',
                data: 'id=' + id,
                dataType: 'JSON',
                beforeSend: function(){
                    $(document.body).append('<span class="loading"><div></div></span>');
                },
                success: function(response){
                    $('.loading').remove();
                    $('[name=id]').val(response.id);
                    $('[name=desc]').val(response.nom);

                    $('#formulario').attr('type', 'edition');
                    $('#modal-tipo').modal({ show: true, backdrop: 'static'});
                }
            });
        break;
    }
}

/* footer functions */
function seleccionarMenu(url){
    $('ul.sidebar-menu a').filter(function () {
        return this.href == url;
    }).parent().addClass('active');

    $('ul.treeview-menu a').filter(function () {
        return this.href == url;
    }).parentsUntil(".sidebar-menu > .treeview-menu").addClass('active');
}