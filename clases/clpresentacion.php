<?php
/**
 * @author 
 * @version 1.0
 * @created 
 */
require_once "ConexionDatos.php";

class motonave
{

	var $kilos;
	var $Conexion;

	public function constructor($pkilos, $pConexion)
	{
		$this->$kilos=$pkilos;
		$this->$Conexion=$pConexion;
	}
	
	public function agregarmotonaves($pkilos)
	{	
		$this->Conexion=Conectarse();
		$sql="insert into gc_presentacion(kilos) values ('$pkilos')";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
	public function consultarmotonave()
	{
		$this->Conexion=Conectarse();
		$sql="select * from gc_presentacion";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
}
?>