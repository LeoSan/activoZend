var procesarAdminActivo = {
    //Declaracion Variables
    EstruturaMesajeExito: '<h5> <div class="alert alert-success pCenter"> <span class="glyphicon glyphicon-ok"></span>  <span> i_mensaje</span> </div></h5>',
    EstruturaMesajeInfo: '<h5><div class="alert alert-info pCenter"> <span class="glyphicon glyphicon-ok"></span> <span> i_mensaje</span> </div></h5>',
    EstruturaMesajePeligro: '<h5><div class="alert alert-danger pCenter"> <span class="glyphicon glyphicon-info-sign"></span> <span> i_mensaje</span> </div></h5>',
    EstruturaMesajeAdvertencia: '<h5><div class="alert alert-warning pCenter"> <span class="glyphicon glyphicon-info-sign"></span> <span> i_mensaje</span> </div></h5>',
    mensajeExito01:  '! Almacenamiento exitoso de Datos ¡',
    mensajeExito02:  '! Almacenamiento exitoso del Archivo ¡',
    mensajeExito03:  '! Validacion exitosa del archivo ¡',
    mensajeExito04:  '! Carga exitosa del archivo ¡',
    mensajePeligro01:  '! Falla en el almacenamiento, intente mas tarde ¡',
    mensajeAdvertencia02:'! Debe seleccionar un archivo ¡',
    mensajeAdvertencia03:'! Hubo Problema con la validacion, por favor revise el archivo CSV ¡',
    //Metodo Inicial
    init: function () {
        procesarAdminActivo.cargaDatos();
        procesarAdminActivo.changeCategoria();
        procesarAdminActivo.changeTipoActivo();
        procesarAdminActivo.changeTipoAsignacion();
        procesarAdminActivo.changeEstadoFisico();
        procesarAdminActivo.changeProveedor();
        procesarAdminActivo.changeSucursal();
        procesarAdminActivo.changeUbicacion();
        procesarAdminActivo.changePiso();
        procesarAdminActivo.changeNomUbi();
        procesarAdminActivo.calendario();

        procesarAdminActivo.procesoUpload();
        procesarAdminActivo.procesoCargaMasiva();
        procesarAdminActivo.validaTeclado();
        procesarAdminActivo.procesoGuardado();
        procesarAdminActivo.procesoMuestra();
        procesarAdminActivo.validaDeshabilitar();
        procesarAdminActivo.funtCerrarReload();
    },// fin init
    changeCategoria:function () {
        $(document).on("change", "#selCategoria", function () {
            var valor = $("#selCategoria option:selected").val();
            $("#inpCategoria").val(valor);
        });

    },
    changeTipoActivo:function () {
        $(document).on("change", "#selTipoActivo", function () {
            var valor = $("#selTipoActivo option:selected").val();
            $("#inpTipoActivo").val(valor);
        });

    },
    changeTipoAsignacion:function () {
        $(document).on("change", "#selTipoAsignacion", function () {
            var valor = $("#selTipoAsignacion option:selected").val();
            $("#inpTipoAsignacion").val(valor);
        });

    },
    changeEstadoFisico:function () {
        $(document).on("change", "#selEstadoFisico", function () {
            var valor = $("#selEstadoFisico option:selected").val();
            $("#inpEstadoFisico").val(valor);
        });

    },
    changeProveedor:function () {
        $(document).on("change", "#selProveedor", function () {
            var valor = $("#selProveedor option:selected").val();
            $("#inpProveedor").val(valor);
        });

    },
    changeSucursal:function () {
        $(document).on("change", "#selSucursal", function () {
            var valor = $("#selSucursal option:selected").val();
            $("#inpSucursal").val(valor);
            console.log("valor"+valor);
            var array = ["Cantabria", "Asturias", "Galicia", "Andalucia", "Extremadura"];

            $.ajax({
                type: "POST",
                url: baseUrl + "/controlactivos/index/obtener-ubicacion-parametro",
                processData: true,
                dataType: 'json',
                data: {campo: 'ID_SUCURSAL', valor: valor},
                success: function (data) {
                    procesarAdminActivo.cargarSelectTipoUbi("selUbicacion", data,  "DESC_UBICACION", "DESC_UBICACION" );
                }
            });
        });

    },
    changeUbicacion:function () {
        $(document).on("change", "#selUbicacion", function () {
            var valor = $("#selUbicacion option:selected").val();
            $("#inpUbicacion").val(valor);
            $.ajax({
                type: "POST",
                url: baseUrl + "/controlactivos/index/obtener-ubicacion-parametro",
                processData: true,
                dataType: 'json',
                data: {campo: 'DESC_UBICACION', valor: valor},
                success: function (data) {
                    procesarAdminActivo.cargarSelectPiso("selPiso", data, "PISO_UBICACION", "PISO_UBICACION");
                }
            });
        });

    },
    changePiso:function () {
        $(document).on("change", "#selPiso", function () {
            var valor = $("#selPiso option:selected").val();
            $("#inpPiso").val(valor);
            $.ajax({
                type: "POST",
                url: baseUrl + "/controlactivos/index/obtener-ubicacion-parametro",
                processData: true,
                dataType: 'json',
                data: {campo: 'PISO_UBICACION', valor: valor},
                success: function (data) {
                    procesarAdminActivo.cargarSelectNomUbi("selNomUbi", data, "NOM_UBICACION", "NOM_UBICACION");
                }
            });
        });

    },
    changeNomUbi:function () {
        $(document).on("change", "#selNomUbi", function () {
            var valor = $("#selNomUbi option:selected").val();
            $("#inpNombreUbiacion").val(valor);
        });

    },
    cargaDatos:function () {
        $(document).ready( function () {
            $('#dt_proveedor').DataTable( {
                processing: false, // esto permite realizar busqueda conectado con el servidor
                serverSide: false, // esto permite realizar busqueda conectado con el servidor
                ajax: {
                    url: baseUrl + "/controlactivos/index/obtener-json-admin-activo",
                    dataSrc: 'data'
                },
                columns: [
                    { data: "COD_BARRA" },
                    { data: "NUM_SERIE" },
                    { data: "MARCA" },
                    { data: "MODELO" },
                    { data: "ESTADO_FISICO" },
                    { data: "SUCURSAL" },
                    { data: "TIPO_UBICACION" },
                    { data: "ESTATUS" },
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
    calendario:function () {
        $(document).ready( function () {
             $('.datepicker').datetimepicker({
                 format: 'DD/MM/YYYY'
             });
        } );

    },
    procesoGuardado: function () {
        var validaCampos = $(function () {//esto permite convertir todo el validate en una funcion
            $("#formAdminActivo").validate({
                event: "blur",
                rules: {
                    inpCategoria: {
                        required: true
                    },
                    inpTipoActivo: {
                        required: true
                    },
                    inpTipoAsignacion: {
                        required: true
                    },
                    inpEstadoFisico: {
                        required: true
                    },
                    inpMarca: {
                        required: true
                    },
                    inpModelo: {
                        required: true
                    },
                    inpCodBarra: {
                        required: true
                    },
                    inpNumSerie: {
                        required: true
                    },
                    inpProveedor: {
                        required: true
                    },
                    inpFechaCompra: {
                        required: true
                    },
                    inpNumFactura: {
                        required: true
                    },
                    inpSucursal: {
                        required: true
                    },
                    inpUbicacion: {
                        required: true
                    },
                    inpPiso: {
                        required: true
                    },
                    inpNombreUbiacion: {
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
                    inpTipoAsignacion: {
                        required: "Este campo es obligatorio.",
                    },
                    inpEstadoFisico: {
                        required: "Este campo es obligatorio.",
                    },
                    inpMarca: {
                        required: "Este campo es obligatorio.",
                    },
                    inpModelo: {
                        required: "Este campo es obligatorio.",
                    },
                    inpCodBarra: {
                        required: "Este campo es obligatorio.",
                    },
                    inpNumSerie: {
                        required: "Este campo es obligatorio.",
                    },
                    inpProveedor: {
                        required: "Este campo es obligatorio.",
                    },
                    inpFechaCompra: {
                        required: "Este campo es obligatorio.",
                    },
                    inpNumFactura: {
                        required: "Este campo es obligatorio.",
                    },
                    inpSucursal: {
                        required: "Este campo es obligatorio.",
                    },
                    inpUbicacion: {
                        required: "Este campo es obligatorio.",
                    },
                    inpPiso: {
                        required: "Este campo es obligatorio.",
                    },
                    inpNombreUbiacion: {
                        required: "Este campo es obligatorio.",
                    },
                    inpDes: {
                        required: "Este campo es obligatorio.",
                    },
                }
                , debug: true
                , errorElement: "label"
                , submitHandler: function (form) {
                    var datosForm = $("#formAdminActivo").serializeArray();
                    $.ajax({
                        type: "POST",
                        url: baseUrl + "/controlactivos/index/procesar-admin-activo",
                        processData: true,
                        data: datosForm,
                        success: function (data) {
                            procesarAdminActivo.metodoMensaje(data, 'btnRegistrar');
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

            var inpId = $(this).attr("data-id");
            var ID_ESTADO_FISICO = $(this).attr("data-ID_ESTADO_FISICO");
            var ID_TIPO_ACTIVO = $(this).attr("data-ID_TIPO_ACTIVO");
            var ID_TIPO_ASIGNACION = $(this).attr("data-ID_TIPO_ASIGNACION");
            var ID_PROVEEDOR = $(this).attr("data-ID_PROVEEDOR");
            var ID_SUCURSAL = $(this).attr("data-ID_SUCURSAL");
            var MARCA = $(this).attr("data-MARCA");
            var MODELO = $(this).attr("data-MODELO");
            var COD_BARRA = $(this).attr("data-COD_BARRA");
            var NUM_SERIE = $(this).attr("data-NUM_SERIE");
            var FECHA_COMPRA = $(this).attr("data-FECHA_COMPRA");
            var NUM_FACTURA = $(this).attr("data-NUM_FACTURA");
            var DESC_ACTIVO = $(this).attr("data-DESC_ACTIVO");
            var ID_TIPO_UBICACION = $(this).attr("data-ID_TIPO_UBICACION");
            var nomTipoUbicacion = $(this).attr("data-tipo_ubicacion");
            var nomPiso = $(this).attr("data-piso");
            var nomNomUbica = $(this).attr("data-nom_ubicacion");
            var ESTATUS = $(this).attr("data-ESTATUS");
            var FECHA_FORMATO = $(this).attr("data-FECHA_FORMATO");
            var CATEGORIA = $(this).attr("data-CATEGORIA");

            $("#inpId").val(inpId);

            $("#inpCategoria").val(CATEGORIA);
            $("#selCategoria").val(CATEGORIA);

            $("#inpTipoActivo").val(ID_TIPO_ACTIVO);
            $("#selTipoActivo").val(ID_TIPO_ACTIVO);

            $("#inpTipoAsignacion").val(ID_TIPO_ASIGNACION);
            $("#selTipoAsignacion").val(ID_TIPO_ASIGNACION);

            $("#inpEstadoFisico").val(ID_ESTADO_FISICO);
            $("#selEstadoFisico").val(ID_ESTADO_FISICO);


            $("#inpMarca").val(MARCA);
            $("#inpModelo").val(MODELO);
            $("#inpCodBarra").val(COD_BARRA);
            $("#inpNumSerie").val(NUM_SERIE);

            $("#inpProveedor").val(ID_PROVEEDOR);
            $("#selProveedor").val(ID_PROVEEDOR);

            $("#inpFechaCompra").val(FECHA_FORMATO);
            $("#inpNumFactura").val(NUM_FACTURA);

            $("#inpSucursal").val(ID_SUCURSAL);
            $("#selSucursal").val(ID_SUCURSAL);

            $("#inpUbicacion").val(nomTipoUbicacion);
            $( "#selUbicacion option:selected" ).text(nomTipoUbicacion);
            $( "#selUbicacion option:selected" ).val(nomTipoUbicacion);

            $("#inpPiso").val(nomPiso);
            $( "#selPiso option:selected" ).text(nomPiso);
            $( "#selPiso option:selected" ).val(nomPiso);

            $("#inpNombreUbiacion").val(ID_TIPO_UBICACION);
            $( "#selNomUbi option:selected" ).text(nomNomUbica);
            $( "#selNomUbi option:selected" ).val(ID_TIPO_UBICACION);

            $("#inpDes").val(DESC_ACTIVO);

            $("#bntTitulomodal").html("Editar activos");
            $("#inptProceso").val("Editar");
            $("#btnRegistrar").html("Editar");
            $("#btnRegistrar").removeClass("btn-success");
            $("#btnRegistrar").addClass("btn-primary");
            $("#form-bp1").removeClass("colored-header-success");
            $("#form-bp1").addClass("colored-header-primary");

            procesarAdminActivo.funtCerrarReload();


        });
    },
    validaDeshabilitar: function () {
        $(document).on("click", ".btnAccionDel", function () {
            var id = $(this).attr("data-id");
            procesarAdminActivo.modalMensaje('Confirmación', '¿ Está seguro de deshabilitar ?', id, 'btnAccionDel');

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
    procesoUpload: function () {
        $(document).on("click", "#btnCargarMasiva", function () {
            var formData = new FormData();
            formData.append('file_csv', $('#file_csv')[0].files[0]);
            var url = baseUrl + "/controlactivos/index/procesar-upload-csv";
            $.ajax({
                url: url,
                type: 'POST',
                data: formData, //el data es tu objeto formData
                processData: false, //indicas a jQuery que no procese la información
                contentType: false //indicas a jQuery que no configure el contentType del request
            }).done(function(data) {
                data = $.parseJSON(data);

                if ( data.valida == 'false' ) {
                    var str = procesarAdminActivo.EstruturaMesajeAdvertencia;
                    var respHtml = str.replace("i_mensaje", procesarAdminActivo.mensajeAdvertencia02);
                    $("#msjRespuestaCarga").html(respHtml);
                }

                if ( data.valida == 'true' ) {
                    var str = procesarAdminActivo.EstruturaMesajeExito;
                    var respHtml = str.replace("i_mensaje", procesarAdminActivo.mensajeExito02);
                    $("#msjRespuestaCarga").html(respHtml);
                    $("#btnCargarMasivaProcesar").removeAttr('disabled', 'disabled');
                    $("#inpUrl").val(data.url);
                    $("#inpNombreArchivo").val(data.nom);
                }

            }).fail(function() {
                console.log("error");
            })

        });
    },
    procesoCargaMasiva: function () {
        $(document).on("click", "#btnCargarMasivaProcesar", function () {

            var nomArchivo = $("#inpNombreArchivo").val();
            $.ajax({
                type: "POST",
                url: baseUrl + "/controlactivos/index/procesar-csv",
                processData: true,
                dataType: 'json',
                data: {inpNombreArchivo: nomArchivo},
                success: function (data) {
                    if ( data.valida == 'false' ) {
                        var str = procesarAdminActivo.EstruturaMesajeAdvertencia;
                        var respHtml = str.replace("i_mensaje", data.msg);
                        $("#msjRespuestaCarga").html(respHtml);
                    }

                    if ( data.valida == 'true' ) {
                        var str = procesarAdminActivo.EstruturaMesajeExito;
                        var respHtml = str.replace("i_mensaje", procesarAdminActivo.mensajeExito02);
                        $("#msjRespuestaCarga").html(respHtml);
                        $("#btnCargarMasivaProcesar").attr('disabled', 'disabled');
                    }
                }, error: function (e) {
                    console.log("Error");
                }

            });

        });
    },
    metodoMensaje: function (data, bonton) {
        var result = JSON.parse(data);
        if (result['valida'] == 1) {
            var str = procesarAdminActivo.EstruturaMesajeExito;
            var respHtml = str.replace("i_mensaje", procesarAdminActivo.mensajeExito01);
            $("#msjRespuesta").html(respHtml);
            $("#" + bonton).attr('disabled', 'disable');
        }
        if (result['valida'] == 0) {
            var str = procesarAdminActivo.EstruturaMesajePeligro ;
            var respHtml = str.replace("i_mensaje", procesoRemesas.mensajePeligro01);
            $("#msjRespuesta").html(respHtml);
        }
        //procesoRemesas.funtCerrarReload();
    },
    validaTeclado: function () {
        var validaCamposTeclado = $(function () {
            $(".soloLetrasNum").keypress(function (e) {
                procesarAdminActivo.metodoTeclado(e, "soloLetrasNum", this);
            });

            $(".soloFecha").keypress(function (e) {
                procesarAdminActivo.metodoTeclado(e, "soloFecha", this);
            });

        });

    },
    metodoTeclado: function (e, permitidos, fieldObj, upperCase) {

        if (fieldObj.readOnly) return false;
        upperCase = typeof(upperCase) != 'undefined' ? upperCase : true;
        e = e || event;

        charCode = e.keyCode; // || e.keyCode;

        if ((procesarAdminActivo.is_nonChar(charCode)) && e.shiftKey == 0)
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
                    procesarAdminActivo.procesoDeshabilitar(valor);
                    dialog.close();
                    procesarAdminActivo.funtCerrarReload();
                }
            }]
        });

    },
    funtCerrarReload: function () {
        $(document).on("click", "#btnCerrar", function () {
            window.location.reload(true);
        });

    },
    cargarSelectTipoUbi: function (nomSelect, array, optionText, optionval) {
        console.log(nomSelect);
        // Ordena el Array Alfabeticamente, es muy facil ;)):
        // array.sort();
        var select = document.getElementsByName(nomSelect)[0];
        for(var i=0;i<array.length;i++){
            var option = document.createElement("option");
            option.text = array[i].DESC_UBICACION;
            option.value = array[i].DESC_UBICACION;
            select.add(option);
        }
    },
    cargarSelectPiso: function (nomSelect, array, optionText, optionval) {
        console.log(nomSelect);
        // Ordena el Array Alfabeticamente, es muy facil ;)):
        // array.sort();
        var select = document.getElementsByName(nomSelect)[0];
        for(var i=0;i<array.length;i++){
            var option = document.createElement("option");
            option.text = array[i].PISO_UBICACION;
            option.value = array[i].PISO_UBICACION;
            select.add(option);
        }
    },
    cargarSelectNomUbi: function (nomSelect, array, optionText, optionval) {
        console.log(nomSelect);
        // Ordena el Array Alfabeticamente, es muy facil ;)):
        // array.sort();
        var select = document.getElementsByName(nomSelect)[0];
        for(var i=0;i<array.length;i++){
            var option = document.createElement("option");
            option.text = array[i].NOM_UBICACION;
            option.value = array[i].ID_UBICACION;
            select.add(option);
        }
    },

};
procesarAdminActivo.init();