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
require_once("../clases/cltraslados.php");
switch ($boton)
{
	Case "Actualizar":
			$objConexion = Conectarse();
			$clpro="select cliente from gc_productos where productosId=$_REQUEST[producto]";
			$rclpro=mysqli_query($objConexion,$clpro) or die('MySql Error3' . mysqli_error($objConexion));
			$rsclpro=mysqli_fetch_object($rclpro);
			$clipro=$rsclpro->cliente;			
			$sql="update gc_traslados set fecha = '$_REQUEST[fecha]', consecutivo = '$_REQUEST[consecutivo]', producto = '$_REQUEST[producto]', lote = '$_REQUEST[lote]', cantidad = '$_REQUEST[cantidad]', cantidad_sacos = '$_REQUEST[sacos]', origen = '$_REQUEST[bodega]', destino = '$_REQUEST[bodegad]', cliente = '$clipro', motonave = '$_REQUEST[motonave]' where consecutivo = '$_REQUEST[Id]' ";
			$resultado = mysqli_query($objConexion,$sql) or die('MySql Error' . mysqli_error());
			if ($resultado) {
				$ide=2000000 + ($_REQUEST[Id]*2-1);
				$ids=2000000 + ($_REQUEST[Id]*2);
				$sqld="update gc_despachos set fecha = '$_REQUEST[fecha]', peso_carga = '$_REQUEST[pesocarga]' where remision = $ide";
				$resultadod = mysqli_query($objConexion,$sqld) or die('MySql Error' . mysqli_error());
				$sqld="update gc_despachos set fecha = '$_REQUEST[fecha]', peso_carga = '$_REQUEST[pesocarga]' where remision = $ids";
				$resultadod = mysqli_query($objConexion,$sqld) or die('MySql Error' . mysqli_error());				
				$sqlr="update gc_despachos_producto set producto = '$_REQUEST[producto]', cantidad_tm = '$_REQUEST[cantidad]', cantidad_sacos = '$_REQUEST[sacos]', bodega = '$_REQUEST[bodegad]', lote = '$_REQUEST[lote]', cliente = '$clipro', motonave = '$_REQUEST[motonave]' where remisionid = $ide ";
				$resultador = mysqli_query($objConexion,$sqlr) or die('MySql Error updates' . mysqli_error());
				$sqls="update gc_despachos_producto set producto = '$_REQUEST[producto]', cantidad_tm = '$_REQUEST[cantidad]', cantidad_sacos=  '$_REQUEST[sacos]', bodega = '$_REQUEST[bodega]', lote = '$_REQUEST[lote]', cliente = '$clipro', motonave = '$_REQUEST[motonave]' where remisionid = $ids ";
				$resultados = mysqli_query($objConexion,$sqls) or die('MySql Error updates' . mysqli_error($objConexion));				
				require("../clases/calcular_existencias1.php");
				$rac="insert into gc_usuario_actividad(usuario,accion,contenido) values ('$usuario','$boton','$lisva')";
				$rrac=mysqli_query($objConexion,$rac) or die("Error insertando log" . mysqli_error($objConexion));
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/traslados_data.php?x=1&modulo=operaciones");
			} else {
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/traslados_data.php?x=2&modulo=operaciones");
			}
			break;
		
		Case "Agregar":
			$objConexion = Conectarse();
			require_once("../clases/cldespachos.php");
			require_once("../clases/clprosalidas.php");
			$clpro="select cliente from gc_productos where productosId=$_REQUEST[producto]";
			$rclpro=mysqli_query($objConexion,$clpro) or die('MySql Error3' . mysqli_error($objConexion));
			$rsclpro=mysqli_fetch_object($rclpro);
			$clipro=$rsclpro->cliente;
	        $consulta=new traslados;
			$resultado = $consulta->agregartraslados( $fecha , $consecutivo, $producto, $lote, $cantidad, $sacos, $bodega, $bodegad, $clipro, $motonave );
			if ($resultado){
				$objConexion = Conectarse();
				$uid="select max(id) as id from gc_traslados";
				$ruid=mysqli_query($objConexion,$uid);
				$rsuid=mysqli_fetch_object($ruid);
				$newid=$rsuid->id;
				$cdxs="select consecutivo from gc_consecutivos where tabla='despachoportraslado'";
				$rcdxs=mysqli_query($objConexion,$cdxs);
				$rscdxs=mysqli_fetch_object($rcdxs);
				$ucdxe=$rscdxs->consecutivo;
				$newide=$rscdxs->consecutivo+1;
				$newids=$rscdxs->consecutivo+2;
				$clpro="select cliente from gc_productos where productosId=$_REQUEST[producto]";
				$rclpro=mysqli_query($objConexion,$clpro) or die('MySql Error3' . mysqli_error($objConexion));
				$rsclpro=mysqli_fetch_object($rclpro);
				$clipro=$rsclpro->cliente;
				$tipo="e";
				$tiquete=0;
				$observacion="";
				$orden=0;
				$placas="";
				$carga=0;
				$trans=0;
				$conductor=0;
				$destino="";
				$cliente=0;
				$clamo="dt";
				$inicio="00:00:00";
				$final="00:00:00";
				$turno=0;

				$newdespacho= new despachos;
				$resdespacho= $newdespacho->agregardespachos($fecha,$inicio,$final,$tipo,"et",$tiquete,$observacion,$orden,$placas,$carga,$newide,$trans,$conductor,$destino,$cliente,$turno);
		        $newdesproducto=new prosalidas;
				$resdesproducto = $newdesproducto->agregarprosalidas( $fecha,$newide, $producto, $cantidad, $sacos, $bodegad, $lote , $tipo , "et", $clipro, $motonave, $observacion);				
				$newdespacho= new despachos;
				$resdespacho= $newdespacho->agregardespachos($fecha,$inicio,$final,"s",$clamo,$tiquete,$observacion,$orden,$placas,$carga,$newids,$trans,$conductor,$destino,$cliente,$turno);
		        $newdesproducto=new prosalidas;
				$resdesproducto = $newdesproducto->agregarprosalidas( $fecha,$newids, $producto, $cantidad, $sacos, $bodega, $lote , "s" , $clamo , $clipro, $motonave, $observacion);
				
				$nuecon=$ucdxe+2;
				$acdxe="update gc_consecutivos set consecutivo=" . $nuecon . " where tabla='despachoportraslado'";
				$racdxe=mysqli_query($objConexion,$acdxe);	
				$aco="update gc_consecutivos set consecutivo=" . $consecutivo . " where tabla='traslados'";
				$raco=mysqli_query($objConexion,$aco) or die("Error" . mysqli_error($objConexion));			
				require("../clases/calcular_existencias1.php");
				$rac="insert into gc_usuario_actividad(usuario,accion,contenido) values ('$usuario','$boton','$lisva')";
				$rrac=mysqli_query($objConexion,$rac) or die("Error insertando log" . mysqli_error($objConexion));	
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/traslados_data.php?x=1&modulo=operaciones");
				echo "El registro se ha agregado correctamente";
			} else {
				echo "Problemas al Agregar Registro";
			}
			break;

		Case "eliminar":
			$objConexion = Conectarse();
			$sql="delete from gc_traslados where Id = '$_REQUEST[Id]'";
			$resultado = $objConexion->query($sql);
			if ($resultado){
				$rac="insert into gc_usuario_actividad(usuario,accion,contenido) values ('$usuario','$boton','$lisva')";
				$rrac=mysqli_query($objConexion,$rac) or die("Error insertando log" . mysqli_error($objConexion));	
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/traslados_data.php?x=3&modulo=operaciones");				
			} else {
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/traslados_data.php?x=4&modulo=operaciones");
			}
		break;
}
?>