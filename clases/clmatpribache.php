<?php
/**
 * @author 
 * @version 1.0
 * @created 
 */
 
require_once "ConexionDatos.php";

class matpribache
{
	var $progid;
	var $bache;
	var $producto;
	var $cantidad;
	var $Conexion;

	public function constructor($pprogid, $pbache , $pproducto , $pcantidad , $pConexion)
	{
		$this->$progid=$pprogid;
		$this->$bache=$pprodcuto;
		$this->$producto=$pproducto;
		$this->$cantidad=$pcantidad;
		$this->$Conexion=$pConexion;
	}
	
	public function agregarmatpribache($pprogid, $pbache , $pproducto , $pcantidad )
	{	
		$this->Conexion=Conectarse();
		$sql="insert into gc_materia_prima_por_bache(orden, numero_de_bache, materia_prima, cantidad) values ('$pprogid', '$pbache', '$pproducto', '$pcantidad')";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
	public function consultarbache()
	{
		$this->Conexion=Conectarse();
		$sql="select * from gc_materia_prima_por_bache";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
}
?>