var procesarSolicitudAdmin = {
    //Declaracion Variables
    EstruturaMesajeExito: '<h5> <div class="alert alert-success pCenter"> <span class="glyphicon glyphicon-ok"></span>  <span> i_mensaje</span> </div></h5>',
    EstruturaMesajeInfo: '<h5><div class="alert alert-info pCenter"> <span class="glyphicon glyphicon-ok"></span> <span> i_mensaje</span> </div></h5>',
    EstruturaMesajePeligro: '<h5><div class="alert alert-danger pCenter"> <span class="glyphicon glyphicon-info-sign"></span> <span> i_mensaje</span> </div></h5>',
    EstruturaMesajeAdvertencia: '<h5><div class="alert alert-warning pCenter"> <span class="glyphicon glyphicon-info-sign"></span> <span> i_mensaje</span> </div></h5>',
    mensajeExito01:  '! Almacenamiento exitoso de Datos ¡',
    mensajeExito02:  '! Usted ha rechazado esta solicitud, deberá esperar por el administrador para su validación. ¡',
    mensajePeligro01:  '! Falla en el almacenamiento, intente mas tarde ¡',
    mensajeAdvertencia03:'! Hubo Problema con la validacion, por favor revise el archivo CSV ¡',
    //Metodo Inicial
    init: function () {
        procesarSolicitudAdmin.cargaDatos();
        procesarSolicitudAdmin.procesoBitacora();
        procesarSolicitudAdmin.changeCategoria();
        procesarSolicitudAdmin.changeTipoActivo();
        procesarSolicitudAdmin.changeMotivo();
        procesarSolicitudAdmin.changeCantidad();
        procesarSolicitudAdmin.changeEstatus();
        procesarSolicitudAdmin.procesoGuardado();
        procesarSolicitudAdmin.procesoRechaza();

        procesarSolicitudAdmin.validaTeclado();
        procesarSolicitudAdmin.procesoMuestra();
        procesarSolicitudAdmin.validaDeshabilitar();
        procesarSolicitudAdmin.funtCerrarReload();
    },// fin init
    changeCategoria:function () {
        $(document).on("change", "#selCategoria", function () {
            var valor = $("#selCategoria option:selected").val();
            $("#inpCategoria").val(valor);

            $.ajax({
                type: "POST",
                url: baseUrl + "/controlactivos/index/obtener-lista-activo",
                processData: true,
                dataType: 'json',
                data: {ID_CATEGORIA: valor, REFERENCIA: 'TIPO_ACTIVO'},
                success: function (data) {
                    procesarSolicitudAdmin.cargarSelectTipoActivo("selTipoActivo", data,  "DESC_UBICACION", "DESC_UBICACION" );
                }
            });
        });
    },
    changeTipoActivo:function () {
        $(document).on("change", "#selTipoActivo", function () {
            var valor = $("#selTipoActivo option:selected").val();
            $("#inpTipoActivo").val(valor);
        });
    },
    changeMotivo:function () {
        $(document).on("change", "#selMotivo", function () {
            var valor = $("#selMotivo option:selected").val();
            $("#inpMotivo").val(valor);
        });
    },
    changeCantidad:function () {
        $(document).on("change", "#selCantidad", function () {
            var valor = $("#selCantidad option:selected").val();
            $("#inpCantidad").val(valor);
        });
    },
    changeEstatus:function () {
        $(document).on("change", "#selEstatus", function () {
            var valor = $("#selEstatus option:selected").val();
            $("#inpEstatus").val(valor);
        });
    },
    cargaDatos:function () {
        $(document).ready( function () {
            var idEstatus =  $("#idEstatus").val();

            $('#dt_solicitud').DataTable( {
                processing: false, // esto permite realizar busqueda conectado con el servidor
                serverSide: false, // esto permite realizar busqueda conectado con el servidor
                ajax: {
                    url: baseUrl + "/controlactivos/index/obtener-json-solicitud/idEstatus/"+idEstatus,
                    dataSrc: 'data'
                },
                columns: [
                    { data: "ID_TRACKING" },
                    { data: "NOM_SOLICITANTE" },
                    { data: "TIPO_ACTIVO" },
                    { data: "NOM_SOLICITANTE" },
                    { data: "MOTIVO_SOLICITUD" },
                    { data: "NOM_ESTATUS" },
                    { data: "FECHA_FORMATO" },
                    { data: "ACCION" },
                ],
                language: {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": [
                        {
                            "sFirst": "Primero",
                            "sLast": "Ultimo",
                            "sNext": "Siguiente",
                            "sPrevious": "Anterior"
                        }
                    ],
                    "oAria": [
                        {
                            "sSortAscending": "Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": "UltiActivar para ordenar la columna de manera descendentemo"
                        }
                    ]
                },

                // language: {
                //     url: baseUrl + "/controlactivos/index/obtener-indioma",
                // }

            } );

        } );

    },
    procesoGuardado: function () {
        var validaCampos = $(function () {//esto permite convertir todo el validate en una funcion
            $("#formSolicitud").validate({
                event: "blur",
                rules: {
                    inpCategoria: {
                        required: true
                    },
                    inpTipoActivo: {
                        required: true
                    },
                    inpMotivo: {
                        required: true
                    },
                    inpCantidad: {
                        required: true
                    },
                    inpDes: {
                        required: true
                    },
                },
                messages: {
                    inpCategoria: {
                        required: "Este campo es obligatorio.",
                    },
                    inpTipoActivo: {
                        required: "Este campo es obligatorio.",
                    },
                    inpMotivo: {
                        required: "Este campo es obligatorio.",
                    },
                    inpCantidad: {
                        required: "Este campo es obligatorio.",
                    },
                    inpDes: {
                        required: "Este campo es obligatorio.",
                    },
                }
                , debug: true
                , errorElement: "label"
                , submitHandler: function (form) {
                    var datosForm = $("#formSolicitud").serializeArray();
                    $.ajax({
                        type: "POST",
                        url: baseUrl + "/controlactivos/index/procesar-solicitud",
                        processData: true,
                        data: datosForm,
                        success: function (data) {
                            procesarSolicitudAdmin.metodoMensaje(data, 'btnRegistrar');
                        }
                    });
                },
                errorPlacement: function (error, element) {
                    error.insertBefore(element.parent().next('div').children().first());
                },
                highlight: function (element) {
                    $(element).parent().next('div').show();
                    $(element).parent().next('div').addClass("error");
                    $(element).parent().find('span').addClass('glyphicon-red');
                },
                unhighlight: function (element) {
                    //$(element).parent().next('div').hide();
                    $(element).parent().find('span').removeClass('glyphicon-red');
                }

            })//fin del validate
        });//Esto permite transformar el validate en una funcion y encapsularla en la clase
    },
    procesoRechaza: function () {
        var validaCampos = $(function () {//esto permite convertir todo el validate en una funcion
            $("#formSolicitudRecha").validate({
                event: "blur",
                rules: {
                    inpDes: {
                        required: true
                    },
                    inpEstatus: {
                        required: true
                    },

                },
                messages: {
                    inpDes: {
                        required: "Este campo es obligatorio.",
                    },
                    inpEstatus: {
                        required: "Este campo es obligatorio.",
                    },

                }
                , debug: true
                , errorElement: "label"
                , submitHandler: function (form) {
                    var datosForm = $("#formSolicitudRecha").serializeArray();
                    $.ajax({
                        type: "POST",
                        url: baseUrl + "/controlactivos/index/procesar-solicitud",
                        processData: true,
                        data: datosForm,
                        success: function (data) {
                            var result = JSON.parse(data);
                            if (result['valida'] == 1) {
                                var str = procesarSolicitudAdmin.EstruturaMesajeExito;
                                var respHtml = str.replace("i_mensaje", procesarSolicitudAdmin.mensajeExito02);
                                $("#msjRespuestaRecha").html(respHtml);
                                $("#btnRechazar").attr('disabled', 'disable');
                            }
                            if (result['valida'] == 0) {
                                var str = procesarSolicitudAdmin.EstruturaMesajePeligro ;
                                var respHtml = str.replace("i_mensaje", procesoRemesas.mensajePeligro01);
                                $("#msjRespuestaRecha").html(respHtml);
                            }
                        }
                    });
                },
                errorPlacement: function (error, element) {
                    error.insertBefore(element.parent().next('div').children().first());
                },
                highlight: function (element) {
                    $(element).parent().next('div').show();
                    $(element).parent().next('div').addClass("error");
                    $(element).parent().find('span').addClass('glyphicon-red');
                },
                unhighlight: function (element) {
                    //$(element).parent().next('div').hide();
                    $(element).parent().find('span').removeClass('glyphicon-red');
                }

            })//fin del validate
        });//Esto permite transformar el validate en una funcion y encapsularla en la clase
    },
    procesoMuestra: function () {
        $(document).on("click", ".btnAccionEdit", function () {

            var id_tracking = $(this).attr("data-id_tracking");
            var id_solicitante = $(this).attr("data-id_solicitante");
            var nomMotivo = $(this).attr("data-motivo_solicitud");
            var cantidad = $(this).attr("data-cantidad");
            var nomTipoActivo = $(this).attr("data-tipo_activo");

            $("#inpIdTracking").val(id_tracking);
            $("#inpTipoActivoRecha").val(nomTipoActivo);
            $("#inpMotivoRecha").val(nomMotivo);
            $("#inpCantidadRecha").val(cantidad);

             procesarSolicitudAdmin.funtCerrarReload();


        });
    },
    procesoBitacora: function () {
        $(document).on("click", ".btnAccionBitacora", function () {

            var inpId = $(this).attr("data-id");

            $.ajax({
                type: "POST",
                url: baseUrl + "/controlactivos/index/obtener-bitacora",
                processData: true,
                // dataType: 'json',
                dataType: 'html',
                data: {idTracking: inpId},
                success: function (data) {
                    $("#bitacora").html(data);
                }
            });



        });
    },
    validaDeshabilitar: function () {
        $(document).on("click", ".btnAccionDel", function () {
            var id = $(this).attr("data-id");
            procesarSolicitudAdmin.modalMensaje('Confirmación', '¿ Está seguro de deshabilitar ?', id, 'btnAccionDel');

        });
    },
    procesoDeshabilitar: function (valor) {
        $.ajax({
            type: "POST",
            url: baseUrl + "/controlactivos/index/procesar-admin-activo",
            processData: true,
            dataType: 'json',
            data: {inptProceso: 'Deshabilitar', inpId: valor},
            success: function (data) {
                window.location.reload(true);
            }
        });

    },
    metodoMensaje: function (data, bonton) {
        var result = JSON.parse(data);
        if (result['valida'] == 1) {
            var str = procesarSolicitudAdmin.EstruturaMesajeExito;
            var respHtml = str.replace("i_mensaje", procesarSolicitudAdmin.mensajeExito01);
            $("#msjRespuesta").html(respHtml);
            $("#" + bonton).attr('disabled', 'disable');
        }
        if (result['valida'] == 0) {
            var str = procesarSolicitudAdmin.EstruturaMesajePeligro ;
            var respHtml = str.replace("i_mensaje", procesoRemesas.mensajePeligro01);
            $("#msjRespuesta").html(respHtml);
        }
        //procesoRemesas.funtCerrarReload();
    },
    validaTeclado: function () {
        var validaCamposTeclado = $(function () {
            $(".soloLetrasNum").keypress(function (e) {
                procesarSolicitudAdmin.metodoTeclado(e, "soloLetrasNum", this);
            });

            $(".soloFecha").keypress(function (e) {
                procesarSolicitudAdmin.metodoTeclado(e, "soloFecha", this);
            });

        });

    },
    metodoTeclado: function (e, permitidos, fieldObj, upperCase) {

        if (fieldObj.readOnly) return false;
        upperCase = typeof(upperCase) != 'undefined' ? upperCase : true;
        e = e || event;

        charCode = e.keyCode; // || e.keyCode;

        if ((procesarSolicitudAdmin.is_nonChar(charCode)) && e.shiftKey == 0)
            return true;
        else if (charCode == '')
            charCode = e.charCode;

        if (fieldObj.value.length == fieldObj.maxLength) return false;

        var caracter = String.fromCharCode(charCode);

        // Variables que definen los caracteres permitidos
        var numeros = "0123456789";
        var float = "0123456789.";
        var caracteres = "  abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZáéíóúÁÉÍÓÚ";
        var car_especiales = ".-_()'\"/&";

        //Los valores de las llaves del array representan los posibles valores permitidos
        var selectArray = new Array();
        selectArray['all'] = '';
        selectArray['num'] = numeros;
        selectArray['float'] = float;
        selectArray['soloLetrasNum'] = caracteres + numeros;
        selectArray['soloFecha'] = numeros + '/';

        // Comprobar si la tecla pulsada se encuentra en los caracteres permitidos
        if ((selectArray[permitidos].indexOf(caracter) != -1) || (permitidos == 'all')) {
            return (true);
        }
        else {
            if (e.preventDefault)
                e.preventDefault();
            else
                e.returnValue = false;
        }
    },
    is_nonChar: function (charCode) {

        // 8 = BackSpace, 9 = tabulador, 13 = enter, 35 = fin, 36 = inicio, 37 = flecha izquierda, 38 = flecha arriba,
        // 39 = flecha derecha, 37 = flecha izquierda, 40 = flecha abajo 46 = delete.

        var teclas_especiales = [8, 9, 13, 35, 36, 37, 38, 39, 40, 46];
        // if ( jQuery.browser.msie) {
        //     return (false);
        // }
        for (var i in teclas_especiales) {

            if (charCode == teclas_especiales[i]) {
                return (true);
            }
        }
    },
    modalMensaje: function (titulo1, mensaje, valor, proceso) {

        BootstrapDialog.show({
            title: titulo1,
            message: mensaje,
            cssClass: 'prueba',
            type: 'type-danger',
            size: 'size-normal',
            closable: true,
            spinicon: 'glyphicon glyphicon-eur',
            buttons: [{
                id: 'btn-remove',
                icon: 'glyphicon glyphicon-remove',
                label: 'No',
                cssClass: 'btn-danger',
                action: function (dialog) {
                    dialog.close();
                }
            }, {
                id: 'btn-ok',
                icon: 'glyphicon glyphicon-check',
                label: 'Si',
                cssClass: 'btn-info',
                autospin: false,
                action: function (dialog) {
                    procesarSolicitudAdmin.procesoDeshabilitar(valor);
                    dialog.close();
                    procesarSolicitudAdmin.funtCerrarReload();
                }
            }]
        });

    },
    funtCerrarReload: function () {
        $(document).on("click", "#btnCerrar", function () {
            window.location.reload(true);
        });

    },
    cargarSelectTipoActivo: function (nomSelect, array, optionText, optionval) {
        console.log(nomSelect);
        // Ordena el Array Alfabeticamente, es muy facil ;)):
        // array.sort();
        var select = document.getElementsByName(nomSelect)[0];
        if (array.length == 0){
            $('#selTipoActivo option').remove();
            var option = document.createElement("option");
            option.text = 'No hay Datos';
            option.value = 0;
            select.add(option);

        }else{
            $('#selTipoActivo option').remove();

            for(var i=0;i<array.length;i++){
                var option = document.createElement("option");
                option.text = array[i].NOM_CATEGORIA;
                option.value = array[i].ID_CACT_CATEGORIA;
                select.add(option);
            }
        }


    },

};
procesarSolicitudAdmin.init();