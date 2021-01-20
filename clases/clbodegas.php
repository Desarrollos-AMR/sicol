<?php
require_once "ConexionDatos.php";

class bodega
{

	var $nombre;
	var $Conexion;

	public function constructor($pnombre, $pConexion)
	{
		$this->$nombre=$pnombre;
		$this->$Conexion=$pConexion;
	}
	
	public function agregarbodegas($pnombre)
	{	
		$objConexion=Conectarse();
		$sql="insert into gc_bodegas(nombre) values ('$pnombre')";
		$resultado=mysqli_query($objConexion,$sql);
		$ultid= mysqli_insert_id($objConexion);
		$sql1="insert into gc_bodegas1(nombre, codori) values ('$pnombre', '$ultid')";
		$resultado1=mysqli_query($objConexion,$sql1);
		mysqli_close($objConexion);
		return $resultado;	
	}
	
	public function consultarbodega()
	{
		$this->Conexion=Conectarse();
		$sql="select * from gc_bodegas";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
}
?>