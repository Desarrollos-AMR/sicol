<?php
session_start();
extract ($_REQUEST);
require "../clases/ConexionDatos.php";
$objConexion=Conectarse();
$clave = $_REQUEST[password];
echo $clave;
die;
$sql="select * from gc_conductores where cedula =" . $clave;
$resultado=$objConexion->query($sql);

$existe = $resultado->num_rows;
if ($existe==1)  
{
	session_start();	
	$usuario=$resultado->fetch_object();
	$_SESSION['nombre'] = $usuario->nombre;
	$_SESSION['user'] = 'invitado';
	ob_clean();
	header("location:../vistas/paginador1.php&lista=../vistas/turnos_data.php&modulo=operaciones");	
}
else
{
	header("location:../index.php?x=1");
}
?>