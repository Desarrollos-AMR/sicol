<?php
session_start();
extract ($_REQUEST);
require_once("../clases/clprogrecibo.php");
switch ($boton)
{
	Case "Actualizar":
			$objConexion = Conectarse();
	 		$sql="update gc_programacion_recibo set fecha_estimada = '$_REQUEST[fecha]', fecha_arribo = '$_REQUEST[fechaarribo]' where id = $_REQUEST[Id] ";
			$resultado = mysqli_query($objConexion,$sql) or die('MySql Error' . mysqli_error());
			
			if ($resultado) {
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/programacion_data.php?x=1&modulo=recibo"); //x=1 es actualizado correctamente
			} else {
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/programacion_data.php?x=2&modulo=recibo"); //x=2 no se puede actualizar
			}
			break;
		
		
		
		Case "Agregar":
		
		
	        $consulta=new progrecibo;
						$resultado = $consulta->agregarprogrecibo( $fecha , $motonave );
			
			if ($resultado)
			{
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/programacion_data.php?x=1&modulo=recibo"); //x=1 es actualizado correctamente
			
				echo "El registro se ha agregado correctamente";
			}
			else
			print_r(error_get_last());
				echo "Problemas al Agregar Registro";

		break;



		Case "eliminar":


			$objConexion = Conectarse();
			
			$sql="delete from gc_programacion_recibo where id = '$_REQUEST[Id]'";
			
			$resultado = $objConexion->query($sql);
			
			if ($resultado)
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/programacion_data.php?x=3&modulo=recibo");  //x=3 quiere decir que se eliminó bien
			else
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/programacion_data.php?x=4&modulo=recibo");  //x=4 quiere decir que no se pudo eliminar.

		break;
}
?>