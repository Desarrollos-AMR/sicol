<?php
/**
 * @author 
 * @version 1.0
 * @created 
 */
require_once "ConexionDatos.php";

class existencia
{

	var $producto;
	var $cliente;
    var $bodega;
    var $lote;
    var $saldo;
    var $fecha;
	var $Conexion;

	public function constructor($pproducto,$pcliente,$pbodega,$plote,$psaldo,$pfecha, $pConexion)
	{
		$this->$producto=$pproducto;
		$this->$cliente=$pcliente;
        $this->$bodega=$pbodega;
        $this->$lote=$plote;
        $this->$saldo=$psaldo;
        $this->$fecha=$pfecha;
		$this->$Conexion=$pConexion;
	}
	
	public function agregarexistencias($pproducto,$pcliente,$pbodega,$plote,$psaldo,$pfecha)
	{	
		$this->Conexion=Conectarse();
		$sql="insert into gc_existencias(producto,cliente,bodega,lote,saldo,fecha) values ('$pproducto','$pcliente','$pbodega','$plote','$psaldo','$pfecha')";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
	public function consultarproducto()
	{
		$this->Conexion=Conectarse();
		$sql="select * from gc_existencias";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
}
?>