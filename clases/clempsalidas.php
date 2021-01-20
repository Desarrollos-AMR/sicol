<?php
/**
 * @author 
 * @version 1.0
 * @created 
 */
 
require_once "../php_debugging.php";

require_once "ConexionDatos.php";

class empdespacho
{

	var $fecha;
	var $turno;
	var $bodega;
	var $grado;
	var $cantidad;
	var $motivo;
	var $operacion;
	var $orden;
	var $producto;
	var $autoriza;
	var $recibe;
	var $observacion;
	var $Conexion;

	public function constructor($fecha , $turno, $bodega, $grado, $cantidad, $motivo, $operacion, $orden, $producto, $autoriza, $recibe, $observacion, $pConexion)
	{
		$this->$fecha=$pfecha;
		$this->$turno=$pturno;
		$this->$bodega=$pbodega;
		$this->$grado=$pgrado;
		$this->$cantidad=$pcantidad;
		$this->$motivo=$pmotivo;
		$this->$operacion=$poperacion;
		$this->$orden=$porden;
		$this->$producto=$pproducto;
		$this->$autoriza=$pautoriza;
		$this->$recibe=$precibe;
		$this->$observacion=$pobservacion;
		$this->$Conexion=$pConexion;
	}
	
	public function agregarempdespacho($pfecha , $pturno, $pbodega, $pgrado, $pcantidad, $pmotivo, $poperacion, $porden, $pproducto, $pautoriza, $precibe, $pobservacion)
	{	
		$this->Conexion=Conectarse();
		$sql="insert into gc_emp_despacho(fecha, turno, bodega, grado, cantidad, motivo, operacion, orden, producto, autoriza, recibe, observacion) values ('$pfecha' , '$pturno', '$pbodega', '$pgrado', '$pcantidad', '$pmotivo', '$poperacion', '$porden', '$pproducto', '$pautoriza', '$precibe', '$pobservacion')";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
	public function consultarproducto()
	{
		$this->Conexion=Conectarse();
		$sql="select * from gc_emp_despacho";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
}
?>