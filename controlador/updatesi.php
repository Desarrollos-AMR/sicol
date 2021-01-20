<?php
include"../clases/ConexionDatos.php";
$objConexion=Conectarse();
/*
$si="select * from gc_saldos_iniciales";
$rsi=mysqli_query($objConexion,$si);
while ($rssi=mysqli_fetch_array($rsi)){
	$as="select gc_productos.presentacion as pre,gc_presentacion.kilos as kilos from gc_productos left join gc_presentacion on gc_productos.presentacion=gc_presentacion.id where gc_productos.productosId=" . $rssi[producto];
	$ras=mysqli_query($objConexion,$as);
	$rsas=mysqli_fetch_array($ras);
	if ($rsas[pre]!=9){
		$sis=$rssi['saldo_inicial']/$rsas['kilos'];
		$upsi="update gc_saldos_iniciales set saldo_inicial_sacos=" . $sis . " where id=" . $rssi['id'];
		$rupsi=mysqli_query($objConexion,$upsi);		
	}
}
*/
$upsi="update gc_ensaque inner join gc_productos on gc_ensaque.producto=gc_productos.productosId set gc_ensaque.cliente=gc_productos.cliente";
$rupsi=mysqli_query($objConexion,$upsi);		
?>