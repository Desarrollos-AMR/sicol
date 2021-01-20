<?php
//include"../clases/ConexionDatos.php";
//$objConexion=Conectarse();
$vactmp="truncate gc_tmpexistencias";
$rvactmp=mysqli_query($objConexion,$vactmp) or die('MySql Error1' . mysql_error());
$pro="select * from gc_productos order by nombre";
$rpro=mysqli_query($objConexion,$pro) or die('MySql Error1' . mysql_error());
while ($rspro = mysqli_fetch_array($rpro)){
	$proa=$rspro[productosId];
	$sin="select * from gc_saldos_iniciales where producto=" . $rspro[productosId];
	$rsin=mysqli_query($objConexion,$sin) or die('MySql Error2' . mysqli_error($objConexion));
	$tsin=mysqli_num_rows($rsin);
	//El producto tiene saldos iniciales
	if ($tsin!=0){
		while ($rssin=mysqli_fetch_array($rsin)){
			$entxp=0;
			$ensxp=0;
			$desxp=0;
			$bodega=$rssin[bodega];
			$lote= $rssin[lote];
			$sinicial=$rssin[saldo_inicial];
			$sinicialsacos=$rssin[saldo_inicial_sacos];
			$fsinicial=$rssin[fecha];
			$cliente=$rssin[cliente];
			$rixp="select sum(cantidad_tm) as tokilos, sum(cantidad_sacos) as tosacos from gc_despachos_producto where producto=" . $rssin[producto] . " and bodega =" . $bodega . " and lote='" . $lote . "' and tipo='e'";			
			$dxp="select sum(cantidad_tm) as tokilos, sum(cantidad_sacos) as tosacos  from gc_despachos_producto where producto=" . $rssin[producto] . " and bodega =" . $bodega . " and lote='" . $lote . "' and tipo='s'";

			$rrixp=mysqli_query($objConexion,$rixp) or die('Error en ingresos' . mysqli_error($objConexion));
			$trixp=mysqli_num_rows($rrixp);
			if ($trixp!=0){
				$rsrixp=mysqli_fetch_object($rrixp);
				$entxp=$rsrixp->tokilos;
				$entxps=$rsrixp->tosacos;
			}

			$rdxp=mysqli_query($objConexion,$dxp) or die('Error en salidas' . mysqli_error($objConexion));
			$tdxp=mysqli_num_rows($rdxp);
			if ($tdxp!=0){
				$rsdxp=mysqli_fetch_object($rdxp);
				$desxp=$rsdxp->tokilos;
				$desxps=$rsdxp->tosacos;
			}
			$saldosa=$sinicialsacos+$entxps-$desxps;
			$cliente=$rspro[cliente];

			$saldotm=$sinicial+$entxp-$desxp;
			if ($saldosa > 0 or $saldotm > 0){
				$insexp="insert into gc_tmpexistencias(producto,bodega,cliente,lote,cantidad_tm,cantidad_sacos) values ($proa,$bodega,$cliente,$lote,$saldotm,$saldosa)";
				$resultado=mysqli_query($objConexion,$insexp) or die('Error insertando en gc_tmpexistencias' . mysql_error());	
			}
		}
	} 

}

$bexp="SELECT producto, bodega, lote, cliente, tipo FROM gc_despachos_producto where tipo='e' group by producto,bodega,lote";
$rbexp=mysqli_query($objConexion,$bexp) or die("Error buscando entradas" . mysqli_error($objConexion));
if (mysqli_num_rows($rbexp)!=0){
	while ($rsbexp=mysqli_fetch_array($rbexp)){
			$entxp=0;
			$ensxp=0;
			$desxp=0;
			$producto=$rsbexp[producto];
			$bodega=$rsbexp[bodega];
			$cliente=$rsbexp[cliente];
			$lote= $rsbexp[lote];
			$ssi="select * from gc_saldos_iniciales where producto=" . $producto . " and bodega=" . $bodega . " and lote='" . $lote . "'";
			$rssi=mysqli_query($objConexion,$ssi) or die("Error buscando saldo inicial" . mysqli_error($objConexion));
			$frssi=mysqli_num_rows($rssi);
			//Entrada sin saldo inicial
			if ($frssi==0){
				$rixp="select sum(cantidad_tm) as tokilos, sum(cantidad_sacos) as tosacos from gc_despachos_producto where producto=" . $producto . " and bodega =" . $bodega . " and lote='" . $lote . "' and tipo='e'";
				$dxp="select sum(cantidad_tm) as tokilos, sum(cantidad_sacos) as tosacos  from gc_despachos_producto where producto=" . $producto . " and bodega =" . $bodega . " and lote='" . $lote . "' and tipo='s'";

				$rrixp=mysqli_query($objConexion,$rixp) or die('Error buscando totales de ingresos' . mysqli_error($objConexion));
				$trixp=mysqli_num_rows($rrixp);
				if ($trixp!=0){
					$rsrixp=mysqli_fetch_object($rrixp);
					$entxp=$rsrixp->tokilos;
					$entxps=$rsrixp->tosacos;
				}

				$rdxp=mysqli_query($objConexion,$dxp) or die('Error buscando totales de salidas' . mysqli_error($objConexion));
				$tdxp=mysqli_num_rows($rdxp);
				if ($tdxp!=0){
					$rsdxp=mysqli_fetch_object($rdxp);
					$desxp=$rsdxp->tokilos;
					$desxps=$rsdxp->tosacos;
				}
				$saldosa=$entxps-$desxps;
				$saldotm=$entxp-$desxp;
				if ($saldosa > 0 or $saldotm > 0){
					$insexp="insert into gc_tmpexistencias(producto,bodega,cliente,lote,cantidad_tm,cantidad_sacos) values ($producto,$bodega,$cliente,'$lote',$saldotm,$saldosa)";
					$resultado=mysqli_query($objConexion,$insexp) or die('Error insertando en gc_tmpexistencias sin saldo inicial' . mysqli_error($objConexion));
				}
			}
	}
}
?>