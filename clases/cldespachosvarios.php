<?php
/**
 * @author 
 * @version 1.0
 * @created 
 */
 
require_once "../php_debugging.php";

require_once "ConexionDatos.php";

class despachos
{
	var $tipo;
	var $fecha;
	var $tiquete;
	var $concepto;
	var $placas;
	var $cantidad;
	var $unidad;
	var $observacion;
	var $Conexion;

	public function constructor($ptipo, $pfecha , $ptiquete, $pconcepto, $pplacas, $pcantidad, $punidad, $pobservacion, $pConexion)
	{
		$this->$tipo=$ptipo;
		$this->$fecha=$pfecha;
		$this->$tiquete=$ptiquete;
		$this->$concepto=$pconcepto;
		$this->$placas=$pplacas;
		$this->$cantidad=$pcantidad;
		$this->$unidad=$punidad;
		$this->$observacion=$pobservacion;
		$this->$Conexion=$pConexion;
	}
	
	public function agregardespachos($ptipo, $pfecha , $ptiquete, $pconcepto, $pplacas, $pcantidad, $punidad, $pobservacion)
	{	
		$this->Conexion=Conectarse();
		$sql="insert into gc_despachos_recibos_varios(tipo, fecha, tiquete, concepto, placas, cantidad, unidad, observacion) values ('$ptipo' , '$pfecha' , '$ptiquete', '$pconcepto',  '$pplacas', '$pcantidad', '$punidad', '$pobservacion')";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
	public function consultardespacho()
	{
		$this->Conexion=Conectarse();
		$sql="select * from gc_despachos_recibos_varios";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
}
?>