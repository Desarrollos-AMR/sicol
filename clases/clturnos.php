<?php
/**
 * @author 
 * @version 1.0
 * @created 
 */
require_once "ConexionDatos.php";

class turnos
{
	var $fecha;
	var $hinicio;
	var $hfinal;
	var $placas;
    var $conductor;
	var $tipomov;
	var $orden;
    var $pesocarga;
    var $productos;
    var $cliente;
	var $turno;
	var $bodega;
	var $Conexion;

	public function constructor($pfecha , $phinicio , $phfinal , $pplacas , $pconductor , $ptipomov, $porden , $ppesocarga , $pproductos , $pcliente, $pturno , $pbodega )
	{
		$this->$fecha=$pfecha;
		$this->$hinicio=$phinicio;
		$this->$hfinal=$phfinal;
		$this->$placas=$pplacas;
        $this->$conductor=$pconductor;
		$this->$tipomov=$ptipomov;
		$this->$orden=$porden;
        $this->$pesocarga=$ppesocarga;
        $this->$remision=$pproductos;
        $this->$cliente=$pcliente;
		$this->$turno=$pturno;
		$this->$bodega=$pbodega;
		$this->$Conexion=$pConexion;
	}
	
	public function agregarturnos($pfecha , $phinicio , $phfinal , $pplacas , $pconductor , $ptipomov, $porden , $ppesocarga , $pproductos , $pcliente, $pturno , $pbodega )
	{	
		$objConexion=Conectarse();
		$sql="insert into gc_turnos(fecha, hora_registro, hora_atencion, placas, conductor, clase_movimiento, orden, peso_carga, productos, cliente, turno, bodega) values ('$pfecha' , '$phinicio' , '$phfinal' , '$pplacas' , '$pconductor' , '$ptipomov' , '$porden' , '$ppesocarga' , '$pproductos', '$pcliente', '$pturno', '$pbodega')";
		$resultado=mysqli_query($objConexion,$sql) or die('Error:' . mysqli_error($objConexion));
		return $resultado;	
	}
	
	public function consultardespacho()
	{
		$this->Conexion=Conectarse();
		$sql="select * from gc_turnos";
		$resultado=$this->Conexion->query($sql);
		$this->Conexion->close();
		return $resultado;	
	}
	
}
?>