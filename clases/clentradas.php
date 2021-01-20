<?php
/**
 * @author 
 * @version 1.0
 * @created 
 */
 
require_once "ConexionDatos.php";

class entradas
{
	var $fecha;
	var $tiquete;
	var $cantidadtm;
	var $cantidadsacos;
	var $producto;
	var $cliente;
	var $orden;
	var $bodega;
	var $lote;
	var $Conexion;

	public function constructor($pfecha, $ptiquete, $pproducto, $pcantidadtm, $pcantidadsacos, $pcliente, $porden, $pbodega, $plote, $pConexion)
	{
		$this->$fecha=$pfecha;
		$this->$tiquete=$ptiquete;
		$this->$cantidadtm=$pcantidadtm;
		$this->$cantidadsacos=$pcantidadsacos;
		$this->$producto=$pproducto;
		$this->$cliente=$pcliente;
		$this->$orden=$porden;
		$this->$bodega=$pbodega;
		$this->$lote=$plote;
		$this->$Conexion=$pConexion;
	}
	
	public function agregarentradas($pfecha, $ptiquete, $pcantidadtm, $pcantidadsacos, $pproducto, $pcliente, $porden, $pbodega, $plote)
	{	
		$this->Conexion=Conectarse();
		$sql="insert into gc_recibo_inventario(fecha, tiquete, cantidad_tm, cantidad_sacos, producto, cliente, orden, bodega, lote) values ('$pfecha', '$ptiquete', '$pcantidadtm', '$pcantidadsacos', '$pproducto', '$pcliente', '$porden', '$pbodega', '$plote')";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
	public function consultarproducto()
	{
		$this->Conexion=Conectarse();
		$sql="select * from gc_recibo_inventario";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
}
?>