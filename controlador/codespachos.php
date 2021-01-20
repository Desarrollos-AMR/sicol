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
require_once("../clases/cldespachos.php");
switch ($boton)
{
	case "Actualizar":
			$objConexion = Conectarse();
			$sql="update gc_despachos set fecha = '$_REQUEST[fecha]', tiquete = '$_REQUEST[tiquete]', orden = '$_REQUEST[orden]', placas = '$_REQUEST[placas]', observacion = '$_REQUEST[observacion]', peso_carga = '$_REQUEST[pesocarga]', remision = '$_REQUEST[remision]', transportador = '$_REQUEST[transportador]', conductor = '$_REQUEST[conductor]', destino = '$_REQUEST[destino]', cliente_destino = '$_REQUEST[cliente]', hora_inicio = '$_REQUEST[hinicio]', hora_final = '$_REQUEST[hfinal]' where id = $_REQUEST[Id] ";
			$resultado = mysqli_query($objConexion,$sql) or die('MySql Error' . mysqli_error($objConexion));
			if ($resultado) {
				$rac="insert into gc_usuario_actividad(usuario,accion,contenido) values ('$usuario','$boton','$lisva')";
				$rrac=mysqli_query($objConexion,$rac) or die("Error insertando log" . mysqli_error($objConexion));
				if ($_REQUEST[hfinal]!=""){
					$cetu = "update gc_turnos set despachado = 1 where turno=" . $_REQUEST[turno] . " and fecha='" . $_REQUEST[fecha] . "'";
					$cetur = mysqli_query($objConexion,$cetu) or die('MySql Error' . mysqli_error($objConexion));
				}				
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/despachos_data.php?x=1&tipo=$_REQUEST[tipo]&modulo=despachos"); //x=1 es actualiz|ado correctamente

			} else {
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/despachos_data.php?x=2&tipo=$_REQUEST[tipo]&modulo=despachos"); //x=2 no se puede actualizar
			}
			break;
		
		case "Agregar":
			$objConexion=Conectarse();
	        $consulta=new despachos;
			if ($tipo=="s"){
				$resultado = $consulta->agregardespachos( $fecha , $hinicio , $hfinal , $tipo, "dp" , $tiquete, $observacion, $orden, $placas, $pesocarga, $remision, $transportador, $conductor, $destino, $cliente, $turno );
			}elseif($tipo=="e"){
				$resultado = $consulta->agregardespachos( $fecha , $hinicio , $hfinal , $tipo, "rp" , $tiquete, $observacion, $orden, $placas, $pesocarga, $remision, $transportador, $conductor, $destino, $cliente, $turno );
			}	
			if ($resultado)
			{
				$objConexion = Conectarse();
				if ($tipo=="s"){
					$aco="update gc_consecutivos set consecutivo=" . $_REQUEST[remision] . " where tabla='despachos'";
				} elseif ($tipo=="e"){
					$aco="update gc_consecutivos set consecutivo=" . $_REQUEST[remision] . " where tabla='recibos'";
				}
				$raco=mysqli_query($objConexion,$aco) or die("Error" . mysqli_error($objConexion));
				$rac="insert into gc_usuario_actividad(usuario,accion,contenido) values ('$usuario','$boton','$lisva')";
				$rrac=mysqli_query($objConexion,$rac) or die("Error insertando log" . mysqli_error($objConexion));
				if ($_REQUEST[hfinal]!=""){
					$cetu = "update gc_turnos set despachado = 1 where turno=" . $_REQUEST[turno] . " and fecha='" . $_REQUEST[fecha] . "'";
					$cetur = mysqli_query($objConexion,$cetu) or die('MySql Error' . mysqli_error($objConexion));
				}					
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/despachos_data.php?x=1&tipo=$_REQUEST[tipo]&modulo=despachos"); //x=1 es actualizado correctamente
				echo "El registro se ha agregado correctamente";
			}else{
				echo "Problemas al Agregar Registro";				
			}
			break;

		case "eliminar":
			$objConexion = Conectarse();
			$sql="delete from gc_despachos where id = '$_REQUEST[Id]'";
			$resultado = $objConexion->query($sql);
			if ($resultado){
				$rac="insert into gc_usuario_actividad(usuario,accion,contenido) values ('$usuario','$boton','$lisva')";
				$rrac=mysqli_query($objConexion,$rac) or die("Error insertando log" . mysqli_error($objConexion));	
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/despachos_data.php?x=3&modulo=despachos");  //x=3 quiere decir que se eliminó bien				
			}else{
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/despachos_data.php?x=4&modulo=despachos");  //x=4 quiere decir que no se pudo eliminar.				
			}
			break;
}
?>