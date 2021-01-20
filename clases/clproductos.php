<?php
/**
 * @author 
 * @version 1.0
 * @created 
 */
require_once "ConexionDatos.php";

class producto
{

	var $nombre;
	var $codigo;
	var $presentacion;
	var $cliente;
	var $Conexion;

	public function constructor($pcodigo,$pnombre,$ppresentacion,$pcliente,$pConexion)
	{
		$this->$nombre=$pnombre;
		$this->$codigo=$pcodigo;
		$this->$presentacion=$ppresentacion;
		$this->$cliente=$pcliente;
		$this->$Conexion=$pConexion;
	}
	
	public function agregarproductos($pcodigo,$pnombre,$ppresentacion,$pcliente)
	{	
		$this->Conexion=Conectarse();
		$sql="insert into gc_productos(codigo,nombre,presentacion,cliente) values ('$pcodigo','$pnombre','$ppresentacion','$pcliente')";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
	public function consultarproducto()
	{
		$this->Conexion=Conectarse();
		$sql="select * from gc_productos";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
}
?>