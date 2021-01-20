<?php
session_start();
$login=$_SESSION['user'];
$usuid=intval($_SESSION['userid']);
extract ($_REQUEST);
require "../clases/ConexionDatos.php";
$objConexion=Conectarse();
$clavev = md5($_REQUEST['passwordv']);
$claven = md5($_REQUEST['passn']);
$sql="select * from gc_usuarios where usuLogin = '$login' and usuPassword = '$clavev'";
$resultado=$objConexion->query($sql);

$existe = $resultado->num_rows;
if ($existe==1)
{
	$acus="update gc_usuarios set usuPassword = '$claven' where usuid = $usuid";
	$racus=mysqli_query($objConexion,$acus) or die("Error" . mysqli_error($objConexion));
	if (isset($racus)){
		session_destroy();
		ob_clean();
		header("location:../index.php?x=4");			
	}
}
else
{
	header("location:../index.php?x=1");
}
?>