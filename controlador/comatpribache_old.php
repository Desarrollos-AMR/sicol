<?php
session_start();
extract ($_REQUEST);
require_once("../clases/clmatpribache.php");
$progid = $_REQUEST['progid'];
$objConexion = Conectarse();
$totalbache = "select sum(cantidad) as total from gc_materia_prima_por_bache where orden=" . $progid;
$rstotalbache = mysqli_query($objConexion,$totalbache) or die('MySql Error' . mysqli_error());
$acumulado = $rstotalbache->fetch_array();
switch ($boton)
{
	Case "Actualizar":
			$cantan = "select cantidad from gc_materia_prima_por_bache where id=" . $_REQUEST[Id];
			$cantant = mysqli_query($objConexion,$cantan) or die('MySql Error' . mysqli_error());
			$canac = $cantant->fetch_array();
			if ($acumulado['total'] - $canac['cantidad'] + $_REQUEST['cantidad'] > 5000) {
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/materia_prima_orden_data.php?modulo=produccion&Id=$progid&x=9&idprog=$_REQUEST[idprog]"); 
			} else {
				$objConexion = Conectarse();
				$sql="update gc_materia_prima_por_bache set producto = '$_REQUEST[producto]', cantidad = '$_REQUEST[cantidad]' where id = $_REQUEST[Id] ";
				$resultado = mysqli_query($objConexion,$sql) or die('MySql Error' . mysqli_error());
				
				if ($resultado) {
					header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/materia_prima_orden_data.php?x=1&modulo=produccion&Id=$progid&idprog=$_REQUEST[idprog]"); //x=1 es actualizado correctamente
				} else {
					header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/materia_prima_orden_data.php?x=2&modulo=produccion&Id=$progid&idprog=$_REQUEST[idprog]"); //x=2 no se puede actualizar
				}
			}
			break;
		
		
		
		Case "Agregar":
			$campos = "";
			foreach($_POST as $nombre_campo => $valor){ 
				if (substr($nombre_campo,0,3)=="matpri"){
			   		$nombre_campo = "\$" . $nombre_campo . ";"; 
			   		$valor = "\$" . $valor . ";"; 
					$consulta=new matpribache;
					$resultado = $consulta->agregarmatpribache( $progid , $bache, eval($nombre_campo) , eval($valor) );
				}
			}
			header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador5.php?x=1&modulo=produccion&progid=$progid"); //x=1 es actualizado correctamente
			break;



		Case "eliminar":


			$objConexion = Conectarse();
			
			$sql="delete from gc_materia_prima_por_bache where id = '$_REQUEST[Id]'";
			
			$resultado = $objConexion->query($sql);
			
			if ($resultado)
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/materia_prima_orden_data.php?x=3&modulo=produccion&Id=$progid");  //x=3 quiere decir que se eliminó bien
			else
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/materia_prima_orden_data.php?x=4&modulo=produccion&Id=$progid");  //x=4 quiere decir que no se pudo eliminar.

		break;
}
?>