<?php
session_start();
extract ($_REQUEST);
require_once("../clases/clentradas.php");
switch ($boton)
{
	Case "Actualizar":
			$objConexion = Conectarse();
			 $sql="update gc_recibo_inventario set fecha = '$_REQUEST[fecha]',tiquete = '$_REQUEST[tiquete]', producto = '$_REQUEST[producto]', cantidad_tm = '$_REQUEST[cantidadtm]', cantidad_sacos = '$_REQUEST[cantidadsacos]', cliente = '$_REQUEST[cliente]', orden = '$_REQUEST[orden]', bodega = '$_REQUEST[bodega]', lote = '$_REQUEST[lote]' where id = $_REQUEST[Id] ";
			
			//$resultado=$objConexion->query($sql);
			$resultado = mysqli_query($objConexion,$sql) or die('No se pudo actualizar' . mysqli_error());
			
			if ($resultado) {
                header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/entradas_data.php?x=1&modulo=entradas"); //x=1 es actualizado correctamente
			} else {
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/entradas_data.php?x=2&modulo=entradas"); //x=2 no se puede actualizar
			}
			break;
		
		
		
		Case "Agregar":
			$objConexion = Conectarse();

			$vsi="select * from gc_saldos_iniciales where producto=" . $producto . " and cliente=" . $cliente . " and bodega=" . $bodega;
			$rvsi=mysqli_query($objConexion,$vsi) or die('MySql Error2' . mysql_error());
			$tvsi=mysqli_num_rows($rvsi);
			if ($tvsi!=0){
				 echo "<script language='JavaScript'>
    				var continuar;
				    var pregunta = confirm('Ya hay existencias de este producto en la bodega digitada, Desea Continuar?');
    				if (!pregunta)
   					{
        				continuar = 0;
        				window.location='pagina.php';
    				}
    				else 
   					{
      					continuar = 1;
    				}
				</script>";
			}
		
	        $consulta=new entradas;
			$resultado = $consulta->agregarentradas( $fecha, $tiquete, $cantidadtm, $cantidadsacos, $producto, $cliente, $orden, $bodega, $lote );
			
			if ($resultado)
			{
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/entradas_data.php?x=1&modulo=entradas"); //x=1 es actualizado correctamente
			
				echo "El registro se ha agregado correctamente";
			}
			else
			print_r(error_get_last());
				echo "Problemas al Agregar Registro";

		break;



		Case "eliminar":


			$objConexion = Conectarse();
			
			$sql="delete from gc_recibo_inventario where Id = '$_REQUEST[Id]'";
			
			$resultado =  mysqli_query($objConexion,$sql) or die('No se pudo actualizar' . mysqli_error());
			
			if ($resultado)
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/entradas_data.php?x=3&modulo=entradas");  //x=3 quiere decir que se eliminó bien
			else
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/entradas_data.php?x=4&modulo=entradas");  //x=4 quiere decir que no se pudo eliminar.

		break;
}
?>