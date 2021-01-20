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
require_once("../clases/clconsecutivos.php");
switch ($boton)
{
	Case "Actualizar":
			$objConexion = Conectarse();
			$sql="update gc_consecutivos set consecutivo = '$_REQUEST[razonsocial]'
			where id = $_REQUEST[Id] ";
			$resultado = mysqli_query($objConexion,$sql) or die('MySql Error' . mysqli_error());
			
			if ($resultado) {
				$rac="insert into gc_usuario_actividad(usuario,accion,contenido) values ('$usuario','$boton','$lisva')";
				$rrac=mysqli_query($objConexion,$rac) or die("Error insertando log" . mysqli_error($objConexion));	
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/consecutivos_data.php?x=1&modulo=maestros"); //x=1 es actualizado correctamente
			} else {
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/consecutivos_data.php?x=2&modulo=maestros"); //x=2 no se puede actualizar
			}
			break;
		
		
		Case "Agregar":
			$objConexion=Conectarse();
	        $consulta=new consecutivo;
			$resultado = $consulta->agregarconsecutivos( $nit , $razonsocial );
			
			if ($resultado)	{
				$rac="insert into gc_usuario_actividad(usuario,accion,contenido) values ('$usuario','$boton','$lisva')";
				$rrac=mysqli_query($objConexion,$rac) or die("Error insertando log" . mysqli_error($objConexion));	
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/consecutivos_data.php?x=1&modulo=maestros"); //x=1 es actualizado correctamente
				echo "El consecutivo se ha agregado correctamente";
			}else{
				echo "Problemas al agregar consecutivo";
			}
			break;

		Case "eliminar":
			$objConexion = Conectarse();
			$sql="delete from gc_consecutivos where id = '$_REQUEST[Id]'";
			$resultado = $objConexion->query($sql);
			if ($resultado){
				$rac="insert into gc_usuario_actividad(usuario,accion,contenido) values ('$usuario','$boton','$lisva')";
				$rrac=mysqli_query($objConexion,$rac) or die("Error insertando log" . mysqli_error($objConexion));
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/consecutivos_data.php?x=3&modulo=maestros");  //x=3 quiere decir que se eliminó bien				
			}else{
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/consecutivos_data.php?x=4&modulo=maestros");  //x=4 quiere decir que no se pudo eliminar.				
			}
			break;
}
?>