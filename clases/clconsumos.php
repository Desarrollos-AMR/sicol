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
	var $acta;
	var $producto;
	var $cantidad;
	var $Conexion;

	public function constructor($pfecha , $pacta , $pproducto , $pcantidad , $pConexion)
	{
		$this->$fecha=$pfecha;
		$this->$acta=$pacta;
		$this->$producto=$pprodcuto;
		$this->$cantidad=$pcantidad;
		$this->$Conexion=$pConexion;
	}
	
	public function agregaractas($pfecha , $pacta , $pproducto , $pcantidad )
	{	
		$this->Conexion=Conectarse();
		$sql="insert into gc_produccion(fecha, acta, producto, cantidad) values ('$pfecha', '$pacta', '$pproducto', '$pcantidad')";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
	public function consultarproducto()
	{
		$this->Conexion=Conectarse();
		$sql="select * from gc_actas";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
}
?>