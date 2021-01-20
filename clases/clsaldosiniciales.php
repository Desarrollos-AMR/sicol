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
    var $bodega;
    var $lote;
    var $saldok;
    var $saldos;
    var $fecha;
    
	var $Conexion;

	public function constructor($pproducto,$pcliente,$pbodega,$plote,$psaldok,$psaldos,$pfecha, $pConexion)
	{
		$this->$producto=$pproducto;
        $this->$bodega=$pbodega;
        $this->$lote=$plote;
        $this->$saldok=$psaldok;
        $this->$saldos=$psaldos;
        $this->$fecha=$pfecha;
		$this->$Conexion=$pConexion;
	}
	
	public function agregarexistencias($pproducto,$pbodega,$plote,$psaldok,$psaldos,$pfecha)
	{	
		$this->Conexion=Conectarse();
		$sql="insert into gc_saldos_iniciales(producto,bodega,lote,saldo_inicial,saldo_inicial_sacos,fecha) values ('$pproducto','$pbodega','$plote','$psaldok','$psaldos','$pfecha')";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
	public function consultarproducto()
	{
		$this->Conexion=Conectarse();
		$sql="select * from gc_saldos_iniciales";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
}
?>