<?php
/**
 * @author 
 * @version 1.0
 * @created 
 */
 
require_once "ConexionDatos.php";

class progreciboproductos
{
	var $progid;
	var $producto;
	var $cantidad;
	var $Conexion;

	public function constructor($pprogid, $pproducto , $pcantidad , $pConexion)
	{
		$this->$progid=$pprogid;
		$this->$producto=$pprodcuto;
		$this->$cantidad=$pcantidad;
		$this->$Conexion=$pConexion;
	}
	
	public function agregarprogreciboproductos($pprogid, $pproducto , $pcantidad )
	{	
		$this->Conexion=Conectarse();
		$sql="insert into gc_programacion_recibo_productos(programacionid, producto, cantidad) values ('$pprogid', '$pproducto', '$pcantidad')";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
	public function consultarproducto()
	{
		$this->Conexion=Conectarse();
		$sql="select * from gc_programacion_recibo_productos";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
}
?>