<?php
session_start();
extract ($_REQUEST);
require_once("../clases/clemprecibo.php");
switch ($boton)
{
	Case "Actualizar":
			$objConexion = Conectarse();
			 $sql="update gc_emp_recibo set fecha = '$_REQUEST[fecha]', bodega = '$_REQUEST[bodega]', grado = '$_REQUEST[grado]', origen = '$_REQUEST[origen]', observacion = '$_REQUEST[observacion]', cantidad = '$_REQUEST[cantidad]' where id = $_REQUEST[Id] ";
			
			//$resultado=$objConexion->query($sql);
			$resultado = mysqli_query($objConexion,$sql) or die('MySql Error' . mysqli_error());
			
			if ($resultado) {
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/emp_entradas_data.php?x=1&modulo=empaque"); //x=1 es actualizado correctamente
			} else {
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/emp_entradas_data.php?x=2&modulo=empaque"); //x=2 no se puede actualizar
			}
			break;
		
		
		
		Case "Agregar":
		
		
	        $consulta=new emprecibo;
						$resultado = $consulta->agregaremprecibo( $fecha , $bodega, $grado, $origen, $observacion, $cantidad  );
			
			if ($resultado)
			{
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/emp_entradas_data.php?x=1&modulo=empaque"); //x=1 es actualizado correctamente
			
				echo "El registro se ha agregado correctamente";
			}
			else
			print_r(error_get_last());
				echo "Problemas al Agregar Registro";

		break;



		Case "eliminar":


			$objConexion = Conectarse();
			
			$sql="delete from gc_emp_recibo where id = '$_REQUEST[Id]'";
			
			$resultado = $objConexion->query($sql);
			
			if ($resultado)
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/emp_entradas_data.php?x=3&modulo=empaque");  //x=3 quiere decir que se eliminó bien
			else
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/emp_entradas_data.php?x=4&modulo=empaque");  //x=4 quiere decir que no se pudo eliminar.

		break;
}
?>