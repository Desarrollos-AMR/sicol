<?php
/**
 * @author 
 * @version 1.0
 * @created 
 */
 

require_once "ConexionDatos.php";

class despachos
{

	var $fecha;
	var $hinicio;
	var $hfinal;
	var $tipo;
	var $clamo;
	var $tiquete;
	var $observacion;
	var $orden;
	var $placas;
    var $pesocarga;
    var $remision;
    var $transportador;
    var $conductor;
    var $destino;
    var $cliente;
    var $turno;
	var $Conexion;

	public function constructor($pfecha , $phinicio , $phfinal , $ptipo, $pclamo, $ptiquete, $pobservacion, $porden, $pplacas, $ppesocarga, $premision, $ptransportador, $pconductor, $pdestino, $pcliente, $pturno, $pConexion)
	{
		$this->$fecha=$pfecha;
		$this->$hinicio=$phinicio;
		$this->$hfinal=$phfinal;
		$this->$tipo=$ptipo;
		$this->$clamo=$pclamo;
		$this->$tiquete=$ptiquete;
		$this->$observacion=$pobservacion;
		$this->$orden=$porden;
		$this->$placas=$pplacas;
        $this->$pesocarga=$ppesocarga;
        $this->$remision=$premision;
        $this->$transportador=$ptransportador;
        $this->$conductor=$pconductor;
        $this->$destino=$pdestino;
        $this->$cliente=$pcliente;
        $this->$turno=$pturno;
		$this->$Conexion=$pConexion;
	}
	
	public function agregardespachos($pfecha , $phinicio , $phfinal , $ptipo, $pclamo, $ptiquete, $pobservacion, $porden, $pplacas, $ppesocarga, $premision, $ptransportador, $pconductor, $pdestino, $pcliente, $pturno)
	{	
		$objConexion=Conectarse();
		$sql="insert into gc_despachos(fecha, hora_inicio, hora_final,  tipo, clase_movimiento, tiquete, observacion, orden,placas,peso_carga,remision,transportador,conductor,destino,cliente_destino,turno) values ('$pfecha' , '$phinicio' , '$phfinal' , '$ptipo', '$pclamo', '$ptiquete', '$pobservacion', '$porden',  '$pplacas', '$ppesocarga', '$premision', '$ptransportador', '$pconductor', '$pdestino', '$pcliente', '$pturno')";
		$resultado=mysqli_query($objConexion,$sql) or die('Error:' . mysqli_error($objConexion));
		return $resultado;	
	}
	
	public function consultardespacho()
	{
		$this->Conexion=Conectarse();
		$sql="select * from gc_despachos";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
}
?>