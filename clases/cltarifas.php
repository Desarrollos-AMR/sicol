<?php
/**
 * @author 
 * @version 1.0
 * @created 
 */
require_once "ConexionDatos.php";

class tarifa
{
	var $nombre;
	var $proveedor;
	var $valor;
	var $unidad;
	var $Conexion;

	public function constructor($pnombre, $pproveedor, $pvalor, $punidad, $pConexion)
	{
		$this->$nombre=$pnombre;
		$this->$proveedor=$pproveedor;
		$this->$valor=$pvalor;
		$this->$unidad=$punidad;
		$this->$Conexion=$pConexion;
	}
	
	public function agregartarifas($pnombre,$pproveedor,$pvalor,$punidad)
	{	
		$this->Conexion=Conectarse();
		$sql="insert into gc_tarifas(nombre,proveedor,valor,unidad) values ('$pnombre','$pproveedor','$pvalor','$punidad')";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
	public function consultartarifa()
	{
		$this->Conexion=Conectarse();
		$sql="select * from gc_tarifas";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
}
?>