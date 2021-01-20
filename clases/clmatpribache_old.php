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
	var $nombre_campo;
	var $valor;
	var $Conexion;

	public function constructor($pprogid, $pbache , $pnombre_campo , $pvalor , $pConexion)
	{
		$this->$progid=$pprogid;
		$this->$bache=$pbache;
		$this->$nombre_campo=$pnombre_campo;
		$this->$valor=$pvalor;
		$this->$Conexion=$pConexion;
	}
	
	public function agregarmatpribache($pprogid, $pbache , $pnombre_campo , $pvalor )
	{	
		$this->Conexion=Conectarse();
		$sql="insert into gc_materia_prima_por_bache(orden, numero_de_bache, materia_prima, cantidad) values ('$pprogid', '$pbache', '$pnombre_campo', '$pvalor')";
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