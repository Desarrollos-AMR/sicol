<?php
session_start();
extract ($_REQUEST);
$cuenta = count($_REQUEST);
$tags = array_keys($_REQUEST); // obtiene los nombres de las variables
$valores = array_values($_REQUEST);// obtiene los valores de las variables
$lisva="";
for($i=0;$i<$cuenta;$i++){ 
	$lisva .= $tags[$i] . "=";
	$lisva .= $valores[$i] . ","; 
}
$usuario=$_SESSION['userid'];
require_once("../clases/clproductos.php");
switch ($boton)
{
	Case "Actualizar":
			$objConexion = Conectarse();
			$sql="update gc_productos set nombre = '$_REQUEST[nombre]', 
			codigo = $_REQUEST[codigo], presentacion = $_REQUEST[presentacion], cliente = $_REQUEST[cliente]
			where productosId = $_REQUEST[Id] ";
			$resultado = mysqli_query($objConexion,$sql) or die('MySql Error' . mysqli_error($objConexion));
			if ($resultado) {
				$rac="insert into gc_usuario_actividad(usuario,accion,contenido) values ('$usuario','$boton','$lisva')";
				$rrac=mysqli_query($objConexion,$rac) or die("Error insertando log" . mysqli_error($objConexion));	
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/productos_data1.php?x=1&modulo=empaque"); //x=1 es actualizado correctamente
			} else {
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/productos_data1.php?x=2&modulo=empaque"); //x=2 no se puede actualizar
			}
			break;
		
		Case "Agregar":
			$objConexion=Conectarse();
	        $consulta=new producto;
			$resultado = $consulta->agregarproductos( $codigo , $nombre , $presentacion , $cliente );
			if ($resultado)
			{
				$rac="insert into gc_usuario_actividad(usuario,accion,contenido) values ('$usuario','$boton','$lisva')";
				$rrac=mysqli_query($objConexion,$rac) or die("Error insertando log" . mysqli_error($objConexion));	
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/productos_data1.php?x=1&modulo=empaque"); 
				echo "El producto se ha agregado correctamente";
			}else{
				echo "Problemas al Agregar Productos";
			}
			break;

		Case "eliminar":
			$objConexion = Conectarse();
			$sql="delete from gc_productos where productosId = '$_REQUEST[Id]'";
			$resultado = $objConexion->query($sql);
			if ($resultado){
				$rac="insert into gc_usuario_actividad(usuario,accion,contenido) values ('$usuario','$boton','$lisva')";
				$rrac=mysqli_query($objConexion,$rac) or die("Error insertando log" . mysqli_error($objConexion));	
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/productos_data1.php?x=3&modulo=empaque");  //x=3 quiere decir que se eliminó bien			
			}else{
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/productos_data1.php?x=4&modulo=empaque");  //x=4 quiere decir que no se pudo eliminar.				
			}
			break;
}
?>