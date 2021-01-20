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
require_once("../clases/clajustes.php");
switch ($boton)
{
	Case "Actualizar":
			$objConexion = Conectarse();
			$clpro="select cliente from gc_productos where productosId=$_REQUEST[producto]";
			$rclpro=mysqli_query($objConexion,$clpro) or die('Error consultando cliente' . mysqli_error($objConexion));
			$rsclpro=mysqli_fetch_object($rclpro);
			$clipro=$rsclpro->cliente;			
			$sql="update gc_ajustes set producto = '$_REQUEST[producto]', cantidad_tm = '$_REQUEST[cantidadtm]', cantidad_sacos = '$_REQUEST[cantidadsacos]', bodega = '$_REQUEST[bodega]', lote = '$_REQUEST[lote]', cliente = '$clipro', tipo = '$_REQUEST[tipo]', fecha = '$_REQUEST[fecha]', observacion = '$_REQUEST[observacion]' where consecutivo = $_REQUEST[Id] ";
			$resultado = mysqli_query($objConexion,$sql) or die('MySql Error updates' . mysqli_error());
			if ($resultado) {
				if ($_REQUEST[tipo]=="e"){
					$ide=3000000 + $_REQUEST[Id];
					$sqld="update gc_despachos set fecha = '$_REQUEST[fecha]', observacion = '$_REQUEST[observacion]' where remision = $ide";	
					$sqls="update gc_despachos_producto set producto = '$_REQUEST[producto]', cantidad_tm = '$_REQUEST[cantidad]', cantidad_sacos = '$_REQUEST[sacos]', bodega = '$_REQUEST[bodegad]', lote = '$_REQUEST[lote]', cliente = '$clipro' where remisionid = $ide ";				
				}else{
					$ids=3000000 + $_REQUEST[Id];
					$sqld="update gc_despachos set fecha = '$_REQUEST[fecha]', peso_carga = '$_REQUEST[pesocarga]' where remision = $ids";						
					$sqls="update gc_despachos_producto set producto = '$_REQUEST[producto]', cantidad_tm = '$_REQUEST[cantidad]', cantidad_sacos=  '$_REQUEST[sacos]', bodega = '$_REQUEST[bodega]', lote = '$_REQUEST[lote]', cliente = '$clipro' where remisionid = $ids ";				
				}
				$resultadod = mysqli_query($objConexion,$sqld) or die('MySql Error' . mysqli_error());				
				$resultados = mysqli_query($objConexion,$sqls) or die('MySql Error updates' . mysqli_error($objConexion));				
				require("../clases/calcular_existencias.php");				
				
				$rac="insert into gc_usuario_actividad(usuario,accion,contenido) values ('$usuario','$boton','$lisva')";
				$rrac=mysqli_query($objConexion,$rac) or die("Error insertando log" . mysqli_error($objConexion));	
                header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/ajustes_data.php?x=1"); 
			} else {
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/ajustes_data.php?x=2"); 
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
	        $consulta=new ajustes;
			$resultado = $consulta->agregarajustes( $usuario, $fecha, $producto, $cantidadtm, $cantidadsacos, $bodega, $lote , $tipo , $clipro, $observacion, $consecutivo);
			if ($resultado)
			{
				$objConexion = Conectarse();
				$uid="select max(id) as id from gc_ajustes";
				$ruid=mysqli_query($objConexion,$uid);
				$rsuid=mysqli_fetch_object($ruid);
				$newid=$rsuid->id;
				$cdxs="select consecutivo from gc_consecutivos where tabla='ajustes'";
				$rcdxs=mysqli_query($objConexion,$cdxs);
				$rscdxs=mysqli_fetch_object($rcdxs);
				$ucdxe=$rscdxs->consecutivo;
				$newida=$rscdxs->consecutivo+1;
				$clpro="select cliente from gc_productos where productosId=$_REQUEST[producto]";
				$rclpro=mysqli_query($objConexion,$clpro) or die('MySql Error3' . mysqli_error($objConexion));
				$rsclpro=mysqli_fetch_object($rclpro);
				$clipro=$rsclpro->cliente;
				$tiquete=0;
				$orden=0;
				$placas="";
				$carga=0;
				$trans=0;
				$conductor=0;
				$destino="";
				$cliente=0;
				$moto=0;
				$clamo="aj";
				$inicio="00:00:00";
				$final="00:00:00";
				$turno=0;

				$newdespacho= new despachos;
				$resdespacho= $newdespacho->agregardespachos($fecha,$inicio,$final,$tipo,$clamo,$tiquete,$observacion,$orden,$placas,$carga,$newida,$trans,$conductor,$destino,$cliente,$turno);
		        $newdesproducto=new prosalidas;
				$resdesproducto = $newdesproducto->agregarprosalidas( $fecha,$newida, $producto, $cantidadtm, $cantidadsacos, $bodega, $lote , $tipo ,$clamo, $clipro, $moto, $observacion);				

				$nuecon=$ucdxe+2;
				$aco="update gc_consecutivos set consecutivo=" . $consecutivo . " where tabla='ajustes'";
				$raco=mysqli_query($objConexion,$aco) or die("Error" . mysqli_error($objConexion));			
				require("../clases/calcular_existencias1.php");
				
				
				$rac="insert into gc_usuario_actividad(usuario,accion,contenido) values ('$usuario','$boton','$lisva')";
				$rrac=mysqli_query($objConexion,$rac) or die("Error insertando log" . mysqli_error($objConexion));	
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/ajustes_data.php?x=1"); //x=1 es actualizado correctamente
				echo "El registro se ha agregado correctamente";
			}else{
				echo "Problemas al Agregar Registro";
			}
			break;

		Case "eliminar":
			$objConexion = Conectarse();
			$sql="delete from gc_ajustes where id = $_REQUEST[Id]";
			$resultado = $objConexion->query($sql);
			if ($resultado){
				$rac="insert into gc_usuario_actividad(usuario,accion,contenido) values ('$usuario','$boton','$lisva')";
				$rrac=mysqli_query($objConexion,$rac) or die("Error insertando log" . mysqli_error($objConexion));	
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/ajustes_data.php?x=3");			
			}else{
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador4.php&lista=../vistas/ajustes_data.php?x=4");			
			}
			break;
}
?>