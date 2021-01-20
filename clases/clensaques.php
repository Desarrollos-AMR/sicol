<?php
/**
 * @author 
 * @version 1.0
 * @created 
 */
 
require_once "ConexionDatos.php";

class ensaques
{
	var $newid;
	var $fecha;
	var $granel;
	var $producto;
	var $cantidadtm;
	var $cantidadsacos;
	var $bodega;
	var $lote;
	var $bodegag;
	var $loteg;
	var $clipro;
	var $motonave;
	var $Conexion;

	public function constructor($pnewid, $pfecha, $pgranel, $pproducto, $pcantidadtm, $pcantidadsacos, $pbodega, $plote, $pbodegag, $ploteg, $pclipro, $pmotonave, $pConexion)
	{
		$this->$newid=$pnewid;
		$this->$fecha=$pfecha;
		$this->$granel=$pgranel;
		$this->$producto=$pproducto;
		$this->$cantidadtm=$pcantidadtm;
		$this->$cantidadsacos=$pcantidadsacos;
		$this->$bodega=$pbodega;
		$this->$lote=$plote;
		$this->$bodegag=$pbodegag;
		$this->$loteg=$ploteg;
		$this->$clipro=$pclipro;
		$this->$motonave=$pmotonave;
		$this->$Conexion=$pConexion;
	}
	
	public function agregarensaques($pnewid, $pfecha, $pgranel, $pproducto, $pcantidadtm, $pcantidadsacos, $pbodega, $plote, $pbodegag, $ploteg, $pclipro, $pmotonave)
	{	
		$objConexion=Conectarse();
		$sql="insert into gc_ensaque(consecutivo, fecha, granel, producto, cantidad_tm, cantidad_sacos, bodega, lote, bodega_granel, lote_granel, cliente, motonave) values ('$pnewid', '$pfecha', '$pgranel', '$pproducto', '$pcantidadtm', '$pcantidadsacos', '$pbodega', '$plote', '$pbodegag', '$ploteg', '$pclipro', '$pmotonave')";
		$resultado = mysqli_query($objConexion,$sql) or die('MySql Error show' . mysql_error($objConexion));
		return $resultado;	
	}
	
	public function consultarproducto()
	{
		$this->Conexion=Conectarse();
		$sql="select * from gc_ensaque";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
}
?>