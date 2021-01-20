<?php
session_start();
extract ($_REQUEST);
require_once("../clases/clmatpriorden.php");
$progid = $_REQUEST['progid'];
$objConexion = Conectarse();
$totalbache = "select sum(cantidad) as total from gc_materia_prima_por_orden where orden=" . $progid;
$rstotalbache = mysqli_query($objConexion,$totalbache) or die('MySql Error' . mysqli_error());
$acumulado = $rstotalbache->fetch_array();
switch ($boton)
{
	Case "Actualizar":
			$cantan = "select cantidad from gc_materia_prima_por_orden where id=" . $_REQUEST[Id];
			$cantant = mysqli_query($objConexion,$cantan) or die('MySql Error' . mysqli_error());
			$canac = $cantant->fetch_array();
			if ($acumulado['total'] - $canac['cantidad'] + $_REQUEST['cantidad'] > 5000) {
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/materia_prima_orden_data.php?modulo=produccion&Id=$progid&x=9&idprog=$_REQUEST[idprog]"); 
			} else {
				$objConexion = Conectarse();
				$sql="update gc_materia_prima_por_orden set producto = '$_REQUEST[producto]', cantidad = '$_REQUEST[cantidad]' where id = $_REQUEST[Id] ";
				$resultado = mysqli_query($objConexion,$sql) or die('MySql Error' . mysqli_error());
				
				if ($resultado) {
					header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/materia_prima_orden_data.php?x=1&modulo=produccion&Id=$progid&idprog=$_REQUEST[idprog]"); //x=1 es actualizado correctamente
				} else {
					header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/materia_prima_orden_data.php?x=2&modulo=produccion&Id=$progid&idprog=$_REQUEST[idprog]"); //x=2 no se puede actualizar
				}
			}
			break;
		
		
		
		Case "Agregar":
			if ($acumulado['total'] + $_REQUEST['cantidad'] > 5000) {
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/materia_prima_orden_data.php?modulo=produccion&Id=$progid&x=9"); //x=1 es actualizado correctamente
			} else {
				$consulta=new matpriorden;
							$resultado = $consulta->agregarmatpriorden( $idprog , $progid , $producto , $cantidad, $puesto );
				
				if ($resultado)
				{
					header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/materia_prima_orden_data.php?x=1&modulo=produccion&Id=$progid&idprog=$_REQUEST[idprog]"); //x=1 es actualizado correctamente
				
					echo "El registro se ha agregado correctamente";
				}
				else
				print_r(error_get_last());
					echo "Problemas al Agregar Registro";
			}
			break;



		Case "eliminar":


			$objConexion = Conectarse();
			
			$sql="delete from gc_materia_prima_por_orden where id = '$_REQUEST[Id]'";
			
			$resultado = $objConexion->query($sql);
			
			if ($resultado)
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/materia_prima_orden_data.php?x=3&modulo=produccion&Id=$progid");  //x=3 quiere decir que se eliminó bien
			else
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/materia_prima_orden_data.php?x=4&modulo=produccion&Id=$progid");  //x=4 quiere decir que no se pudo eliminar.

		break;
}
?>