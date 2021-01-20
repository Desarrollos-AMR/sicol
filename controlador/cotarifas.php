<?php
session_start();
extract ($_REQUEST);
require_once("../clases/cltarifas.php");
switch ($boton)
{
	Case "Actualizar":
			$objConexion = Conectarse();
			 $sql="update gc_tarifas set nombre = '$_REQUEST[nombre]', proveedor = $_REQUEST[proveedor], 
			
			valor = $_REQUEST[valor], unidad = '$_REQUEST[unidad]'
			
			where id = $_REQUEST[Id] ";
			
			//$resultado=$objConexion->query($sql);
			$resultado = mysqli_query($objConexion,$sql) or die('MySql Error' . mysqli_error());
			
			if ($resultado) {
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/tarifas_data.php?x=1&modulo=ordenes"); //x=1 es actualizado correctamente
			} else {
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/tarifas_data.php?x=2&modulo=ordenes"); //x=2 no se puede actualizar
			}
			break;
		
		
		
		Case "Agregar":
		
		
	        $consulta=new tarifa;
						$resultado = $consulta->agregartarifas( $nombre , $proveedor , $valor , $unidad  );
			
			if ($resultado)
			{
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/tarifas_data.php?x=1&modulo=ordenes"); //x=1 es actualizado correctamente
			
				echo "La tarifa se ha agregado correctamente";
			}
			else
				echo "Problemas al Agregar Tarifas";

		break;



		Case "eliminar":


			$objConexion = Conectarse();
			
			$sql="delete from gc_tarifas where id = '$_REQUEST[Id]'";
			
			$resultado = $objConexion->query($sql);
			
			if ($resultado)
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/tarifas_data.php?x=3&modulo=ordenes");  //x=3 quiere decir que se eliminó bien
			else
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/tarifas_data.php?x=4&modulo=ordenes");  //x=4 quiere decir que no se pudo eliminar.

		break;
}
?>