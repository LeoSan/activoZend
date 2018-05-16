var procesoProveedor = {
    //Declaracion Variables
    pathServidor: 'http://10.73.98.127/',
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
        procesoProveedor.cargaDatos();
        procesoProveedor.changeEstadoPais();
        procesoProveedor.validaTeclado();
        procesoProveedor.procesoGuardado();
        procesoProveedor.procesoMuestra();
        procesoProveedor.validaDeshabilitar();
    },// fin init
    changeEstadoPais:function () {
        $(document).on("change", "#selEstado", function () {
            var valor = $("#selEstado option:selected").val();
            console.log(valor);
            $("#selEstado2").val(valor);
        });

    },
    cargaDatos:function () {

        $(document).ready( function () {
            $('#dt_proveedor').DataTable( {
                processing: false, // esto permite realizar busqueda conectado con el servidor
                serverSide: false, // esto permite realizar busqueda conectado con el servidor
                ajax: {
                    url: baseUrl + "/controlactivos/index/obtener-json-proveedor",
                    dataSrc: 'data'
                },
                columns: [
                    { data: "ID_PROVEEDOR" },
                    { data: "NOM_PROVEEDOR" },
                    { data: "DES_PROVEEDOR" },
                    { data: "ESTATUS" },
                    { data: "UBICACION" },
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
            $("#formProveedor").validate({
                event: "blur",
                rules: {
                    inpNombre: {
                        required: true
                    },
                    inpDes: {
                        required: true
                    },
                    selEstado2: {
                        required: true
                    },
                },
                messages: {
                    inpNombre: {
                        required: "Este campo es obligatorio.",
                    },
                    inpDes: {
                        required: "Este campo es obligatorio.",
                    },
                    selEstado2: {
                        required: "Este campo es obligatorio.",
                    },
                }
                , debug: true
                , errorElement: "label"
                , submitHandler: function (form) {
                    var datosForm = $("#formProveedor").serializeArray();
                    $.ajax({
                        type: "POST",
                        url: baseUrl + "/controlactivos/index/procesar-proveedor",
                        processData: true,
                        data: datosForm,
                        success: function (data) {
                            procesoProveedor.metodoMensaje(data, 'btnRegistrar');
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
            var inpNombre = $(this).attr("data-NOM_PROVEEDOR");
            var inpDes = $(this).attr("data-DES_PROVEEDOR");
            var selEstado = $(this).attr("data-UBICACION");

            $("#inpId").val(inpId);
            $("#inpNombre").val(inpNombre);
            $("#inpDes").val(inpDes);
            $("#selEstado2").val(selEstado);
            $("#selEstado").val(selEstado);

            $("#bntTitulomodal").html("Editar Proveedor");
            $("#inptProceso").val("Editar");
            $("#btnRegistrar").html("Editar");
            $("#btnRegistrar").removeClass("btn-success");
            $("#btnRegistrar").addClass("btn-primary");
            $("#form-bp1").removeClass("colored-header-success");
            $("#form-bp1").addClass("colored-header-primary");

            procesoProveedor.funtCerrarReload();


        });
    },
    validaDeshabilitar: function () {
        $(document).on("click", ".btnAccionDel", function () {
            var id = $(this).attr("data-id");
            procesoProveedor.modalMensaje('Confirmación', '¿ Está seguro de deshabilitar ?', id, 'btnAccionDel');

        });
    },
    procesoDeshabilitar: function (valor) {
        $.ajax({
            type: "POST",
            url: baseUrl + "/controlactivos/index/procesar-proveedor",
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
            var str = procesoProveedor.EstruturaMesajeExito;
            var respHtml = str.replace("i_mensaje", procesoProveedor.mensajeExito01);
            $("#msjRespuesta").html(respHtml);
            $("#" + bonton).attr('disabled', 'disable');
        }
        if (result['valida'] == 0) {
            var str = procesoProveedor.EstruturaMesajePeligro ;
            var respHtml = str.replace("i_mensaje", procesoRemesas.mensajePeligro01);
            $("#msjRespuesta").html(respHtml);
        }
        //procesoRemesas.funtCerrarReload();
    },
    validaTeclado: function () {
        var validaCamposTeclado = $(function () {
            $(".soloLetrasNum").keypress(function (e) {
                procesoProveedor.metodoTeclado(e, "soloLetrasNum", this);
            });
        });

    },
    metodoTeclado: function (e, permitidos, fieldObj, upperCase) {

        if (fieldObj.readOnly) return false;
        upperCase = typeof(upperCase) != 'undefined' ? upperCase : true;
        e = e || event;

        charCode = e.keyCode; // || e.keyCode;

        if ((procesoProveedor.is_nonChar(charCode)) && e.shiftKey == 0)
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
                    procesoProveedor.procesoDeshabilitar(valor);
                    dialog.close();
                    procesoProveedor.funtCerrarReload();
                }
            }]
        });

    },
    funtCerrarReload: function () {
        $(document).on("click", "#btnCerrar", function () {
            window.location.reload(true);
        });

    },
};
procesoProveedor.init();