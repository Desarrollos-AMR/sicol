<?php
/**
 * @author 
 * @version 1.0
 * @created 
 */
require_once "ConexionDatos.php";

class conductor
{

	var $nit;
	var $razonsocial;
	var $Conexion;

	public function constructor($pnit,$prazonsocial, $pConexion)
	{
		$this->$nit=$pnit;
		$this->$razonsocial=$prazonsocial;
		$this->$Conexion=$pConexion;
	}
	
	public function agregarconductores($pnit,$prazonsocial)
	{	
		$this->Conexion=Conectarse();
		$sql="insert into gc_conductores(cedula,nombre) values ('$pnit','$prazonsocial')";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
	public function consultarconductor()
	{
		$this->Conexion=Conectarse();
		$sql="select * from gc_conductores";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
}
?>