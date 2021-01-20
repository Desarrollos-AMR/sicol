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
require_once("../clases/clprosalidas.php");
switch ($boton)
{
	case "Actualizar":
			$objConexion = Conectarse();
			$clpro="select cliente from gc_productos where productosId=$_REQUEST[producto]";
			$rclpro=mysqli_query($objConexion,$clpro) or die('MySql Error3' . mysqli_error($objConexion));
			$rsclpro=mysqli_fetch_object($rclpro);
			$clipro=$rsclpro->cliente;			
			$sql="update gc_despachos_producto set fecha='$_REQUEST[fecha]', producto = '$_REQUEST[producto]', cantidad_tm = '$_REQUEST[cantidadtm]', cantidad_sacos = '$_REQUEST[cantidadsacos]', bodega = '$_REQUEST[bodega]', lote = '$_REQUEST[lote]', cliente = '$clipro', motonave = '$_REQUEST[motonave]', observacion = '$_REQUEST[observacion]' where id = $_REQUEST[Id] ";
			$resultado = mysqli_query($objConexion,$sql) or die('MySql Error updates' . mysqli_error());
			if ($resultado) {
				$rac="insert into gc_usuario_actividad(usuario,accion,contenido) values ('$usuario','$boton','$lisva')";
				$rrac=mysqli_query($objConexion,$rac) or die("Error insertando log" . mysqli_error($objConexion));	
                header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/despachos_productos_data.php?x=1&modulo=despachos&progid=$_REQUEST[progid]&Id=$_REQUEST[desid]&tipo=$_REQUEST[tipo]"); //x=1 es actualizado correctamente
			} else {
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/despachos_productos_data.php?x=2&modulo=despachos&progid=$_REQUEST[progid]&Id=$_REQUEST[desid]&tipo=$_REQUEST[tipo]"); //x=2 no se puede actualizar
			}
			break;
		
		case "Agregar":
			$objConexion = Conectarse();
			$acum=0;
			$verex="select sum(cantidad_tm) as acum from gc_despachos_producto where remisionid=" . $_REQUEST['remisionid'] ;
			$rverex=mysqli_query($objConexion,$verex) or die("error" . mysqli_error($objConexion));
			$rsverex=mysqli_fetch_object($rverex);
			$acum=$rsverex->acum;
			$pesodes="select peso_carga from gc_despachos where remision=" . $_REQUEST['remisionid'];
			$rpesodes=$objConexion->query($pesodes);
			$rspesodes=mysqli_fetch_object($rpesodes);
			$pesocarga=$rspesodes->peso_carga;
			/*if (($acum + $cantidadtm) > $pesocarga){
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/despachos_productos_data.php?x=1&progid=$_REQUEST[progid]&tipo=$_REQUEST[tipo]&malo=1");
				echo "<h3>La suma de los pesos de los productos es mayor al peso neto registrado en la cabecera</h3>";
			} else {*/
				$clpro="select cliente from gc_productos where productosId=$_REQUEST[producto]";
				$rclpro=mysqli_query($objConexion,$clpro) or die('MySql Error3' . mysqli_error($objConexion));
				$rsclpro=mysqli_fetch_object($rclpro);
				$clipro=$rsclpro->cliente;
		        $consulta=new prosalidas;
		        if ($tipo=="s"){
					$resultado = $consulta->agregarprosalidas( $fecha, $remisionid, $producto, $cantidadtm, $cantidadsacos, $bodega, $lote , $tipo , "dp" , $clipro, $motonave, $observacion);
				} elseif ($tipo=="e") {
					$resultado = $consulta->agregarprosalidas( $fecha, $remisionid, $producto, $cantidadtm, $cantidadsacos, $bodega, $lote , $tipo , "rp" , $clipro, $motonave, $observacion);
				}
				if ($resultado)
				{
					$rac="insert into gc_usuario_actividad(usuario,accion,contenido) values ('$usuario','$boton','$lisva')";
					$rrac=mysqli_query($objConexion,$rac) or die("Error insertando log" . mysqli_error($objConexion));	
					header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/despachos_productos_data.php?x=1&modulo=despachos&progid=$_REQUEST[progid]&tipo=$_REQUEST[tipo]&fecha=$_REQUEST[fecha]"); //x=1 es actualizado correctamente
					echo "El registro se ha agregado correctamente";
				}else{
					echo "Problemas al Agregar Registro";
				}
			//}
			break;

		case "eliminar":
			$objConexion = Conectarse();
			$sql="delete from gc_despachos_producto where id = $_REQUEST[Id]";
			$resultado = $objConexion->query($sql);
			if ($resultado){
				$rac="insert into gc_usuario_actividad(usuario,accion,contenido) values ('$usuario','$boton','$lisva')";
				$rrac=mysqli_query($objConexion,$rac) or die("Error insertando log" . mysqli_error($objConexion));	
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/despachos_productos_data.php?x=3&modulo=despachos&progid=$_REQUEST[progid]&tipo=$_REQUEST[tipo]");			
			}else{
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/despachos_productos_data.php?x=4&modulo=despachos&progid=$_REQUEST[progid]&tipo=$_REQUEST[tipo]");			
			}
			break;
}
?>