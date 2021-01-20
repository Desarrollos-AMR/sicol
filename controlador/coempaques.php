<?php
session_start();
extract ($_REQUEST);
require_once("../clases/clempaques.php");
switch ($boton)
{
	Case "Actualizar":
			$objConexion = Conectarse();
			 $sql="update gc_empaques set nombre = '$_REQUEST[nombre]', 
			
			codigo = $_REQUEST[codigo], unidad = '$_REQUEST[unidad]'
			
			where codigo = $_REQUEST[Id] ";
			
			//$resultado=$objConexion->query($sql);
			$resultado = mysqli_query($objConexion,$sql) or die('MySql Error' . mysqli_error());
			
			if ($resultado) {
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/empaques_data.php?x=1&modulo=empaque"); //x=1 es actualizado correctamente
			} else {
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/empaques_data.php?x=2&modulo=empaque"); //x=2 no se puede actualizar
			}
			break;
		
		
		
		Case "Agregar":
		
	        $consulta=new empaque;
			$resultado = $consulta->agregarempaques( $codigo , $nombre , $unidad );
			
			if ($resultado)
			{
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/empaques_data.php?x=1&modulo=empaque"); //x=1 es actualizado correctamente
			
				echo "El empaque se ha agregado correctamente";
			}
			else
				echo "Problemas al agregar empaques";

		break;



		Case "eliminar":


			$objConexion = Conectarse();
			
			$sql="delete from gc_empaques where codigo = '$_REQUEST[Id]'";
			
			$resultado = $objConexion->query($sql);
			
			if ($resultado)
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/empaques_data.php?x=3&modulo=empaque");  //x=3 quiere decir que se eliminó bien
			else
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/empaques_data.php?x=4&modulo=empaque");  //x=4 quiere decir que no se pudo eliminar.

		break;
}
?>