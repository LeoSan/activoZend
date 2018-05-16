<?php
require_once 'Pendum/utils/Utils.php';
class Catalogos_CategoriasController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	$this->view->baseUrl = $this->getRequest()->getBaseUrl();
    	$this->_helper->layout()->disableLayout();
    }

    public function indexAction()
    {
    	$params = $this->getRequest()->getParams();
    	$condicion = "";
    	if (isset($params['status']) && $params['status'] != ''){
    		$condicion .= " FCSTATUS = '" . $params['status']."'";
    	}
        
        $Categoria = new Catalogos_Model_Categoria();
        $categorias = $Categoria->getCategoriasDetalle($condicion);

        $this->view->categorias = $categorias;
        $this->view->idStatusSelected = isset($params['status'])? $params['status']:'A';
    }

	public function addAction()
    {
    	$condicion 	= "";
        $Categoria 	= new Catalogos_Model_Categoria();
        $categorias = $Categoria->getCategoriasDetalle($condicion);

        $this->view->categorias = $categorias;
    }
    
	public function getcategoriaAction()
    {
    	$params = $this->getRequest()->getParams();
    	$id = $params['id'];
    	
    	$where = " AND IDCUENTACAT = " . $id  ."";
    	/*
    	echo json_encode($where);
        die();
    	*/
        
    	$suc = new Catalogos_Model_Categoria();
    	$sucursal = $suc->getCategoriasDetalle($where);
    	//var_dump($sucursal);exit;
    	
    	
    	if( count($sucursal) > 0) {
        	$response['respuesta'] = 'success';
        	$response['query'] = $where;
	        $response['categoria'] = $sucursal;
        } else {
        	$response['respuesta'] = 'fail';
        	$response['query'] = $where;
        }
        echo json_encode($response);
        die();
    }
    
	public function setcategoriaAction()
    {
    	$params = $this->getRequest()->getParams();
    	
    	
          
        $Cat = new Catalogos_Model_Categoria();
        $error = '';
        
        if(isset($params["idCategoria"]) && $params["idCategoria"] == '0'){
        	$error = $Cat->add($params);
        } else {
        	$error = $Cat->update($params);
        }
        
        $response['success'] = $error;
        echo json_encode($response);
        die();
    }
	
	public function getCategoriasAction()
    {
             
        $params = $this->getRequest()->getParams();
        //$credito = $params['credito'];
        $userQuasar = $params['userQuasar'];
        $_search = $params['_search'];
        //$status = $params['status'];
        $userid = $params['userid'];
        $sidx = $params['sidx'];
        $sord = $params['sord'];
        $page = $params['page'];
        $limit = $params['rows'];
        $filters = isset ($params['filters']) ? $params['filters'] : '';
        
        
        $where = Utils::getWhereFromFilters($filters);
        
        $replace = array("Inactivo","Activo","INACTIVO","ACTIVO"); 
        $replacepor = array("I","A","I","A");
   
        
        $where = str_replace($replace,$replacepor,$where);
        
//        die(print_r($where));
        
              
       $condicion = "";
        if($where == "") {
            $condicion = " ORDER BY ". $sidx." ".$sord;
        } else {
            $condicion =" AND ". $where." ORDER BY ". $sidx." ".$sord;
        }
        $Categoria = new Catalogos_Model_Categoria();
        $count = $Categoria->countCategorias($condicion);
        
        if(isset($count)) {
            $totalReg = 0;
        } else {
           $totalReg = $count[0]['TOTAL'];
        }
        $response['records'] = $totalReg;         
//        die(print_r($condicion));
//        exit();
        $categorias = $Categoria->getCategoriasDetalle($condicion);            
        
        
        //die(print_r());
        
                $i = 0;
        foreach ($categorias as $item) {
            $response['rows'][$i]['id'] = $item['IDCUENTACAT'];           
       
            $response['rows'][$i]['cell'] = array(
            	$item['IDCUENTACAT'],
            	$item['NMDESCRIP'],
            	$item['FCSTATUS'] = ($item['FCSTATUS'] == "A") ? "Activo" : "Inactivo",
                $item['IDUSUARIO'],
            	$item['FDFECULTMOVTO2'],
                "<i id-rel='{$item['IDCUENTACAT']}' class='icon-edit editarCat' title='Editar {$item['NMDESCRIP']}' style='cursor:pointer;'></i>"
            );
            $i++;
        }
        echo json_encode($response);
        die(); 
    }
}

