<?php
/**
 * @author 
 * @version 1.0
 * @created 
 */
require_once "ConexionDatos.php";

class empaque
{

	var $nombre;
	var $codigo;
	var $unidad;
	var $Conexion;

	public function constructor($pcodigo,$pnombre,$punidad, $pConexion)
	{
		$this->$nombre=$pnombre;
		$this->$codigo=$pcodigo;
		$this->$unidad=$punidad;
		$this->$Conexion=$pConexion;
	}
	
	public function agregarempaques($pcodigo,$pnombre,$punidad)
	{	
		$this->Conexion=Conectarse();
		$sql="insert into gc_empaques(codigo,nombre,unidad) values ('$pcodigo','$pnombre','$punidad')";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
	public function consultarempaque()
	{
		$this->Conexion=Conectarse();
		$sql="select * from gc_empaques";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
}
?>