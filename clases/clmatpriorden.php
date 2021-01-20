<?php
/**
 * @author 
 * @version 1.0
 * @created 
 */
 
require_once "ConexionDatos.php";

class matpriorden
{
	var $idprog;
	var $progid;
	var $producto;
	var $cantidad;
	var $puesto;
	var $Conexion;

	public function constructor($pidprog, $pprogid, $pproducto , $pcantidad , $ppuesto , $pConexion)
	{
		$this->$idprog=$pidprog;
		$this->$progid=$pprogid;
		$this->$producto=$pprodcuto;
		$this->$cantidad=$pcantidad;
		$this->$puesto=$ppuesto;
		$this->$Conexion=$pConexion;
	}
	
	public function agregarmatpriorden($pidprog, $pprogid, $pproducto , $pcantidad , $ppuesto)
	{	
		$this->Conexion=Conectarse();
		$sql="insert into gc_materia_prima_por_orden(programacionid, orden, producto, cantidad, puesto) values ('$pidprog', '$pprogid', '$pproducto', '$pcantidad', '$ppuesto')";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
	public function consultarorden()
	{
		$this->Conexion=Conectarse();
		$sql="select * from gc_materia_prima_por_orden";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
}
?>