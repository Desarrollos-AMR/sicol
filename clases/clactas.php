<?php
/**
 * @author 
 * @version 1.0
 * @created 
 */
 
require_once "ConexionDatos.php";

class actas
{

	var $fecha;
	var $orden;
	var $acta;
	var $producto;
	var $cantidad;
	var $turno;
	var $grado;
	var $empaques;
	var $observacion;
	var $Conexion;

	public function constructor($fecha , $orden , $acta , $producto , $turno , $cantidad , $grado , $empaques , $observacion , $pConexion)
	{
		$this->$fecha=$pfecha;
		$this->$orden=$porden;
		$this->$acta=$pacta;
		$this->$producto=$pprodcuto;
		$this->$cantidad=$pcantidad;
		$this->$turno=$pturno;
		$this->$grado=$pgrado;
		$this->$empaques=$pempaques;
		$this->$observacion=$pobservacion;
		$this->$Conexion=$pConexion;
	}
	
	public function agregaractas($pfecha , $porden , $pacta , $pproducto , $pturno , $pcantidad , $pgrado , $pempaques , $pobservacion )
	{	
		$this->Conexion=Conectarse();
		$sql="insert into gc_produccion(fecha, orden, acta, producto, turno, cantidad_a_reportar, empaque, empaques_cantidad, observaciones ) values ('$pfecha', '$porden', '$pacta', '$pproducto', '$pturno', '$pcantidad', '$pgrado', '$pempaques', '$pobservacion')";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
	public function consultaractas()
	{
		$this->Conexion=Conectarse();
		$sql="select * from gc_produccion";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
}
?>