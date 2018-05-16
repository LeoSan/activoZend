<?php
require_once "Zend/Registry.php";
class Controlactivos_IndexController extends Zend_Controller_Action
{
    public $model = "";

    public function init(){
        $this->model = new Controlactivos_Model_Activos();
        $this->view->baseUrl = $this->getRequest()->getBaseUrl();
        session_start();
    }

//VIEW ************* ACCIONES DE VISTAS

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company Pendulum C.V
     * @deprecated Genera Interfaz
     * @access public
     *
     */
    public function viewProveedorAction()
    {
        $this->_helper->layout->setLayout('quantum');
    }

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company Pendulum C.V
     * @deprecated Genera Interfaz
     * @access public
     *
     */
    public function viewFisicoAction()
    {
        $this->_helper->layout->setLayout('quantum');
    }

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company Pendulum C.V
     * @deprecated Genera Interfaz
     * @access public
     *
     */
    public function viewTipoAsignacionAction()
    {
        $this->_helper->layout->setLayout('quantum');
    }

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company Pendulum C.V
     * @deprecated Genera Interfaz
     * @access public
     *
     */
    public function viewTipoActivoAction(){
        $this->_helper->layout->setLayout('quantum');
    }
    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company Pendulum C.V
     * @deprecated Genera Interfaz
     * @access public
     *
     */
    public function viewCategoriaActivoAction(){
        $this->_helper->layout->setLayout('quantum');
    }

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company Pendulum C.V
     * @deprecated Genera Interfaz
     * @access public
     *
     */
    public function viewMetodoSolicitudAction()
    {
        $this->_helper->layout->setLayout('quantum');
    }

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company Pendulum C.V
     * @deprecated Genera Interfaz
     * @access public
     *
     */
    public function viewUbicacionAction()
    {
        $this->_helper->layout->setLayout('quantum');
        $activoModel = new Controlactivos_Model_Activos();
        $this->view->SUCURSAL = $activoModel->parseoJsonSucursal();
    }

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company Pendulum C.V
     * @deprecated Genera Interfaz
     * @access public
     *
     */
    public function viewAdminActivoAction()
    {
        $this->_helper->layout->setLayout('quantum');
        $activoModel = new Controlactivos_Model_Activos();
        //Obtengo los Catalagos
        $param['tipoCatalogo'] = 'TIPO_ACTIVO';
        $this->view->TIPO_ACTIVO = $activoModel->parseoJsonCatalogo($param, 1);
        $param['tipoCatalogo'] = 'TIPO_ASIGNACION';
        $this->view->TIPO_ASIGNACION = $activoModel->parseoJsonCatalogo($param, 1);
        $param['tipoCatalogo'] = 'ESTADO_FISICO';
        $this->view->ESTADO_FISICO = $activoModel->parseoJsonCatalogo($param, 1);
        $param['tipoCatalogo'] = 'CATEGORIA_ACTIVO';
        $this->view->CATEGORIA = $activoModel->parseoJsonCatalogo($param, 1);
        $this->view->PROVEEDOR = $activoModel->parseoJsonProveedor( 1 );
        $this->view->SUCURSAL = $activoModel->parseoJsonSucursal();

    }

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company Pendulum C.V
     * @deprecated Genera Interfaz
     * @access public
     *
     */
    public function viewSolicitudAction(){
        $this->_helper->layout->setLayout('quantum');
        $activoModel = new Controlactivos_Model_Activos();
        $param['tipoCatalogo'] = 'CATEGORIA_ACTIVO';
        $this->view->CATEGORIA = $activoModel->parseoJsonCatalogo($param, 1);
        $param['tipoCatalogo'] = 'TIPO_ACTIVO';
        $this->view->TIPO_ACTIVO = $activoModel->parseoJsonCatalogo($param, 1);
        $param['tipoCatalogo'] = 'MOTIVO_SOLICITUD';
        $this->view->MOTIVO = $activoModel->parseoJsonCatalogo($param, 1);
        $param['referencia'] = 'SYS_CONTROL_ACTIVOS';
        $param['valida'] = 1;
        $param['estatus'] = '6';
        $this->view->ESTATUS = $activoModel->obtenerEstatus($param);

    }

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company Pendulum C.V
     * @deprecated Genera Interfaz
     * @access public
     *
     */
    public function viewSolicitudAdminAction(){
        $param = $this->getRequest()->getParams();
        $this->_helper->layout->setLayout('quantum');
        $activoModel = new Controlactivos_Model_Activos();
        $param['tipoCatalogo'] = 'CATEGORIA_ACTIVO';
        $this->view->CATEGORIA = $activoModel->parseoJsonCatalogo($param, 1);
        $param['tipoCatalogo'] = 'TIPO_ACTIVO';
        $this->view->TIPO_ACTIVO = $activoModel->parseoJsonCatalogo($param, 1);
        $param['tipoCatalogo'] = 'MOTIVO_SOLICITUD';
        $this->view->MOTIVO = $activoModel->parseoJsonCatalogo($param, 1);
        $param['referencia'] = 'SYS_CONTROL_ACTIVOS';
        $param['valida'] = 1;
        $param['estatus'] = '2,3,4';
        $this->view->ESTATUS = $activoModel->obtenerEstatus($param);
        $this->view->IDESTATUS = $param['idEstatus'];

    }

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company Pendulum C.V
     * @deprecated Genera Interfaz
     * @access public
     *
     */
    public function obtenerJsonProveedorAction()
    {
        $activoModel = new Controlactivos_Model_Activos();
        $arregloTemp = $activoModel->parseoJsonProveedor();
        echo $arregloTemp;
        exit();

    }

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company Pendulum C.V
     * @deprecated Genera Interfaz
     * @access public
     *
     */
    public function obtenerJsonCatalogoAction()
    {
        $activoModel = new Controlactivos_Model_Activos();
        $params = $this->getRequest()->getParams();
        $arregloTemp = $activoModel->parseoJsonCatalogo($params);
        echo $arregloTemp;
        exit();

    }

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company Pendulum C.V
     * @deprecated Genera Interfaz
     * @access public
     *
     */
    public function obtenerJsonUbicacionAction()
    {
        $activoModel = new Controlactivos_Model_Activos();
        $arregloTemp = $activoModel->parseoJsonUbicacion();
        echo $arregloTemp;
        exit();

    }

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company Pendulum C.V
     * @deprecated Genera Interfaz
     * @access public
     *
     */
    public function obtenerJsonAdminActivoAction()
    {
        $activoModel = new Controlactivos_Model_Activos();
        $arregloTemp = $activoModel->parseoJsonAdminActivo();
        echo $arregloTemp;
        exit();
    }

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company Pendulum C.V
     * @deprecated Genera Interfaz
     * @access public
     *
     */
    public function obtenerJsonSolicitudAction()
    {
        $activoModel = new Controlactivos_Model_Activos();
        $params = $this->getRequest()->getParams();
        $params['idSolicitud'] = '20112';
        $params['admin'] = 0;
        $params['idEstatus'] = 0;
        $arregloTemp = $activoModel->parseoJsonSolicitud($params);
        echo $arregloTemp;
        exit();
    }


    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company Pendulum C.V
     * @deprecated Genera Interfaz
     * @access public
     *
     */
    public function obtenerJsonSolicitudAdminAction()
    {
        $activoModel = new Controlactivos_Model_Activos();
        $params = $this->getRequest()->getParams();
        $params['idSolicitud'] = '0';
        $params['admin'] = 1;
        $params['idEstatus'] = 0;
        $arregloTemp = $activoModel->parseoJsonSolicitudAdmin($params);
        echo $arregloTemp;
        exit();
    }
    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company Pendulum C.V
     * @deprecated Genera Interfaz
     * @access public
     *
     */
    public function obtenerBitacoraAction()
    {
        $activoModel = new Controlactivos_Model_Activos();
        $params = $this->getRequest()->getParams();
        $params['url'] = $this->getRequest()->getBaseUrl();
        echo $arregloTemp = $activoModel->obtenerBitacora($params);
        exit();
    }

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company Pendulum C.V
     * @deprecated Genera Interfaz
     * @access public
     *
     */
    public function obtenerIdiomaAction()
    {
        $activoModel = new Controlactivos_Model_Activos();
        $arregloTemp = $activoModel->parseoJsonIdioma();
        echo $arregloTemp;
        exit();

    }

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company Pendulum C.V
     * @deprecated Genera Interfaz
     * @access public
     *
     */
    public function obtenerUbicacionParametroAction()
    {
        $activoModel = new Controlactivos_Model_Activos();
        $params = $this->getRequest()->getParams();
        $arregloTemp = $activoModel->obtenerParametrosUbicacion($params);
        echo $arregloTemp;
        exit();

    }

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company Pendulum C.V
     * @deprecated Genera Interfaz
     * @access public
     *
     */
    public function obtenerListaActivoAction()
    {
        $activoModel = new Controlactivos_Model_Activos();
        $params = $this->getRequest()->getParams();
        $arregloTemp = $activoModel->obtenerListaActivo($params);
        echo $arregloTemp;
        exit();

    }









//PROCESAR ************* Acciones de Registrar, Editar, Deshabilitar

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company Pendulum C.V
     * @deprecated Permite tratar la información del formulario proveedor en las tres acciones posibles Registrar, Editar, Deshabilitar
     * @access public
     *
     */
    public function procesarProveedorAction()
    {
        $activoModel = new Controlactivos_Model_Activos();
        $params = $this->getRequest()->getParams();
        $arregloTemp = $activoModel->procesarProveedor($params);
        echo $arregloTemp;
        exit();

    }
    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company Pendulum C.V
     * @deprecated Permite tratar la información del formulario proveedor en las tres acciones posibles Registrar, Editar, Deshabilitar
     * @access public
     *
     */
    public function procesarUbicacionAction()
    {
        $activoModel = new Controlactivos_Model_Activos();
        $params = $this->getRequest()->getParams();
        $arregloTemp = $activoModel->procesarUbicacion($params);
        echo $arregloTemp;
        exit();

    }

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company Pendulum C.V
     * @deprecated Permite tratar la información del formulario proveedor en las tres acciones posibles Registrar, Editar, Deshabilitar
     * @access public
     *
     */
    public function procesarAdminActivoAction(){
        $activoModel = new Controlactivos_Model_Activos();
        $params = $this->getRequest()->getParams();
        $arregloTemp = $activoModel->procesarAdminActivo($params);
        echo $arregloTemp;
        exit();

    }

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company Pendulum C.V
     * @deprecated Permite tratar la información del formulario proveedor en las tres acciones posibles Registrar, Editar, Deshabilitar
     * @access public
     *
     */
    public function procesarCatalogoAction()
    {
        $activoModel = new Controlactivos_Model_Activos();
        $params = $this->getRequest()->getParams();
        $arregloTemp = $activoModel->procesarCatalogo($params);
        echo $arregloTemp;
        exit();

    }

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company Pendulum C.V
     * @deprecated Permite tratar la información del formulario proveedor en las tres acciones posibles Registrar, Editar, Deshabilitar
     * @access public
     *
     */
    public function procesarSolicitudAction()
    {
        $activoModel = new Controlactivos_Model_Activos();
        $params = $this->getRequest()->getParams();
        $arregloTemp = $activoModel->procesarSolicitud($params);
        echo $arregloTemp;
        exit();

    }



    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company Pendulum C.V
     * @deprecated Permite tratar la información del formulario proveedor en las tres acciones posibles Registrar, Editar, Deshabilitar
     * @access public
     *
     */
    public function procesarUploadCsvAction()
    {
        try{
            $this->_helper->layout->disableLayout();
            // Define a destination
            $targetFolder =  $_SERVER['DOCUMENT_ROOT']  .  $this->getRequest()->getBaseUrl()."/doc/cargacsv/activo/";
            $fechaFile = date("YmdHis");
            if (!empty($_FILES)) {
                $tempFile = $_FILES['file_csv']['tmp_name'];
                $targetPath = $targetFolder;
                // Validate the file type
                $fileTypes = array('CSV', 'csv'); // File extensions
                $fileParts = pathinfo($_FILES['file_csv']['name']);

                $nombreArchivo = "CARGA_MASIVA_ACTIVO_" . $fechaFile . "." . $fileParts['extension'];
                $targetFile = rtrim($targetPath,'/') . "/".$nombreArchivo;

                if ( in_array( strtolower( $fileParts['extension'] ) , $fileTypes ) ) {

                    $up = move_uploaded_file($tempFile,$targetFile);
                    if( !$up ){
                        throw new Exception("No se pudo mover el archivo: " . $targetFile);
                        $result['valida'] = 'false';
                        $result['msg'] = "No se pudo mover el archivo: " . $targetFile;
                        echo json_encode($result); die();
                    }else{
                        $result['valida'] = 'true';
                        $result['nom'] = $nombreArchivo;
                        $result['url'] = $targetFile;
                        echo json_encode($result); die();
                    }

                } else {
                    $result['valida'] = 'false';
                    echo json_encode($result);
                    die();
                }
            } else {
                $result['valida'] = 'false';
                echo json_encode($result);
                die();
            }
        } catch( Exception $e) {
            $result['valida'] = 'false';
            $result['msg'] = "Excepción: " . $e->getMessage();
            echo json_encode($result); die();
        }
    }

