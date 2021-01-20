<?php
/**
 * @author 
 * @version 1.0
 * @created 
 */
require_once "ConexionDatos.php";

class transportadores
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
	
	public function agregartransportadores($pnit,$prazonsocial,$pcontacto)
	{	
		$this->Conexion=Conectarse();
		$sql="insert into gc_transportadores(nit,razon_social,contacto) values ('$pnit','$prazonsocial','$pcontacto')";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
	public function consultartransportador()
	{
		$this->Conexion=Conectarse();
		$sql="select * from gc_transportadores";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
}
?>