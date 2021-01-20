<?php
session_start();
extract ($_REQUEST);
require_once("../clases/clexistencias.php");
switch ($boton)
{
	Case "Actualizar":
			$objConexion = Conectarse();
			$sql="update gc_existencias set producto = '$_REQUEST[producto]', cliente = '$_REQUEST[cliente]',
			
			bodega = $_REQUEST[bodega], lote = $_REQUEST[lote], saldo = $_REQUEST[saldo], fecha = '$_REQUEST[fecha]'
			
			where id = $_REQUEST[Id] ";
			
			$resultado = mysqli_query($objConexion,$sql) or die('MySql Error' . mysqli_error());
			
			if ($resultado) {
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/existencias_data.php?x=1&modulo=inventario");
			} else {
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/existencias_data.php?x=2&modulo=inventario"); 
			}
			break;
		
		Case "Agregar":
		
	        $consulta=new existencia;
			$resultado = $consulta->agregarexistencias( $producto , $cliente, $bodega , $lote , $saldo , $fecha  );
			
			if ($resultado)
			{
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/existencias_data.php?x=1&modulo=inventario");
			
				echo "La existencia se ha actualizado correctamente";
			}
			else
				echo "Problemas al Agregar Existencias";

		break;



		Case "eliminar":


			$objConexion = Conectarse();
			
			$sql="delete from gc_existencias where id = '$_REQUEST[Id]'";
			
			$resultado = $objConexion->query($sql);
			
			if ($resultado)
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/existencias_data.php?x=3&modulo=inventario"); 
			else
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/existencias_data.php?x=4&modulo=inventario");

		break;
}
?>