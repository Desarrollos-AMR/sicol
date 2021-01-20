<?php
/**
 * @author 
 * @version 1.0
 * @created 
 */
 
require_once "../php_debugging.php";

require_once "ConexionDatos.php";

class emprecibo
{

	var $fecha;
	var $grado;
	var $cantidad;
	var $bodega;
	var $origen;
	var $observacion;
	var $Conexion;

	public function constructor($pfecha,$pbodega, $pgrado, $porigen, $pobservacion, $pcantidad, $pConexion)
	{
		$this->$fecha=$pfecha;
		$this->$bodega=$pbodega;
		$this->$grado=$pgrado;
		$this->$origen=$porigen;
		$this->$observacion=$pobservacion;
		$this->$cantidad=$pcantidad;
		$this->$Conexion=$pConexion;
	}
	
	public function agregaremprecibo($pfecha,$pbodega, $pgrado, $porigen, $pobservacion, $pcantidad)
	{	
		$this->Conexion=Conectarse();
		$sql="insert into gc_emp_recibo(fecha, bodega, grado, origen, observacion, cantidad) values ('$pfecha','$pbodega', '$pgrado', '$porigen', '$pobservacion', '$pcantidad')";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
	public function consultarproducto()
	{
		$this->Conexion=Conectarse();
		$sql="select * from gc_emp_recibo";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
}
?>