<?php
class Catalogos_Model_Categoria
{
	public function getCategoriasDetalle($condicion = '')
	{
                $query = "select IDCUENTACAT,IDHIJO, NMDESCRIP,NMVALOR,FCSTATUS, TO_CHAR(FDFECULTMOVTO,'DD-Mon-YY' ,'nls_date_language=Spanish') FDFECULTMOVTO2,IDUSUARIO    from ctcuentacategoria where IDHIJO is null " . $condicion;
		$Oracle = Pendum_Db_DbFactory::factory('oracle');
        $categorias = $Oracle->query($query);
        return $categorias;
	}
	
	public function getDetalleSucursal($where = '')
	{
		//$where = "IDESTADO=''DF''";
		
		$query = "BEGIN PENDUPM.PCKCATALOGOS.GETDETALLESUCURSAL( '" . $where . "', :RESDATA ); END;";
		
		$Oracle = Pendum_Db_DbFactory::factory('oracle');
        $sucursales = $Oracle->getAll($query);
        return $sucursales;
	}
	
	public function add( $data )
	{
		//$where = "IDESTADO=''DF''";
		
		$query = "BEGIN PENDUPM.PCKCATALOGOS.AGREGACATEGORIA( " . 
			"'" . strtoupper($data['categoria']) . "'," .
			"'" . $data['userid'] . "'," .
			":psError ); END;";
		//return $query;
		$Oracle = Pendum_Db_DbFactory::factory('oracle');
        $aplica = $Oracle->set($query);
        return $aplica;
	}
	
	public function update( $data )
	{
		//$where = "IDESTADO=''DF''";
		
		$query = "BEGIN PENDUPM.PCKCATALOGOS.MODIFICACATEGORIA( " . 
			"'" . $data['idCategoria'] . "'," .
			"'" . strtoupper($data['categoria']) . "'," .
			"'" . $data['status'] . "'," .
			"'" . $data['userid'] . "'," .
			":psError ); END;";
		//return $query;
		$Oracle = Pendum_Db_DbFactory::factory('oracle');
        $aplica = $Oracle->set($query);
        return $aplica;
	}
	
	public function countCategorias($condicion = '' )
    {
            //$where = '';
		
		$query = "select COUNT(*) AS total from ctcuentacategoria where IDHIJO is null" . $condicion;
		$Oracle = Pendum_Db_DbFactory::factory('oracle');
        $contarReg = $Oracle->query($query);
        return $contarReg;
    }
    
	public function getAdminPermiso ($usr) {
    	$query = "SELECT COUNT(1) ADMIN FROM `GROUP_USER` 
    	           WHERE `USR_UID` LIKE '$usr' AND GRP_UID IN (SELECT UID_GROUP
                 FROM  pendu_pm.pendu_category_group
              WHERE NMSYSTEM =  'GASTOS'
                 AND TYPE =  'ADMIN')";
    	
    	$PM = Pendum_Db_DbFactory::factory('mysql');
        $data = $PM->getAll($query);
        return $data;
    	
    }
    
    	public function getCategorias()
	{
                $query = "select IDCUENTACAT,IDHIJO, NMDESCRIP,NMVALOR,FCSTATUS, TO_CHAR(FDFECULTMOVTO,'DD-Mon-YY' ,'nls_date_language=Spanish') FDFECULTMOVTO2,IDUSUARIO    from ctcuentacategoria where IDHIJO is null ORDER BY NMDESCRIP ASC";
		$Oracle = Pendum_Db_DbFactory::factory('oracle');
        $categorias = $Oracle->query($query);
        return $categorias;
	}
}