    /**
     * @author Leonard Cuenca <ljcuenca@pendulum.com.mx>
     * @company Pendulum C.V
     * @deprecated Permite tratar la información del formulario proveedor en las tres acciones posibles Registrar, Editar, Deshabilitar
     * @access public
     *
     */
    public function procesarCsvAction()
    {
        try{
            $this->_helper->layout->disableLayout();
            $params = $this->getRequest()->getParams();
            // Define a destination
            $targetFolder =  $_SERVER['DOCUMENT_ROOT']  .  $this->getRequest()->getBaseUrl()."/doc/cargacsv/activo/";
            $fechaFile = date("YmdHis");

            $chk_ext = explode(".",$params['inpNombreArchivo']);


            // 356K es el tamaño solo con los titulos no tiene valores incluidos
            $validaCsvVAcio =  filesize ( $targetFolder.$params['inpNombreArchivo'] );

            if(strtolower(end($chk_ext)) == "csv" && $validaCsvVAcio > 356 ){
                //si es correcto, entonces damos permisos de lectura para subir
                $handle = fopen($targetFolder.$params['inpNombreArchivo'], "r");
                $query = 'BEGIN ';
                $indice = 0;
                $validaNulo = false;
                $validaNumerico = false;

                while (($data = fgetcsv($handle, 2000, ",")) !== FALSE){
                    if ($indice != 0){

                        if (is_numeric($data[0]) == true && is_numeric( $data[1]) == true && is_numeric($data[2]) == true && is_numeric($data[3]) == true && is_numeric($data[4]) == true && is_numeric($data[5]) == true){
                            if (empty($data[0]) == true || empty( $data[1]) == true || empty($data[2]) == true || empty($data[3]) == true || empty($data[4]) == true || empty($data[5]) == true || empty($data[6]) == true || empty($data[7]) == true || empty($data[8]) == true || empty($data[9]) == true || empty($data[10]) == true || empty($data[11]) == true || empty($data[12]) == true ){
                                    $validaNulo = true;
                                    break;
                                }else{
                                   $query  .= "PENDUPM.PCK_CONTROL_ACTIVOS.insertActivo(".strtoupper($data[0]).", ".strtoupper($data[1]).", ".strtoupper($data[2]).", ".strtoupper($data[3]).", ".strtoupper($data[4]).", ".strtoupper($data[5]).", '".strtoupper($data[6])."', '".strtoupper($data[7])."', '".strtoupper($data[8])."', '".strtoupper($data[9])."', '".strtoupper($data[10])."', '".strtoupper($data[11])."', '".strtoupper($data[12])."', :psError);";
                                }
                        }else{
                            $validaNumerico = true;
                            break;
                        }


                    }//No incluir los titulos
                    $indice++;
                }
                $query  .= " END;";
                //cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
                fclose($handle);

                // Procesos
                if ($validaNulo == true){
                    $result['valida'] = 'false';
                    $result['msg'] = "Archivo tiene valores nulos";
                    echo json_encode($result); die();
                }else if ($validaNumerico == true){
                    $result['valida'] = 'false';
                    $result['msg'] = "Archivo tiene valores string en los campos numericos";
                    echo json_encode($result); die();
                }else{
                    $activoModel = new Controlactivos_Model_Activos();
                    $arregloTemp = $activoModel->procesarCargaAdminActivo($query);
                    echo $arregloTemp;
                    exit();
                }
            }else{
                $result['valida'] = 'false';
                $result['msg'] = "Archivo no valido, tiene valores nulos";
                echo json_encode($result); die();
            }

        } catch( Exception $e) {
            $result['valida'] = 'false';
            $result['msg'] = "Excepción: " . $e->getMessage();
            echo json_encode($result); die();
        }
    }






}//fin del controlador