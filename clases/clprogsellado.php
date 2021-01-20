<?php
/**
 * @author 
 * @version 1.0
 * @created 
 */
 
require_once "../php_debugging.php";

require_once "ConexionDatos.php";

class progsellado
{
	var $presentacion;
	var $fecha;
	var $orden;
	var $grado;
	var $producto;
	var $solicitante;
	var $cantidad;
	var $Conexion;

	public function constructor($pfecha,$porden, $pgrado, $pproducto, $psolicitante, $pcantidad, $ppresentacion, $pConexion)
	{
		$this->$fecha=$pfecha;
		$this->$orden=$porden;
		$this->$grado=$pgrado;
		$this->$producto=$pproducto;
		$this->$solicitante=$psolicitante;
		$this->$cantidad=$pcantidad;
		$this->$presentacion=$ppresentacion;
		$this->$Conexion=$pConexion;
	}
	
	public function agregarprogsellado($pfecha,$porden, $pgrado, $pproducto, $psolicitante, $pcantidad, $ppresentacion)
	{	
		$this->Conexion=Conectarse();
		$sql="insert into gc_produccion_programacion(fecha, orden, grado, producto, solicitante, cantidad, presentacion) values ('$pfecha','$porden', '$pgrado', '$pproducto', '$psolicitante', '$pcantidad', '$ppresentacion')";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
	public function consultarproducto()
	{
		$this->Conexion=Conectarse();
		$sql="select * from gc_produccion_programacion";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
}
?>