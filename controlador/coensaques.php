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
require_once("../clases/clensaques.php");
switch ($boton)
{
	Case "Actualizar":
			$objConexion = Conectarse();
			$granel = $_REQUEST[granel];
			$ensaques=explode("-",$granel);
			$granelc=$ensaques[0];
			$bodegag=$ensaques[1];
			$loteg=$ensaques[2];
			$clpro="select cliente from gc_productos where productosId=$_REQUEST[producto]";
			$rclpro=mysqli_query($objConexion,$clpro) or die('MySql Error3' . mysqli_error($objConexion));
			$rsclpro=mysqli_fetch_object($rclpro);
			$clipro=$rsclpro->cliente;			
			$sql="update gc_ensaque set fecha = '$_REQUEST[fecha]', granel = '$granelc', producto = '$_REQUEST[producto]', cantidad_tm = '$_REQUEST[cantidadtm]', cantidad_sacos = '$_REQUEST[cantidadsacos]', bodega = '$_REQUEST[bodega]', lote = '$_REQUEST[lote]', cliente = '$clipro', bodega_granel = '$bodegag', lote_granel = '$loteg', motonave = '$_REQUEST[motonave]'  where consecutivo = $_REQUEST[Id] ";
			
			$resultado = mysqli_query($objConexion,$sql) or die('No se pudo actualizar' . mysqli_error());
			
			if ($resultado) {
				$ide=1000000 + ($_REQUEST[Id]*2);
				$ids=1000000 + ($_REQUEST[Id]*2+1);
				$sqld="update gc_despachos set fecha = '$_REQUEST[fecha]', peso_carga = '$_REQUEST[pesocarga]' where remision = $ide";
				$resultadod = mysqli_query($objConexion,$sqld) or die('MySql Error' . mysqli_error());
				$sqld="update gc_despachos set fecha = '$_REQUEST[fecha]', peso_carga = '$_REQUEST[pesocarga]' where remision = $ids";
				$resultadod = mysqli_query($objConexion,$sqld) or die('MySql Error' . mysqli_error());				
				$sqlr="update gc_despachos_producto set producto = '$_REQUEST[producto]', cantidad_tm = '$_REQUEST[cantidadtm]', cantidad_sacos = '$_REQUEST[cantidadsacos]', bodega = '$_REQUEST[bodega]', lote = '$_REQUEST[lote]', cliente = '$clipro', motonave = '$_REQUEST[motonave]' where remisionid = $ide ";
				$resultador = mysqli_query($objConexion,$sqlr) or die('MySql Error updates' . mysqli_error());
				$sqls="update gc_despachos_producto set producto = '$granelc', cantidad_tm = '$_REQUEST[cantidadtm]', cantidad_sacos=  0, bodega = '$bodegag', lote = '$loteg', cliente = '$clipro', motonave = '$_REQUEST[motonave]' where remisionid = $ids ";
				$resultados = mysqli_query($objConexion,$sqls) or die('MySql Error updates' . mysqli_error($objConexion));				
				require("../clases/calcular_existencias.php");
				$rac="insert into gc_usuario_actividad(usuario,accion,contenido) values ('$usuario','$boton','$lisva')";
				$rrac=mysqli_query($objConexion,$rac) or die("Error insertando log" . mysqli_error($objConexion));
                header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/ensaques_data.php?x=1&modulo=ensaques"); //x=1 es actualizado correctamente
			} else {
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/ensaques_data.php?x=2&modulo=ensaques"); //x=2 no se puede actualizar
			}
			break;
		
		Case "Agregar":
			$objConexion = Conectarse();
			$uid="select max(consecutivo) as id from gc_ensaque";
			$ruid=mysqli_query($objConexion,$uid);
			$rsuid=mysqli_fetch_object($ruid);
			$newid=$rsuid->id;
			$cdxs="select consecutivo from gc_consecutivos where tabla='despachoporensaque'";
			$rcdxs=mysqli_query($objConexion,$cdxs);
			$rscdxs=mysqli_fetch_object($rcdxs);
			$ucdxe=$rscdxs->consecutivo;
			require_once("../clases/cldespachos.php");
			require_once("../clases/clprosalidas.php");
			$ensaques=explode("-",$granel);
			$granelc=$ensaques[0];
			$bodegag=$ensaques[1];
			$loteg=$ensaques[2];
			$clpro="select cliente from gc_productos where productosId=$_REQUEST[producto]";
			$rclpro=mysqli_query($objConexion,$clpro) or die('Error buscando cliente' . mysqli_error($objConexion));
			$rsclpro=mysqli_fetch_object($rclpro);
			$clipro=$rsclpro->cliente;
	        $consulta=new ensaques;
			$resultado = $consulta->agregarensaques( $newid, $fecha, $granelc, $producto, $cantidadtm, $cantidadsacos, $bodega, $lote, $bodegag, $loteg, $clipro, $motonave);
			if ($resultado)
			{
				$objConexion = Conectarse();
				$newide=$ucdxe+1;
				$newids=$ucdxe+2;
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
				$clamo="de";
				$inicio="00:00:00";
				$final="00:00:00";

				$newdespacho= new despachos;
				$resdespacho= $newdespacho->agregardespachos($fecha,$inicio,$final,$tipo,"ee",$tiquete,$observacion,$orden,$placas,$carga,$newide,$trans,$cond,$destino,$clipro,$turno);
		        $newdesproducto=new prosalidas;
				$resdesproducto = $newdesproducto->agregarprosalidas( $fecha,$newide, $producto, $cantidadtm, $cantidadsacos, $bodega, $lote , $tipo ,"ee", $clipro, $motonave,$observacion);				
				$newdespacho= new despachos;
				$resdespacho= $newdespacho->agregardespachos($fecha,$inicio,$final,"s",$clamo,$tiquete,$observacion,$orden,$placas,$carga,$newids,$trans,$cond,$destino,$clipro,$turno);
		        $newdesproducto=new prosalidas;
				$resdesproducto = $newdesproducto->agregarprosalidas( $fecha,$newids, $granelc, $cantidadtm, 0, $bodegag, $loteg , "s" ,$clamo, $clipro, $motonave,$observacion);
				
				$nuecon=$ucdxe+2;
				$acdxe="update gc_consecutivos set consecutivo=" . $nuecon . " where tabla='despachoporensaque'";
				$racdxe=mysqli_query($objConexion,$acdxe);				
				require("../clases/calcular_existencias.php");
				$rac="insert into gc_usuario_actividad(usuario,accion,contenido) values ('$usuario','$boton','$lisva')";
				$rrac=mysqli_query($objConexion,$rac) or die("Error insertando log" . mysqli_error($objConexion));	
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/ensaques_data.php?x=1&modulo=ensaques"); //x=1 es actualizado correctamente
				echo "El registro se ha agregado correctamente";
			}else{
				echo "Problemas al Agregar Registro";
			}
			break;

		Case "eliminar":
			$objConexion = Conectarse();
			$sql="delete from gc_ensaque where Id = '$_REQUEST[Id]'";
			$resultado =  mysqli_query($objConexion,$sql) or die('No se pudo actualizar' . mysqli_error());
			if ($resultado){
				$rac="insert into gc_usuario_actividad(usuario,accion,contenido) values ('$usuario','$boton','$lisva')";
				$rrac=mysqli_query($objConexion,$rac) or die("Error insertando log" . mysqli_error($objConexion));	
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/ensaques_data.php?x=3&modulo=ensaques");  //x=3 quiere decir que se eliminó bien				
			}else{
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/ensaques_data.php?x=4&modulo=ensaques");  //x=4 quiere decir que no se pudo eliminar.				
			}
			break;
}
?>