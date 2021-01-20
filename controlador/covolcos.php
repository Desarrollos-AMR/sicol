<?php
session_start();
extract ($_REQUEST);
require_once("../clases/clvolcos.php");
switch ($boton)
{
	Case "Actualizar":
			$objConexion = Conectarse();
			 $sql="update gc_recibo_buques_contenedores set fecha = '$_REQUEST[fecha]', producto = '$_REQUEST[producto]', presentacion = '$_REQUEST[presentacion]', bodega = '$_REQUEST[bodega]', tiquete = '$_REQUEST[tiquete]', placas = '$_REQUEST[placas]', peso_origen = '$_REQUEST[porigen]', peso_bascula = '$_REQUEST[pbascula]' where id = $_REQUEST[Id] ";
			
			//$resultado=$objConexion->query($sql);
			$resultado = mysqli_query($objConexion,$sql) or die('MySql Error' . mysqli_error());
			
			if ($resultado) {
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/volcos_contenedores_data.php?x=1&modulo=recibo&Id=$progid"); //x=1 es actualizado correctamente
			} else {
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/volcos_contenedores_data.php?x=2&modulo=recibo&Id=$progid"); //x=2 no se puede actualizar
			}
			break;
		
		
		
		Case "Agregar":
		
		
	        $consulta=new volcos;
						$resultado = $consulta->agregarvolcos( $fecha , $progid, $producto, $presentacion, $bodega, $tiquete, $placas, $porigen, $pbascula );
			
			if ($resultado)
			{
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/volcos_contenedores_data.php?x=1&modulo=recibo&Id=$progid"); //x=1 es actualizado correctamente
			
				echo "El registro se ha agregado correctamente";
			}
			else
			print_r(error_get_last());
				echo "Problemas al Agregar Registro";

		break;



		Case "eliminar":


			$objConexion = Conectarse();
			
			$sql="delete from gc_recibo_buques_contenedores where id = '$_REQUEST[Id]'";
			
			$resultado = $objConexion->query($sql);
			
			if ($resultado)
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/volcos_contenedores_data.php?x=3&modulo=recibo&Id=$progid");  //x=3 quiere decir que se eliminó bien
			else
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/volcos_contenedores_data.php?x=4&modulo=recibo&Id=$progid");  //x=4 quiere decir que no se pudo eliminar.

		break;
}
?>