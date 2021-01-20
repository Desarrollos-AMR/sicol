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
require_once("../clases/clturnos.php");
switch ($boton)
{
	case "Actualizar":
			$objConexion = Conectarse();
			$sql="update gc_turnos set fecha = '$_REQUEST[fecha]', orden = '$_REQUEST[orden]', placas = '$_REQUEST[placas]', peso_carga = '$_REQUEST[pesocarga]', clase_movimiento = '$_REQUEST[tipomov]', conductor = '$_REQUEST[conductor]', cliente = '$_REQUEST[cliente]', hora_registro = '$_REQUEST[hinicio]', hora_atencion = '$_REQUEST[hfinal]', productos = '$_REQUEST[productos]', bodega = '$_REQUEST[bodega]' where id = $_REQUEST[Id] ";
			$resultado = mysqli_query($objConexion,$sql) or die('MySql Error' . mysqli_error($objConexion));
			if ($resultado) {
				$rac="insert into gc_usuario_actividad(usuario,accion,contenido) values ('$usuario','$boton','$lisva')";
				$rrac=mysqli_query($objConexion,$rac) or die("Error insertando log" . mysqli_error($objConexion));
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/turnos_data.php?x=1&modulo=despachos"); //x=1 es actualizado correctamente
			} else {
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/turnos_data.php?x=2&modulo=despachos"); //x=2 no se puede actualizar
			}
			break;
		
		case "Agregar":
			$objConexion=Conectarse();
	        $consulta=new turnos;
			$resultado = $consulta->agregarturnos( $fecha , $hinicio , $hfinal , $placas, $conductor, $tipomov, $orden, $pesocarga, $productos, $cliente , $turno , $bodega );
			if ($resultado)
			{
				$objConexion = Conectarse();
				$aco="update gc_consecutivos set consecutivo=" . $_REQUEST[turno] . " where tabla='turnos'";
				$raco=mysqli_query($objConexion,$aco) or die("Error" . mysqli_error($objConexion));
				$rac="insert into gc_usuario_actividad(usuario,accion,contenido) values ('$usuario','$boton','$lisva')";
				$rrac=mysqli_query($objConexion,$rac) or die("Error insertando log" . mysqli_error($objConexion));	
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/turnos_data.php?x=1&modulo=turnos"); //x=1 es actualizado correctamente
				echo "El registro se ha agregado correctamente";
			}else{
				echo "Problemas al Agregar Registro";				
			}
			break;

		case "eliminar":
			$objConexion = Conectarse();
			$sql="delete from gc_turnos where id = '$_REQUEST[Id]'";
			$resultado = $objConexion->query($sql);
			if ($resultado){
				$rac="insert into gc_usuario_actividad(usuario,accion,contenido) values ('$usuario','$boton','$lisva')";
				$rrac=mysqli_query($objConexion,$rac) or die("Error insertando log" . mysqli_error($objConexion));	
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/turnos_data.php?x=3&modulo=turnos");  //x=3 quiere decir que se eliminó bien				
			}else{
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/turnos_data.php?x=4&modulo=turnos");  //x=4 quiere decir que no se pudo eliminar.				
			}
			break;
}
?>