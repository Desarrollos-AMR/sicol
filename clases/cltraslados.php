<?php
/**
 * @author 
 * @version 1.0
 * @created 
 */
 
require_once "ConexionDatos.php";

class traslados
{
	var $fecha;
	var $consecutivo;
	var $producto;
	var $lote;
	var $cantidad;
	var $sacos;
	var $bodega;
	var $bodegad;
	var $clipro;
	var $motonave;
	var $Conexion;

	public function constructor( $pfecha, $pconsecutivo ,$pproducto, $plote, $pcantidad, $psacos, $pbodega, $pbodegad, $pclipro, $pmotonave, $pConexion)
	{
		$this->$fecha=$pfecha;
		$this->$consecutivo=$pconsecutivo;
		$this->$producto=$pproducto;
		$this->$lote=$plote;
		$this->$cantidad=$pcantidad;
		$this->$sacos=$psacos;
		$this->$bodega=$pbodega;
		$this->$bodegad=$pbodegad;
		$this->$clipro=$pclipro;
		$this->$motonave=$pmotonave;
		$this->$Conexion=$pConexion;
	}
	
	public function agregartraslados( $pfecha, $pconsecutivo ,$pproducto, $plote, $pcantidad, $psacos, $pbodega, $pbodegad, $pclipro,$pmotonave)
	{	
		$this->Conexion=Conectarse();
		$sql="insert into gc_traslados(fecha, consecutivo,producto, lote, cantidad, cantidad_sacos,  origen, destino, cliente,motonave) values ('$pfecha' , '$pconsecutivo', '$pproducto' , '$plote' , '$pcantidad', '$psacos' , '$pbodega', '$pbodegad', '$pclipro', '$pmotonave')";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
	public function consultartraslado()
	{
		$this->Conexion=Conectarse();
		$sql="select * from gc_traslados";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
}
?>