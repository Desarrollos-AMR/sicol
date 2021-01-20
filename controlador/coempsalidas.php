<?php
session_start();
extract ($_REQUEST);
require_once("../clases/clempsalidas.php");
switch ($boton)
{
	Case "Actualizar":
			$objConexion = Conectarse();
			 $sql="update gc_emp_despacho set fecha = '$_REQUEST[fecha]', turno = '$_REQUEST[turno]', bodega = '$_REQUEST[bodega]', grado = '$_REQUEST[grado]', cantidad = '$_REQUEST[cantidad]', motivo = '$_REQUEST[motivo]', operacion = '$_REQUEST[operacion]', orden = '$_REQUEST[orden]', producto = '$_REQUEST[producto]', autoriza = '$_REQUEST[autoriza]', recibe = '$_REQUEST[recibe]', observacion = '$_REQUEST[observacion]' where id = $_REQUEST[Id] ";
			
			//$resultado=$objConexion->query($sql);
			$resultado = mysqli_query($objConexion,$sql) or die('MySql Error' . mysqli_error());
			
			if ($resultado) {
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/emp_salidas_data.php&modulo=empaque&x=1"); //x=1 es actualizado correctamente
			} else {
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/emp_salidas_data.php&modulo=empaque&x=2"); //x=2 no se puede actualizar
			}
			break;
		
		
		
		Case "Agregar":
		
		
	        $consulta=new empdespacho;
						$resultado = $consulta->agregarempdespacho( $fecha , $turno, $bodega, $grado, $cantidad, $motivo, $operacion, $orden, $producto, $autoriza, $recibe, $observacion );
			
			if ($resultado)
			{
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/emp_salidas_data.php&modulo=empaque&x=1"); //x=1 es actualizado correctamente
			
				echo "El registro se ha agregado correctamente";
			}
			else
			print_r(error_get_last());
				echo "Problemas al Agregar Registro";

		break;



		Case "eliminar":


			$objConexion = Conectarse();
			
			$sql="delete from gc_emp_despacho where id = '$_REQUEST[Id]'";
			
			$resultado = $objConexion->query($sql);
			
			if ($resultado)
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/emp_salidas_data.php&modulo=empaque&x=3");  //x=3 quiere decir que se eliminó bien
			else
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/emp_salidas_data.php&modulo=empaque&x=4");  //x=4 quiere decir que no se pudo eliminar.

		break;
}
?>