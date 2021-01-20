<?php
session_start();
extract ($_REQUEST);
require_once("../clases/cldespachosvarios.php");
switch ($boton)
{
	Case "Actualizar":
			$objConexion = Conectarse();
			$sql="update gc_despachos_recibos_varios set tipo = '$_REQUEST[tipo]', fecha = '$_REQUEST[fecha]', tiquete = '$_REQUEST[tiquete]', concepto = '$_REQUEST[concepto]', placas = '$_REQUEST[placas]', cantidad = '$_REQUEST[cantidad]', unidad = '$_REQUEST[unidad]', observacion = '$_REQUEST[observacion]' where Id = '$_REQUEST[Id]' ";
			
			$resultado = mysqli_query($objConexion,$sql) or die('MySql Error' . mysqli_error());
			
			if ($resultado) {
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/despachos_varios_data.php?x=1&modulo=despachos"); //x=1 es actualizado correctamente
			} else {
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/despachos_varios_data.php?x=2&modulo=despachos"); //x=2 no se puede actualizar
			}
			break;
		
		
		
		Case "Agregar":
		
		
	        $consulta=new despachos;
						$resultado = $consulta->agregardespachos( $tipo, $fecha , $tiquete, $concepto, $placas, $cantidad, $unidad, $observacion );
			
			if ($resultado)
			{
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/despachos_varios_data.php?x=1&modulo=despachos"); //x=1 es actualizado correctamente
			
				echo "El registro se ha agregado correctamente";
			}
			else
			print_r(error_get_last());
				echo "Problemas al Agregar Registro";

		break;



		Case "eliminar":


			$objConexion = Conectarse();
			
			$sql="delete from gc_despachos_recibos_varios where Id = '$_REQUEST[Id]'";
			
			$resultado = $objConexion->query($sql);
			
			if ($resultado)
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/despachos_varios_data.php?x=3&modulo=despachos");  //x=3 quiere decir que se eliminó bien
			else
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/despachos_varios_data.php?x=4&modulo=despachos");  //x=4 quiere decir que no se pudo eliminar.

		break;
}
?>