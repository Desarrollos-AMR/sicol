<?php
/**
 * @author 
 * @version 1.0
 * @created 
 */
require_once "ConexionDatos.php";

class prosalidas
{
	var $remisionid;
	var $fecha;
	var $producto;
	var $cantidadtm;
	var $cantidadsacos;
	var $bodega;
	var $lote;
	var $tipo;
	var $clamo;
	var $clipro;
    var $motonave;
    var $observacion;
	var $Conexion;

	public function constructor($pfecha, $premisionid, $pproducto, $pcantidadtm, $pcantidadsacos, $pbodega, $plote, $ptipo, $pclamo, $pclipro, $pmotonave, $pobservacion, $pConexion)
	{
		$this->$fecha=$pfecha;
		$this->$remisionid=$premisionid;
		$this->$producto=$pproducto;
		$this->$cantidadtm=$pcantidadtm;
		$this->$cantidadsacos=$pcantidadsacos;
		$this->$bodega=$pbodega;
		$this->$lote=$plote;
		$this->$tipo=$ptipo;
		$this->$clamo=$pclamo;
		$this->$clipro=$pclipro;
        $this->$motonave=$pmotonave;
		$this->$observacion=$pobservacion;
		$this->$Conexion=$pConexion;
	}
	
	public function agregarprosalidas($pfecha, $premisionid, $pproducto, $pcantidadtm, $pcantidadsacos, $pbodega, $plote, $ptipo, $pclamo, $pclipro, $pmotonave, $pobservacion)
	{	
		$objConexion=Conectarse();
		$sql="insert into gc_despachos_producto(fecha, remisionid, producto, cantidad_tm, cantidad_sacos, bodega, lote, tipo, clase_movimiento,cliente,motonave,observacion) values ('$pfecha', '$premisionid', '$pproducto', '$pcantidadtm', '$pcantidadsacos', '$pbodega', '$plote', '$ptipo', '$pclamo', '$pclipro', '$pmotonave', '$pobservacion')";
		$resultado=mysqli_query($objConexion,$sql) or die('MySql Error2' . mysqli_error($objConexion));
		require("calcular_existencias1.php");
		return $resultado;	
	}
	
	public function consultarproducto()
	{
		$this->Conexion=Conectarse();
		$sql="select * from gc_despachos_producto";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
}
?>