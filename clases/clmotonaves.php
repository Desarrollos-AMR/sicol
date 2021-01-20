<?php
/**
 * @author 
 * @version 1.0
 * @created 
 */
require_once "ConexionDatos.php";

class motonave
{

	var $nombre;
	var $Conexion;

	public function constructor($pnombre, $pConexion)
	{
		$this->$nombre=$pnombre;
		$this->$Conexion=$pConexion;
	}
	
	public function agregarmotonaves($pnombre)
	{	
		$this->Conexion=Conectarse();
		$sql="insert into gc_motonaves(nombre) values ('$pnombre')";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
	public function consultarmotonave()
	{
		$this->Conexion=Conectarse();
		$sql="select * from gc_motonaves";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
}
?>