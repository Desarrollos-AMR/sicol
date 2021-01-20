<?php
function Conectarse()
{
	$Conexion=new MySQLi('localhost','u280193113inter','iLog#2017','u280193113inter');
	//$Conexion=new MySQLi('localhost','root','the_reborn','intercomer');
	if ($Conexion->connect_errno) 
		echo "Problemas en la Conexion ". $Conexion->connect_error;
	else
		return $Conexion;
}
?>