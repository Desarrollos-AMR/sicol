<?php
/**
 * @author 
 * @version 1.0
 * @created 
 */
 
require_once "ConexionDatos.php";

class ordenesdetalle
{
	var $orden;
	var $tarifa;
	var $cantidad;
	var $operacion;
	var $detalle;
	var $Conexion;

	public function constructor($tarifa , $cantidad, $operacion, $pConexion)
	{
		$this->$orden=$porden;
		$this->$tarifa=$ptarifa;
		$this->$cantidad=$pcantidad;
		$this->$operacion=$poperacion;
		$this->$detalle=$pdetalle;
		$this->$Conexion=$pConexion;
	}
	
	public function agregarordenesdetalle($porden, $ptarifa , $pcantidad, $poperacion, $pdetalle)
	{	
		$this->Conexion=Conectarse();
		$sql="insert into gc_ordenes_detalle(orden,tarifa,cantidad,operacion,detalle) values ('$porden','$ptarifa' , '$pcantidad', '$poperacion','$pdetalle')";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
	public function consultarproducto()
	{
		$this->Conexion=Conectarse();
		$sql="select * from gc_ordenes_detalle";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
}
?>