<?php
session_start();
extract ($_REQUEST);
require_once("../clases/clactas.php");
switch ($boton)
{
	Case "Actualizar":
			$objConexion = Conectarse();
	 		$sql="update gc_produccion set fecha = '$_REQUEST[fecha]', acta = '$_REQUEST[acta]', producto = '$_REQUEST[producto]', cantidad = '$_REQUEST[cantidad]' where id = $_REQUEST[Id] ";
			//$resultado=$objConexion->query($sql);
			$resultado = mysqli_query($objConexion,$sql) or die('MySql Error' . mysqli_error());
			
			if ($resultado) {
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/actas_data.php&x=1"); //x=1 es actualizado correctamente
			} else {
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/actas_data.php&x=2"); //x=2 no se puede actualizar
			}
			break;
		
		
		
		Case "Agregar":
		
		
	        $consulta=new actas;
						$resultado = $consulta->agregaractas( $fecha , $acta , $producto , $cantidad );
			
			if ($resultado)
			{
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/actas_data.php&x=1"); //x=1 es actualizado correctamente
			
				echo "El registro se ha agregado correctamente";
			}
			else
			print_r(error_get_last());
				echo "Problemas al Agregar Registro";

		break;



		Case "eliminar":


			$objConexion = Conectarse();
			
			$sql="delete from gc_produccion where id = '$_REQUEST[Id]'";
			
			$resultado = $objConexion->query($sql);
			
			if ($resultado)
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/actas_data.php&x=3");  //x=3 quiere decir que se eliminó bien
			else
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/actas_data.php&x=4");  //x=4 quiere decir que no se pudo eliminar.

		break;
}
?>