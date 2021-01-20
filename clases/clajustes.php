<?php
/**
 * @author 
 * @version 1.0
 * @created 
 */
require_once "ConexionDatos.php";

class ajustes
{
	var $fecha;
	var $usuario;
	var $producto;
	var $cantidadtm;
	var $cantidadsacos;
	var $bodega;
	var $lote;
	var $tipo;
	var $clipro;
	var $observacion;
	var $consecutivo;
	var $Conexion;

	public function constructor($pusuario, $pfecha, $pproducto, $pcantidadtm, $pcantidadsacos, $pbodega, $plote, $ptipo, $pclipro, $pobservacion, $pconsecutivo, $pConexion)
	{
		$this->$fecha=$pfecha;
		$this->$usuario=$pusuario;
		$this->$producto=$pproducto;
		$this->$cantidadtm=$pcantidadtm;
		$this->$cantidadsacos=$pcantidadsacos;
		$this->$bodega=$pbodega;
		$this->$lote=$plote;
		$this->$tipo=$ptipo;
		$this->$clipro=$pclipro;
		$this->$observacion=$pobservacion;
		$this->$consecutivo=$pconsecutivo;
		$this->$Conexion=$pConexion;
	}
	
	public function agregarajustes($pusuario, $pfecha, $pproducto, $pcantidadtm, $pcantidadsacos, $pbodega, $plote, $ptipo, $pclipro, $pobservacion, $pconsecutivo)
	{	
		$objConexion=Conectarse();
		$sql="insert into gc_ajustes(usuario, fecha, producto, cantidad_tm, cantidad_sacos, bodega, lote, tipo, cliente, observacion, consecutivo) values ('$pusuario', '$pfecha', '$pproducto', '$pcantidadtm', '$pcantidadsacos', '$pbodega', '$plote', '$ptipo', '$pclipro', '$pobservacion', '$pconsecutivo')";
		$resultado=mysqli_query($objConexion,$sql) or die('Error insertando ajuste' . mysqli_error($objConexion));
		require("calcular_existencias1.php");
		return $resultado;	
	}
	
	public function consultarproducto()
	{
		$this->Conexion=Conectarse();
		$sql="select * from gc_ajustes";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
}
?>