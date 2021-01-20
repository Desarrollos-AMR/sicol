<?php
session_start();
extract ($_REQUEST);
require_once("../clases/clvarios.php");
switch ($boton)
{
	Case "Actualizar":
			$objConexion = Conectarse();
			 $sql="update gc_varios set fecha = '$_REQUEST[fecha]', 
			
			detalle = '$_REQUEST[detalle]'
			
			where id = $_REQUEST[Id] ";
			
			//$resultado=$objConexion->query($sql);
			$resultado = mysqli_query($objConexion,$sql) or die('MySql Error' . mysqli_error());
			
			if ($resultado) {
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/varios_data.php?x=1&modulo=varios"); //x=1 es actualizado correctamente
			} else {
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/varios_data.php?x=2&modulo=varios"); //x=2 no se puede actualizar
			}
			break;
		
		
		
		Case "Agregar":
		
	        $consulta=new varios;
			$resultado = $consulta->agregarvarios( $fecha , $detalle );
			
			if ($resultado)
			{
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/varios_data.php?x=1&modulo=varios"); //x=1 es actualizado correctamente
			
				echo "El registro se ha agregado correctamente";
			}
			else
				echo "Problemas al agregar varios";

		break;



		Case "eliminar":


			$objConexion = Conectarse();
			
			$sql="delete from gc_varios where id = '$_REQUEST[Id]'";
			
			$resultado = $objConexion->query($sql);
			
			if ($resultado)
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/varios_data.php?x=3&modulo=varios");  //x=3 quiere decir que se eliminó bien
			else
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/varios_data.php?x=4&modulo=varios");  //x=4 quiere decir que no se pudo eliminar.

		break;
}
?>