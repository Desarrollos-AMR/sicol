<?php
extract ($_REQUEST);
$destino = "../Plantilla/vistaPrincipal.php?pg=../vistas/paginador2.php&lista=../vistas/ordenes_detalle_data.php?x=1&modulo=ordenes";
require_once("../clases/clordenesdetalle.php");
$prove = $_REQUEST['proveedor'];
switch ($boton)
{
	Case "Actualizar":
			$objConexion = Conectarse();
			 $sql="update gc_ordenes_detalle set tarifa = '$_REQUEST[tarifa]', cantidad = '$_REQUEST[cantidad]', operacion = '$_REQUEST[operacion]', detalle = '$_REQUEST[detalle]' where id = $_REQUEST[Id] ";
			
			//$resultado=$objConexion->query($sql);
			$resultado = mysqli_query($objConexion,$sql) or die('MySql Error' . mysqli_error());
			
			if ($resultado) {
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador2.php&lista=../vistas/ordenes_detalle_data.php?x=1&modulo=ordenes"); //x=1 es actualizado correctamente
			} else {
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador2.php&lista=../vistas/ordenes_detalle_data.php?x=2&modulo=ordenes"); //x=2 no se puede actualizar
			}
			break;
		
		
		
		Case "Agregar":
		
		
	        $consulta=new ordenesdetalle;
						$resultado = $consulta->agregarordenesdetalle( $orden, $tarifa , $cantidad , $operacion, $detalle );
			
			if ($resultado)
			{
				header ("location:../Plantilla/vistaPrincipal.php?pg=../vistas/paginador2.php&lista=../vistas/ordenes_detalle_data.php?x=1&proveedor=$prove&modulo=ordenes"); //x=1 es actualizado correctamente
			
				echo "El registro se ha agregado correctamente";
			}
			else
			print_r(error_get_last());
				echo "Problemas al Agregar Registro";

		break;



		Case "eliminar":


			$objConexion = Conectarse();
			
			$sql="delete from gc_ordenes_detalle where id = '$_REQUEST[Id]'";
			
			$resultado = $objConexion->query($sql);
			
			if ($resultado)
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador2.php&lista=../vistas/ordenes_detalle_data.php?x=3&modulo=ordenes");  //x=3 quiere decir que se eliminó bien
			else
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador2.php&lista=../vistas/ordenes_detalle_data.php?x=4&modulo=ordenes");  //x=4 quiere decir que no se pudo eliminar.

		break;
}
?>