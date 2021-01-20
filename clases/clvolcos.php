<?php
/**
 * @author 
 * @version 1.0
 * @created 
 */
 
require_once "../php_debugging.php";

require_once "ConexionDatos.php";

class volcos
{

	var $fecha;
	var $progid;
	var $producto;
	var $presentacion;
	var $bodega;
	var $tiquete;
	var $placas;
	var $porigen;
	var $pbascula;
	var $Conexion;

	public function constructor($pfecha , $pprogid, $pproducto, $ppresentacion, $pbodega, $ptiquete, $pplacas, $pporigen, $ppbascula, $pConexion)
	{
		$this->$fecha=$pfecha;
		$this->$progid=$pprogid;
		$this->$producto=$pproducto;
		$this->$presentacion=$ppresentacion;
		$this->$bodega=$pbodega;
		$this->$tiquete=$ptiquete;
		$this->$placas=$pplacas;
		$this->$porigen=$pporigen;
		$this->$pbascula=$ppbascula;
		$this->$Conexion=$pConexion;
	}
	
	public function agregarvolcos($pfecha , $pprogid, $pproducto, $ppresentacion, $pbodega, $ptiquete, $pplacas, $pporigen, $ppbascula)
	{	
		$this->Conexion=Conectarse();
		$sql="insert into gc_recibo_buques_contenedores(fecha, programacionid, producto, presentacion, bodega, tiquete, placas, peso_origen, peso_bascula) values ('$pfecha' , '$pprogid', '$pproducto', '$ppresentacion', '$pbodega', '$ptiquete', '$pplacas',  '$pporigen', '$ppbascula')";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
	public function consultarproducto()
	{
		$this->Conexion=Conectarse();
		$sql="select * from gc_recibo_buques_contenedores";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
}
?>