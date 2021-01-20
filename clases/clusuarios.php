<?php
/**
 * @author 
 * @version 1.0
 * @created 
 */
require_once "ConexionDatos.php";

class usuario
{

	var $nit;
	var $clave;
	var $nivel;
	var $cedula;
	var $Conexion;

	public function constructor($cedula, $pnit,$pclave,$pnivel, $pConexion)
	{
		$this->$cedula=$pcedula;
		$this->$nit=$pnit;
		$this->$clave=$pclave;
		$this->$nivel=$pnivel;
		$this->$Conexion=$pConexion;
	}
	
	public function agregarusuarios($pcedula,$pnit,$pclave,$pnivel)
	{	
		$this->Conexion=Conectarse();
		$sql="insert into gc_usuarios(usuid,usuLogin,usuPassword,usuNivel) values ('$pcedula','$pnit','$pclave','$pnivel')";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
	public function consultarconductor()
	{
		$this->Conexion=Conectarse();
		$sql="select * from gc_usuarios";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
}
?>