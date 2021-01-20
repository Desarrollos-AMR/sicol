<?php
/**
 * @author 
 * @version 1.0
 * @created 
 */
 
require_once "ConexionDatos.php";

class ordenes
{

	var $fecha;
	var $proveedor;
	var $Conexion;

	public function constructor($fecha , $proveedor, $pConexion)
	{
		$this->$fecha=$pfecha;
		$this->$proveedor=$pproveedor;
		$this->$Conexion=$pConexion;
	}
	
	public function agregarordenes($pfecha , $pproveedor)
	{	
		$this->Conexion=Conectarse();
		$sql="insert into gc_ordenes(fecha_sol_aprobacion, proveedor) values (now() , '$pproveedor')";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
	public function consultarproducto()
	{
		$this->Conexion=Conectarse();
		$sql="select * from gc_ordenes";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
}
?>