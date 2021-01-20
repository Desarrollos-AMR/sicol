<?php
session_start();
extract ($_REQUEST);
require_once("../clases/clprogsellado.php");
switch ($boton)
{
	Case "Actualizar":
			$objConexion = Conectarse();
			 $sql="update gc_produccion_programacion set fecha = '$_REQUEST[fecha]', orden = '$_REQUEST[orden]', grado = '$_REQUEST[grado]', producto = '$_REQUEST[producto]', solicitante = '$_REQUEST[solicitante]', cantidad = '$_REQUEST[cantidad]', presentacion = '$_REQUEST[presentacion]' where id = $_REQUEST[Id] ";
			
			//$resultado=$objConexion->query($sql);
			$resultado = mysqli_query($objConexion,$sql) or die('MySql Error' . mysqli_error());
			
			if ($resultado) {
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/prog_sellado_data.php?x=1&modulo=empaque"); //x=1 es actualizado correctamente
			} else {
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/prog_sellado_data.php?x=2&modulo=empaque"); //x=2 no se puede actualizar
			}
			break;
		
		
		
		Case "Agregar":
		
		
	        $consulta=new progsellado;
						$resultado = $consulta->agregarprogsellado( $fecha , $orden, $grado, $producto, $solicitante, $cantidad , $presentacion );
			
			if ($resultado)
			{
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/prog_sellado_data.php?x=1&modulo=empaque"); //x=1 es actualizado correctamente
			
				echo "El registro se ha agregado correctamente";
			}
			else
			print_r(error_get_last());
				echo "Problemas al Agregar Registro";

		break;



		Case "eliminar":


			$objConexion = Conectarse();
			
			$sql="delete from gc_produccion_programacion where id = '$_REQUEST[Id]'";
			
			$resultado = $objConexion->query($sql);
			
			if ($resultado)
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/prog_sellado_data.php?x=3&modulo=empaque");  //x=3 quiere decir que se eliminó bien
			else
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/prog_sellado_data.php?x=4&modulo=empaque");  //x=4 quiere decir que no se pudo eliminar.

		break;
}
?>