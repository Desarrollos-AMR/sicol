<?php
session_start();
extract ($_REQUEST);
require_once("../clases/clordenes.php");
switch ($boton)
{
	Case "Actualizar":
			$objConexion = Conectarse();
			if ($_REQUEST['ap']==1){
			 	$sql="update gc_ordenes set aprobada = '1', fecha_aprobacion = now() where id = $_REQUEST[orden] ";
			} else {
			 	$sql="update gc_ordenes set proveedor = '$_REQUEST[proveedor]' where id = $_REQUEST[Id] ";
			}
			
			//$resultado=$objConexion->query($sql);
			$resultado = mysqli_query($objConexion,$sql) or die('MySql Error' . mysqli_error());
			
			if ($resultado) {
				if ($_REQUEST['ap']==1){
					header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/ordenes_sol_autorizacion.php&aprobada=1&orden=$_REQUEST[orden]&proveedor=$_REQUEST[proveedor]");
				} else {
					header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/ordenes_data.php?x=1&modulo=ordenes"); //x=1 es actualizado correctamente
				}
			} else {
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/ordenes_data.php?x=2&modulo=ordenes"); //x=2 no se puede actualizar
			}
			break;
		
		
		
		Case "Agregar":
		
		
	        $consulta=new ordenes;
						$resultado = $consulta->agregarordenes( $fecha , $proveedor );
			
			if ($resultado)
			{
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/ordenes_data.php?x=1&modulo=ordenes"); //x=1 es actualizado correctamente
			
				echo "El registro se ha agregado correctamente";
			}
			else
			print_r(error_get_last());
				echo "Problemas al Agregar Registro";

		break;



		Case "eliminar":


			$objConexion = Conectarse();
			
			$sql="delete from gc_ordenes where id = '$_REQUEST[Id]'";
			
			$resultado = $objConexion->query($sql);
			
			if ($resultado)
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/ordenes_data.php?x=3&modulo=ordenes");  //x=3 quiere decir que se eliminó bien
			else
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/ordenes_data.php?x=4&modulo=ordenes");  //x=4 quiere decir que no se pudo eliminar.

		break;
}
?>