<?php
session_start();
extract ($_REQUEST);
require "../clases/ConexionDatos.php";
$objConexion=Conectarse();
$clave = md5($_REQUEST[password]);
$sql="select * from gc_usuarios where usuLogin = '$_REQUEST[login]' and usuPassword = '$clave'";
$resultado=$objConexion->query($sql);

$existe = $resultado->num_rows;
if ($existe==1)  
{
	session_start();	
	$usuario=$resultado->fetch_object();
	$_SESSION['userid']=$usuario->usuid;
	$_SESSION['user'] = $usuario->usuLogin;
	$_SESSION['nivel'] = $usuario->usuNivel;	
	ob_clean();
	header("location:../Plantilla/vistaPrincipal.php?pg=../Plantilla/pgInicial.php");	
}
else
{
	header("location:../index.php?x=1");
}
?>