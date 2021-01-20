<?php
/**
 * @author 
 * @version 1.0
 * @created 
 */
require_once "ConexionDatos.php";

class varios
{

	var $fecha;
	var $detalle;
	var $Conexion;

	public function constructor($pfecha,$pdetalle, $pConexion)
	{
		$this->$fecha=$pfecha;
		$this->$detalle=$pdetalle;
		$this->$Conexion=$pConexion;
	}
	
	public function agregarvarios($pfecha,$pdetalle)
	{	
		$this->Conexion=Conectarse();
		$sql="insert into gc_varios(fecha,detalle) values ('$pfecha','$pdetalle')";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
	public function consultarvarios()
	{
		$this->Conexion=Conectarse();
		$sql="select * from gc_varios";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
}
?>