<?php
/**
 * @author 
 * @version 1.0
 * @created 
 */
 
require_once "ConexionDatos.php";

class progrecibo
{

	var $fecha;
	var $motonave;
	var $Conexion;

	public function constructor($fecha , $motonave, $pConexion)
	{
		$this->$fecha=$pfecha;
		$this->$motonave=$pmotonave;
		$this->$Conexion=$pConexion;
	}
	
	public function agregarprogrecibo($pfecha , $pmotonave )
	{	
		$this->Conexion=Conectarse();
		$sql="insert into gc_programacion_recibo(fecha_estimada, motonave) values ('$pfecha', '$pmotonave')";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
	public function consultarproducto()
	{
		$this->Conexion=Conectarse();
		$sql="select * from gc_programacion_recibo";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
}
?>