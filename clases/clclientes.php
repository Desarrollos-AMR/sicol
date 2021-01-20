<?php
/**
 * @author 
 * @version 1.0
 * @created 
 */
require_once "ConexionDatos.php";

class cliente
{

	var $nit;
	var $razonsocial;
	var $direccion;
	var $telefono;
	var $tipo;
	var $Conexion;

	public function constructor($pnit,$prazonsocial,$pdireccion, $ptelefono, $ptipo, $pConexion)
	{
		$this->$nit=$pnit;
		$this->$razonsocial=$prazonsocial;
		$this->$direccion=$pdireccion;
		$this->$telefono=$ptelefono;
		$this->$tipo=$ptipo;
		$this->$Conexion=$pConexion;
	}
	
	public function agregarclientes($pnit,$prazonsocial,$pdireccion,$ptelefono,$ptipo)
	{	
		$this->Conexion=Conectarse();
		$sql="insert into gc_clientes(nit,nombre,direccion,telefono,tipo) values ('$pnit','$prazonsocial','$pdireccion','$ptelefono','$ptipo')";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
	public function consultarcliente()
	{
		$this->Conexion=Conectarse();
		$sql="select * from gc_clientes";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
}
?>