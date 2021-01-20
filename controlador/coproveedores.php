<?php
session_start();
extract ($_REQUEST);
require_once("../clases/clproveedores.php");
switch ($boton)
{
	Case "Actualizar":
			$objConexion = Conectarse();
			 $sql="update gc_proveedores set razon_social = '$_REQUEST[razonsocial]', 
			
			contacto = '$_REQUEST[contacto]'
			
			where nit = $_REQUEST[Id] ";
			
			$resultado = mysqli_query($objConexion,$sql) or die('MySql Error' . mysqli_error());
			
			if ($resultado) {
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/proveedor_data.php?x=1&modulo=ordenes"); //x=1 es actualizado correctamente
			} else {
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/proveedor_data.php?x=2&modulo=ordenes"); //x=2 no se puede actualizar
			}
			break;
		
		
		Case "Agregar":
		
	        $consulta=new proveedor;
						$resultado = $consulta->agregarproveedores( $nit , $razonsocial , contacto );
			
			if ($resultado)
			{
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/proveedor_data.php?x=1&modulo=ordenes"); //x=1 es actualizado correctamente
			
				echo "El proveedor se ha agregado correctamente";
			}
			else
				echo "Problemas al Agregar proveedores";

		break;



		Case "eliminar":


			$objConexion = Conectarse();
			
			$sql="delete from gc_proveedores where nit = '$_REQUEST[Id]'";
			
			$resultado = $objConexion->query($sql);
			
			if ($resultado)
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/proveedor_data.php?x=3&modulo=ordenes");  //x=3 quiere decir que se eliminó bien
			else
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/proveedor_data.php?x=4&modulo=ordenes");  //x=4 quiere decir que no se pudo eliminar.

		break;
}
?>