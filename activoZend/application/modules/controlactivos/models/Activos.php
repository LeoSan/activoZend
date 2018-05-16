<?php

class Controlactivos_Model_Activos
{

//Get  ***** Métodos de Obtener

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company PENDULUN  C.V
     * @description Permite conectar con la BD y obtener todos los proveedores
     * @access public
     *
     */
    public function getAllUsuarios($typeResponses, $datos)
    {
        $query = "BEGIN PENDUPM.PCKACTIVOS.getUSUARIOS('%" . strtoupper($datos['term']) . "%', :RESDATA); END;";
        $oracleFactory = Pendum_Db_DbFactory::factory('oracle');
        $result = $oracleFactory->getAll($query);
        if($typeResponses==1){
            return $result;
        }else{
            return json_encode($result);
        }
        return $result;
    }

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company PENDULUN  C.V
     * @description Permite conectar con la BD y obtener todos los proveedores
     * @access public
     *
     */
    public function parseoJsonProveedor($type = 0){
        $query = "BEGIN PENDUPM.PCK_CONTROL_ACTIVOS.obtenerProveedor(:RESDATA); END;";
        $oracleFactory = Pendum_Db_DbFactory::factory('oracle');
        $result['data'] = $oracleFactory->getAll($query);

        if ($type == 0){
            foreach ($result['data'] as $key => $filas){
                $generaData = " data-NOM_PROVEEDOR = '".$filas['NOM_PROVEEDOR']."'";
                $generaData .= "  data-DES_PROVEEDOR = '".$filas['DES_PROVEEDOR']."'";
                $generaData .= "  data-ESTATUS = '".$filas['ESTATUS']."'";
                $generaData .= "  data-UBICACION = '".$filas['UBICACION']."'";
                $result['data'][$key]['ACCION']  = ($this->metodoGeneraBoton($filas['ID_PROVEEDOR'], $generaData, $filas['ESTATUS']));
            }
            return json_encode($result);
        }else{
            return $result;
        }

    }

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company PENDULUN  C.V
     * @description Permite conectar con la BD y obtener todos los proveedores
     * @access public
     *
     */
    public function parseoJsonSucursal()
    {
        $query = "BEGIN PENDUPM.PCK_CONTROL_ACTIVOS.obtenerSucursal(:RESDATA); END;";
        $oracleFactory = Pendum_Db_DbFactory::factory('oracle');
        $result['data'] = $oracleFactory->getAll($query);
        return $result;

    }

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company PENDULUN  C.V
     * @description Permite conectar con la BD y obtener todos los estado fisicos de un activo
     * @access public
     *
     */
    public function parseoJsonCatalogo($param, $type = 0)
    {
        $query = "BEGIN PENDUPM.PCK_CONTROL_ACTIVOS.obtenerCategoria('".$param['tipoCatalogo']."', :RESDATA); END;";
        $oracleFactory = Pendum_Db_DbFactory::factory('oracle');
        $result['data'] = $oracleFactory->getAll($query);

        foreach ($result['data'] as $key => $filas){
            $generaData = " data-NOM_CATEGORIA = '".$filas['NOM_CATEGORIA']."'";
            $generaData .= "  data-DESC_CATEGORIA = '".$filas['DESC_CATEGORIA']."'";
            $generaData .= "  data-ESTATUS = '".$filas['ESTATUS']."'";
            $result['data'][$key]['ACCION']  = ($this->metodoGeneraBoton($filas['ID_CACT_CATEGORIA'], $generaData, $filas['ESTATUS']));
        }
        if ($type == 0 ){
            return json_encode($result);
        }else{
            return $result['data'];
        }

    }

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company PENDULUN  C.V
     * @description Permite conectar con la BD y obtener todos los proveedores
     * @access public
     *
     */
    public function parseoJsonUbicacion()
    {
        $query = "BEGIN PENDUPM.PCK_CONTROL_ACTIVOS.obtenerUbicacion(:RESDATA); END;";
        $oracleFactory = Pendum_Db_DbFactory::factory('oracle');
        $result['data'] = $oracleFactory->getAll($query);

        foreach ($result['data'] as $key => $filas){
            $generaData = " data-NOM_UBICACION = '".$filas['NOM_UBICACION']."'";
            $generaData .= "  data-DESC_UBICACION = '".$filas['DESC_UBICACION']."'";
            $generaData .= "  data-PISO_UBICACION = '".$filas['PISO_UBICACION']."'";
            $generaData .= "  data-ID_SUCURSAL = '".$filas['ID_SUCURSAL']."'";
            $result['data'][$key]['ACCION']  = ($this->metodoGeneraBoton($filas['ID_UBICACION'], $generaData, $filas['ESTATUS']));
        }
        return json_encode($result);
    }

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company PENDULUN  C.V
     * @description Permite conectar con la BD y obtener los tipos de ubicacion
     * @access public
     *
     */
    public function obtenerParametrosUbicacion($params){
        $query = "BEGIN PENDUPM.PCK_CONTROL_ACTIVOS.obtenerUbicacionParametros( '".$params['campo']."', '".$params['valor']."',   :RESDATA); END;";
        $oracleFactory = Pendum_Db_DbFactory::factory('oracle');
        $result = $oracleFactory->getAll($query);
        return json_encode($result);
    }

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company PENDULUN  C.V
     * @description Permite conectar con la BD y obtener los tipos de ubicacion
     * @access public
     *
     */
    public function obtenerListaActivo($params){
        $query = "BEGIN PENDUPM.PCK_CONTROL_ACTIVOS.obtenerListaActivo( '".$params['ID_CATEGORIA']."', '".$params['REFERENCIA']."', :RESDATA); END;";
        $oracleFactory = Pendum_Db_DbFactory::factory('oracle');
        $result = $oracleFactory->getAll($query);
        $arrays = array();
        $arrays[0] = array("ID_CACT_CATEGORIA"=> 0,"NOM_CATEGORIA"=> "[Seleccione ]");
        foreach ($result as $key=>$filas){
            $arrays[$key+1] = array("ID_CACT_CATEGORIA"=> $filas['ID_CACT_CATEGORIA'],"NOM_CATEGORIA"=> $filas['NOM_CATEGORIA']);
        }
        return json_encode($arrays);
    }

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company PENDULUN  C.V
     * @description Permite conectar con la BD y obtener todos los proveedores
     * @access public
     *
     */
    public function parseoJsonAdminActivo()
    {
        $query = "BEGIN PENDUPM.PCK_CONTROL_ACTIVOS.obtenerActivo(:RESDATA); END;";
        $oracleFactory = Pendum_Db_DbFactory::factory('oracle');
        $result['data'] = $oracleFactory->getAll($query);

        foreach ($result['data'] as $key => $filas){
            $generaData = " data-ID_ACTIVO = '".$filas['ID_ACTIVO']."'";
            $generaData .= "  data-ID_ESTADO_FISICO = '".$filas['ID_ESTADO_FISICO']."'";
            $generaData .= "  data-ID_TIPO_ACTIVO = '".$filas['ID_TIPO_ACTIVO']."'";
            $generaData .= "  data-ID_TIPO_ASIGNACION = '".$filas['ID_TIPO_ASIGNACION']."'";
            $generaData .= "  data-ID_PROVEEDOR = '".$filas['ID_PROVEEDOR']."'";
            $generaData .= "  data-ID_SUCURSAL = '".$filas['ID_SUCURSAL']."'";
            $generaData .= "  data-ID_TIPO_UBICACION = '".$filas['ID_TIPO_UBICACION']."'";
            $generaData .= "  data-MARCA = '".$filas['MARCA']."'";
            $generaData .= "  data-MODELO = '".$filas['MODELO']."'";
            $generaData .= "  data-COD_BARRA = '".$filas['COD_BARRA']."'";
            $generaData .= "  data-NUM_SERIE = '".$filas['NUM_SERIE']."'";
            $generaData .= "  data-FECHA_COMPRA = '".$filas['FECHA_COMPRA']."'";
            $generaData .= "  data-NUM_FACTURA = '".$filas['NUM_FACTURA']."'";
            $generaData .= "  data-DESC_ACTIVO = '".$filas['DESC_ACTIVO']."'";
            $generaData .= "  data-ESTATUS = '".$filas['ESTATUS']."'";
            $generaData .= "  data-TIPO_ACTIVO = '".$filas['TIPO_ACTIVO']."'";
            $generaData .= "  data-TIPO_ASIGNACION = '".$filas['TIPO_ASIGNACION']."'";
            $generaData .= "  data-ESTADO_FISICO = '".$filas['ESTADO_FISICO']."'";
            $generaData .= "  data-PROVEEDOR = '".$filas['PROVEEDOR']."'";
            $generaData .= "  data-SUCURSAL = '".$filas['SUCURSAL']."'";
            $generaData .= "  data-TIPO_UBICACION = '".$filas['TIPO_UBICACION']."'";
            $generaData .= "  data-PISO = '".$filas['PISO']."'";
            $generaData .= "  data-NOM_UBICACION = '".$filas['NOM_UBICACION']."'";
            $generaData .= "  data-FECHA_FORMATO = '".$filas['FECHA_FORMATO']."'";
            $generaData .= "  data-CATEGORIA = '".$filas['ID_CATEGORIA']."'";
            $result['data'][$key]['ACCION']  = ($this->metodoGeneraBoton($filas['ID_ACTIVO'], $generaData, $filas['ESTATUS']));
        }
        return json_encode($result);
    }

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company PENDULUN  C.V
     * @description Permite conectar con la BD y obtener todos los proveedores
     * @access public
     *
     */
    public function parseoJsonSolicitud($params)
    {
        $query = "BEGIN PENDUPM.PCK_CONTROL_ACTIVOS.obtenerSolicitud('".$params['idSolicitud']."', ".$params['admin'].", ".$params['idEstatus'].",  :RESDATA); END;";
        $oracleFactory = Pendum_Db_DbFactory::factory('oracle');
        $result['data'] = $oracleFactory->getAll($query);

        foreach ($result['data'] as $key => $filas){
            $generaData = " data-ID_TRACKING = '".$filas['ID_TRACKING']."'";
            $generaData .= "  data-ID_ACTIVO = '".$filas['ID_ACTIVO']."'";
            $generaData .= "  data-ID_SOLICITANTE = '".$filas['ID_SOLICITANTE']."'";
            $generaData .= "  data-ID_ESTATUS = '".$filas['ID_ESTATUS']."'";
            $generaData .= "  data-ID_MOTIVO = '".$filas['ID_MOTIVO']."'";
            $generaData .= "  data-CANTIDAD = '".$filas['CANTIDAD']."'";
            $generaData .= "  data-FECHA_FORMATO = '".$filas['FECHA_FORMATO']."'";
            $generaData .= "  data-MOTIVO_SOLICITUD = '".$filas['MOTIVO_SOLICITUD']."'";
            $generaData .= "  data-TIPO_ACTIVO = '".$filas['TIPO_ACTIVO']."'";
            $generaData .= "  data-NOM_ESTATUS = '".$filas['NOM_ESTATUS']."'";
            $generaData .= "  data-NOM_SOLICITANTE = '".$filas['NOM_SOLICITANTE']."'";
            $result['data'][$key]['ACCION']  = ($this->metodoGeneraBotonSolicitud($filas['ID_TRACKING'], $generaData, $filas['ID_ESTATUS']));
        }
        return json_encode($result);
    }

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company PENDULUN  C.V
     * @description Permite conectar con la BD y obtener todos los proveedores
     * @access public
     *
     */
    public function parseoJsonSolicitudAdmin($params){
        $query = "BEGIN PENDUPM.PCK_CONTROL_ACTIVOS.obtenerSolicitud('".$params['idSolicitud']."', ".$params['admin'].", ".$params['idEstatus'].", :RESDATA); END;";
        $oracleFactory = Pendum_Db_DbFactory::factory('oracle');
        $result['data'] = $oracleFactory->getAll($query);

        foreach ($result['data'] as $key => $filas){
            $generaData = " data-ID_TRACKING = '".$filas['ID_TRACKING']."'";
            $generaData .= "  data-ID_ACTIVO = '".$filas['ID_ACTIVO']."'";
            $generaData .= "  data-ID_SOLICITANTE = '".$filas['ID_SOLICITANTE']."'";
            $generaData .= "  data-ID_ESTATUS = '".$filas['ID_ESTATUS']."'";
            $generaData .= "  data-ID_MOTIVO = '".$filas['ID_MOTIVO']."'";
            $generaData .= "  data-CANTIDAD = '".$filas['CANTIDAD']."'";
            $generaData .= "  data-FECHA_FORMATO = '".$filas['FECHA_FORMATO']."'";
            $generaData .= "  data-MOTIVO_SOLICITUD = '".$filas['MOTIVO_SOLICITUD']."'";
            $generaData .= "  data-TIPO_ACTIVO = '".$filas['TIPO_ACTIVO']."'";
            $generaData .= "  data-NOM_ESTATUS = '".$filas['NOM_ESTATUS']."'";
            $generaData .= "  data-NOM_SOLICITANTE = '".$filas['NOM_SOLICITANTE']."'";
            $result['data'][$key]['ACCION']  = ($this->metodoGeneraBotonSolicitud($filas['ID_TRACKING'], $generaData, $filas['ID_ESTATUS']));
        }
        return json_encode($result);
    }

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company PENDULUN  C.V
     * @description Permite conectar con la BD y obtener todos los proveedores
     * @access public
     *
     */
    public function obtenerBitacora($params)
    {
        $query = "BEGIN PENDUPM.PCK_CONTROL_ACTIVOS.obtenerBitacora(".$params['idTracking'].", :RESDATA); END;";
        $oracleFactory = Pendum_Db_DbFactory::factory('oracle');
        $result['data'] = $oracleFactory->getAll($query);
        return $this->formarCeldas($result['data'], $params);
    }

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company PENDULUN  C.V
     * @description Permite conectar con la BD y obtener todos los proveedores
     * @access public
     *
     */
    public function obtenerEstatus($params)
    {
        $query = "BEGIN PENDUPM.PCK_CONTROL_ACTIVOS.obtenerCatalogoEstatusSistema('".$params['referencia']."',".$params['valida'].",'".$params['estatus']."', :RESDATA); END;";
        $oracleFactory = Pendum_Db_DbFactory::factory('oracle');
        $result['data'] = $oracleFactory->getAll($query);
        return $result['data'];
    }

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company Neta System C.A
     * @description Permite conectar con la BD y obtener todos los proveedores
     * @access public
     *
     */
    public function parseoJsonIdioma(){
          $result['sProcessing'] = "Procesando...";
          $result['sLengthMenu'] = "Mostrar _MENU_ registros";
          $result['sZeroRecords'] = "No se encontraron resultados";
          $result['sEmptyTable'] = "Ningún dato disponible en esta tabla";
          $result['sInfo'] = "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros";
          $result['sInfoEmpty'] = "Mostrando registros del 0 al 0 de un total de 0 registros";
          $result['sInfoFiltered'] = "(filtrado de un total de _MAX_ registros)";
          $result['sInfoPostFix'] = "";
          $result['sSearch'] = "Buscar:";
          $result['sUrl'] = "";
          $result['sInfoThousands'] = ",";
          $result['sLoadingRecords'] = "Cargando...";

          $result['oPaginate'] = array(
            array('sFirst' => 'Primero', 'sLast'=> 'Ultimo', 'sNext'=> 'Siguiente','sPrevious'=> 'Anterior'),

            );

        $result['oAria'] = array(
            array('sSortAscending' => 'Activar para ordenar la columna de manera ascendente', 'sSortDescending'=> 'UltiActivar para ordenar la columna de manera descendentemo'),

        );



        return json_encode($result);
    }















//Insert - Edit - Deshabilitar ***** Métodos Registrar

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company PENDULUN  C.V
     * @description Permite insertar los valores en la tabla ->ACTPROVEEDOR
     * @access public
     *
     */
    public function procesarProveedor($params){

        if ($params['inptProceso'] == 'Guardar') {
            $query  = "BEGIN PENDUPM.PCK_CONTROL_ACTIVOS.insertProveedor('".strtoupper($params['inpNombre'])."', '".strtoupper($params['inpDes'])."', ".strtoupper($params['selEstado']).", :psError);END;";
        } else if($params['inptProceso'] == 'Editar') {
            $query = "BEGIN PENDUPM.PCK_CONTROL_ACTIVOS.editProveedor(" . strtoupper($params['inpId']) . ", '" . strtoupper($params['inpNombre']) . "', '" . strtoupper($params['inpDes']) . "', " . strtoupper($params['selEstado']) . ", :psError);END;";
        }else{
            $query = "BEGIN PENDUPM.PCK_CONTROL_ACTIVOS.deshabilitarProveedor(" . strtoupper($params['inpId']) . ", :psError);END;";
        }
        $oracleFactory = Pendum_Db_DbFactory::factory('oracle');
        $typeResponses = $oracleFactory->set($query);
        return $this->metodoResultado($typeResponses);

    }

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company PENDULUN  C.V
     * @description Permite procesar los datos de los diferentes catalgos
     * @access public
     *
     */
    public function procesarCatalogo($params){

        if ($params['inptProceso'] == 'Guardar') {
            $query  = "BEGIN PENDUPM.PCK_CONTROL_ACTIVOS.insertCatalogo('".strtoupper($params['inpNombre'])."', '".strtoupper($params['inpDes'])."', '".strtoupper($params['inpTipoCatalogo'])."', :psError);END;";
        } else if($params['inptProceso'] == 'Editar') {
            $query = "BEGIN PENDUPM.PCK_CONTROL_ACTIVOS.editCatalogo(" . strtoupper($params['inpId']) . ", '" . strtoupper($params['inpNombre']) . "', '" . strtoupper($params['inpDes']) . "',  :psError);END;";
        }else{
            $query = "BEGIN PENDUPM.PCK_CONTROL_ACTIVOS.deshabilitarCatalogo(" . strtoupper($params['inpId']) . ", :psError);END;";
        }
        $oracleFactory = Pendum_Db_DbFactory::factory('oracle');
        $typeResponses = $oracleFactory->set($query);
        return $this->metodoResultado($typeResponses);

    }

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company PENDULUN  C.V
     * @description Permite insertar los valores en la tabla ->ACTPROVEEDOR
     * @access public
     *
     */
    public function procesarUbicacion($params){

       if ($params['inptProceso'] == 'Guardar') {
            $query  = "BEGIN PENDUPM.PCK_CONTROL_ACTIVOS.insertUbicacion('".strtoupper($params['inpNombre'])."', '".strtoupper($params['inpDes'])."', '".strtoupper($params['inpPiso2'])."', ".strtoupper($params['inpSucursal2']).", :psError);END;";
        } else if($params['inptProceso'] == 'Editar') {
            $query = "BEGIN PENDUPM.PCK_CONTROL_ACTIVOS.editUbicacion(" . strtoupper($params['inpId']) . ", '" . strtoupper($params['inpNombre']) . "', '" . strtoupper($params['inpDes']) . "', '".strtoupper($params['inpPiso2'])."', ".strtoupper($params['inpSucursal2']).", :psError);END;";
        }else{
            $query = "BEGIN PENDUPM.PCK_CONTROL_ACTIVOS.deshabilitarUbicacion(" . strtoupper($params['inpId']) . ", :psError);END;";
        }
        $oracleFactory = Pendum_Db_DbFactory::factory('oracle');
        $typeResponses = $oracleFactory->set($query);
        return $this->metodoResultado($typeResponses);

    }

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company PENDULUN  C.V
     * @description Permite insertar los valores en la tabla ->ACTPROVEEDOR
     * @access public
     *
     */
    public function procesarAdminActivo($params){
        if ($params['inptProceso'] == 'Guardar') {
            // inpCategoria INTEGER, ID_TIPO_ACTIVO INTEGER,  ID_ESTADO_FISICO INTEGER, ID_TIPO_ASIGNACION INTEGER, ID_PROVEEDOR INTEGER, ID_SUCURSAL INTEGER, ID_TIPO_UBICACION INTEGER, MARCA VARCHAR2, MODELO VARCHAR2, COD_BARRA VARCHAR2, NUM_SERIE VARCHAR2, FECHA_COMPRA DATE, NUM_FACTURA VARCHAR2, DESC_ACTIVO VARCHAR2
            $query  = "BEGIN PENDUPM.PCK_CONTROL_ACTIVOS.insertActivo(".strtoupper($params['inpCategoria']).",".strtoupper($params['inpTipoActivo']).",".strtoupper($params['inpEstadoFisico']).",".strtoupper($params['inpTipoAsignacion']).",".strtoupper($params['inpProveedor']).",".strtoupper($params['inpSucursal']).",".strtoupper($params['inpNombreUbiacion']).",  '".strtoupper($params['inpMarca'])."', '".strtoupper($params['inpModelo'])."', '".strtoupper($params['inpCodBarra'])."', '".strtoupper($params['inpNumSerie'])."', '".strtoupper($params['inpFechaCompra'])."', '".strtoupper($params['inpNumFactura'])."','".strtoupper($params['inpDes'])."',  :psError);END;";
        } else if($params['inptProceso'] == 'Editar') {
            $query = "BEGIN PENDUPM.PCK_CONTROL_ACTIVOS.editActivo(".strtoupper($params['inpId']).",".strtoupper($params['inpCategoria']).",".strtoupper($params['inpTipoActivo']).",".strtoupper($params['inpEstadoFisico']).",".strtoupper($params['inpTipoAsignacion']).",".strtoupper($params['inpProveedor']).",".strtoupper($params['inpSucursal']).",".strtoupper($params['inpNombreUbiacion']).",  '".strtoupper($params['inpMarca'])."', '".strtoupper($params['inpModelo'])."', '".strtoupper($params['inpCodBarra'])."', '".strtoupper($params['inpNumSerie'])."', '".strtoupper($params['inpFechaCompra'])."', '".strtoupper($params['inpNumFactura'])."','".strtoupper($params['inpDes'])."', :psError);END;";
        }else{
            $query = "BEGIN PENDUPM.PCK_CONTROL_ACTIVOS.deshabilitarActivo(" . strtoupper($params['inpId']) . ", :psError);END;";
        }
    //    echo $query; exit;
        $oracleFactory = Pendum_Db_DbFactory::factory('oracle');
        $typeResponses = $oracleFactory->set($query);
        return $this->metodoResultado($typeResponses);

    }

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company PENDULUN  C.V
     * @description Permite insertar los valores en la tabla ->ACTPROVEEDOR
     * @access public
     *
     */
    public function procesarCargaAdminActivo($query){
        $oracleFactory = Pendum_Db_DbFactory::factory('oracle');
        $typeResponses = $oracleFactory->set($query);
        return $this->metodoResultado($typeResponses);
    }
    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company PENDULUN  C.V
     * @description Permite insertar los valores en la tabla ->ACTPROVEEDOR
     * @access public
     *
     */
    public function procesarSolicitud($params){

        if ($params['inptProceso'] == 'Guardar') {
            $query  = "BEGIN PENDUPM.PCK_CONTROL_ACTIVOS.insertSolicitud(".strtoupper($params['inpCategoria']).", ".strtoupper($params['inpTipoActivo']).",".strtoupper($params['inpSolicitante']).",".strtoupper($params['inpMotivo']).",".strtoupper($params['inpCantidad']).", '".strtoupper($params['inpDes'])."', :psError);END;";
        } else if($params['inptProceso'] == 'Editar') {
            //ID_TRA_DETALLE, ID_TRACKING, ID_USUARIO, COMENTARIO, FECHA, ID_ESTATUS
            $query = "BEGIN PENDUPM.PCK_CONTROL_ACTIVOS.insertSolicitudBitacora(" . strtoupper($params['inpIdTracking']) . ", " . strtoupper($params['inpSolicitante']) . ", '" . strtoupper($params['inpDes']) . "', ".strtoupper($params['inpEstatus']).", :psError);END;";
        }else{
            $query = "BEGIN PENDUPM.PCK_CONTROL_ACTIVOS.deshabilitarUbicacion(" . strtoupper($params['inpId']) . ", :psError);END;";
        }
        $oracleFactory = Pendum_Db_DbFactory::factory('oracle');
        $typeResponses = $oracleFactory->set($query);
        return $this->metodoResultado($typeResponses);
    }











//Metodos  - Metodos del Modelo para facilitar operaciones

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company Neta System C.A
     * @description Permite generar una respuesta para Json
     * @access public
     *
     */
    public function metodoResultado($typeResponses){
        if($typeResponses==1){
            $result['valida'] = 1;
        }else{
            $result['valida'] = 0;
        }
        return json_encode($result);
    }

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company PENDULUN  C.V
     * @description Permite generar botones para el apoyo de la vista
     * @access public
     *
     */
    public function metodoGeneraBoton($id, $generaData, $status){

        if ($status != 'DELETE'){
            $string  = "<span class='glyphicon glyphicon-pencil btnAccionEdit' data-id='".$id."' title='Editar este registro' data-toggle='modal' data-target='#form-bp1' ".$generaData." ></span>";
            $string .= "<span class='glyphicon glyphicon-remove btnAccionDel'  data-id='".$id."' title='Deshabilitar este registro' ></span>";
        }else{
            $string = "<span class='glyphicon glyphicon-eye-close'  data-id='".$id."' title='Registro deshabilitado'></span>";
        }
        return $string;
    }

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company PENDULUN  C.V
     * @description Permite generar botones para el apoyo de la vista
     * @access public
     *
     */
    public function metodoGeneraBotonSolicitud($id, $generaData, $status){
        $string = '';
//        if ($status == 6 || $status == 2  ){
//            $string .= "<span class='glyphicon glyphicon-eye-open btnAccionBitacora' data-id='".$id."' title='Ver Historico de la solicitud' data-toggle='modal' data-target='#modalBitacora' ></span>";
//        }else if ($status == 1 || $status == 4  ) {
            $string .= "<span class='glyphicon glyphicon-pencil btnAccionEdit'  data-id='".$id."' title='Editar este registro' data-toggle='modal' data-target='#form-bp2' ".$generaData." ></span>";
            $string .= "<span class='glyphicon glyphicon-eye-open btnAccionBitacora' data-id='".$id."' title='Ver Historico de la solicitud' data-toggle='modal' data-target='#modalBitacora' ></span>";
//        }
        return $string;
    }

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company PENDULUN  C.V
     * @description Permite generar botones para el apoyo de la vista
     * @access public
     *
     */
    public function formarCeldas($arrays, $params){
        $string = '';
        foreach ($arrays as $filas){

            if ($filas['NOM_ESTATUS'] == 'RECHAZADA POR ADMIN' || $filas['NOM_ESTATUS'] == 'RECHAZADA POR  USUARIO' ){  $nomEstuloText = 'text-danger'; }else{ $nomEstuloText = 'text-success';}
            if ($filas['SEXO'] == 'M' ){  $nomAvatar = 'avatar4.png'; }else{ $nomAvatar = 'avatar6.png';}
            $string .= "<tr>
                            <td class='text-center user-avatar'><img src='".$params['url']."/images/assets/img/".$nomAvatar."' alt='Avatar'><h5>".ucwords(strtolower($filas['NOM_SOLICITANTE']))."</h5></td>
                            <td class='text-left'><h6>".$filas['COMENTARIO']."</h6></td>
                            <td>".$filas['FECHA_FORMATO']."</td>
                            <td><span class='".$nomEstuloText."'> ".$filas['NOM_ESTATUS']." </span></td>
                        </tr>";
        }


        return $string;
    }

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company Neta System C.A
     * @description Permite formatear la fecha
     * @access public
     *
     */
    public function metodoFormateoFecha($fechaOriginal){
        $fechaDesfrag = explode('-', $fechaOriginal);
        $arrayMeses = array('01'=>'ENE', '02'=>'FEB', '03'=>'MAR', '04'=>'ABR', '05'=>'MAY', '06'=>'JUL', '07'=>'JUN', '08'=>'AUG', '09'=>'SEP', '10'=>'OCT', '11'=>'NOV', '12'=>'DIC');
        $fechaFinal = $fechaDesfrag[0]."-".$arrayMeses[$fechaDesfrag[1]]."-".$fechaDesfrag[2];
        return $fechaFinal;
    }





    }//fin del modelo
