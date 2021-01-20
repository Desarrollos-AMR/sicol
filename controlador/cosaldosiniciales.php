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
require_once("../clases/clsaldosiniciales.php");
switch ($boton)
{
	Case "Actualizar":
			$objConexion = Conectarse();
			$sql="update gc_saldos_iniciales set producto = '$_REQUEST[producto]', 
			bodega = $_REQUEST[bodega], lote = '$_REQUEST[lote]', saldo_inicial = $_REQUEST[saldok], saldo_inicial_sacos = $_REQUEST[saldos], fecha = '$_REQUEST[fecha]'
			where id = $_REQUEST[Id] ";
			$resultado = mysqli_query($objConexion,$sql) or die('MySql Error' . mysqli_error($objConexion));
			if ($resultado) {
				$rac="insert into gc_usuario_actividad(usuario,accion,contenido) values ('$usuario','$boton','$lisva')";
				$rrac=mysqli_query($objConexion,$rac) or die("Error insertando log" . mysqli_error($objConexion));	
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/saldos_iniciales_data.php?x=1&modulo=inventario");
			} else {
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/saldos_iniciales_data.php?x=2&modulo=inventario"); 
			}
			break;
		
		Case "Agregar":
			$objConexion=Conectarse();
	        $consulta=new existencia;
			$resultado = $consulta->agregarexistencias( $producto , $bodega , $lote , $saldok , $saldos , $fecha  );
			if ($resultado)
			{
				$rac="insert into gc_usuario_actividad(usuario,accion,contenido) values ('$usuario','$boton','$lisva')";
				$rrac=mysqli_query($objConexion,$rac) or die("Error insertando log" . mysqli_error($objConexion));	
				header ("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/saldos_iniciales_data.php?x=1&modulo=inventario");
				echo "La existencia se ha actualizado correctamente";
			}else{
				echo "Problemas al Agregar saldos_iniciales";
			}
			break;

		Case "eliminar":
			$objConexion = Conectarse();
			$sql="delete from gc_saldos_iniciales where gc_saldos_iniciales.id = '$_REQUEST[Id]'";
			$resultado = mysqli_query($objConexion,$sql) or die('MySql Error' . mysqli_error());
			if ($resultado){
				$rac="insert into gc_usuario_actividad(usuario,accion,contenido) values ('$usuario','$boton','$lisva')";
				$rrac=mysqli_query($objConexion,$rac) or die("Error insertando log" . mysqli_error($objConexion));	
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/saldos_iniciales_data.php?x=3&modulo=inventario"); 			
			}else{
				header("location: ../Plantilla/vistaPrincipal.php?pg=../vistas/paginador1.php&lista=../vistas/saldos_iniciales_data.php?x=4&modulo=inventario");				
			}
			break;
}
?>