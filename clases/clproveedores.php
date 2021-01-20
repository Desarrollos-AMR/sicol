<?php
/**
 * @author 
 * @version 1.0
 * @created 
 */
require_once "ConexionDatos.php";

class proveedor
{

	var $nit;
	var $razonsocial;
	var $contacto;
	var $Conexion;

	public function constructor($pnit,$prazonsocial,$pcontacto, $pConexion)
	{
		$this->$nit=$pnit;
		$this->$razonsocial=$prazonsocial;
		$this->$contacto=$pcontacto;
		$this->$Conexion=$pConexion;
	}
	
	public function agregarproveedores($pnit,$pcodigo,$pnombre)
	{	
		$this->Conexion=Conectarse();
		$sql="insert into gc_proveedores(nit,razon_social,contacto) values ('$pnit','$pcodigo','$pnombre')";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
	public function consultarproveedor()
	{
		$this->Conexion=Conectarse();
		$sql="select * from gc_proveedores";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
}
?>