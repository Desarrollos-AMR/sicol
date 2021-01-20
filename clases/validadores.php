<?php 
require "../clases/ConexionDatos.php";
$objConexion=Conectarse();
$producto=$_GET['producto'];
$tons=$_GET['tons'];
$salida=$_GET['fecha'];
$accion=$_GET['accion'];
if (isset($_GET['bodega'])){
	$bodega=$_GET['bodega'];
} else {
	$bodega=0;
}
$lote=$_GET['lote'];
$estado=$_GET['estado'];
switch ($accion) {
	case "dispo":
		$propre="SELECT gc_productos.productosId AS codigo, gc_presentacion.kilos AS kls
		FROM gc_productos
		LEFT JOIN gc_presentacion ON gc_productos.presentacion = gc_presentacion.id
		WHERE gc_productos.productosId =" . $producto;
		$rpropre = mysqli_query($objConexion,$propre) or die('MySql Error1' . mysql_error());
		$ppres = mysqli_fetch_array($rpropre);
		$sacos=$tons/$ppres['kls'];
		if(is_numeric($sacos)) {
			echo $sacos;
			}
		else 
		    {
			echo "Error al calcular numero de sacos";
		}

		break;
	case "exbod":
		if ($bodega != 0){
			$boda="select * from gc_bodegas where Id=" . $bodega;
			$rboda = mysqli_query($objConexion,$boda) or die('MySql Error2' . mysql_error());
			$rsboda=$rboda->fetch_object();
			$bose=$rsboda->Id;
		}
		$expb="select gc_tmpexistencias.bodega as bodid, gc_bodegas.nombre as bodnombre from gc_tmpexistencias left join gc_bodegas on gc_tmpexistencias.bodega = gc_bodegas.id where gc_tmpexistencias.producto=" . $producto . " and gc_tmpexistencias.cantidad_tm > 0";
		$rexpb = mysqli_query($objConexion,$expb) or die('MySql Error3' . mysqli_error($objConexion));
		$selex = "";
		$selex = "<label><span>Bodega</span>";
		$selex .= "<select name='bodega' id='bodega'>";
		$selex .= "<option value='0'>Seleccione</option>";
		while($registro= mysqli_fetch_array($rexpb))
		{
			if ($registro[bodid]!=$bose){
				$selex .= "<option value='" . $registro[bodid] . "'>" . $registro[bodnombre] . "</option>";
			} else {
				$selex .= "<option value='" . $registro[bodid] . "' selected='selected'>" . $registro[bodnombre] . "</option>";				
			}
		}
		$selex .= "</select></label>";
		echo $selex;
		break;
		
	case "valex":
		$siex="select cantidad_tm from gc_tmpexistencias where producto=" . $producto . " and bodega=" . $bodega . " and lote='" . $lote . "'";
		$rsiex = mysqli_query($objConexion,$siex) or die('MySql Error4' . mysql_error());
		$rsiexi = $rsiex->fetch_object();
		if ($rsiexi->cantidad_tm < $tons ){
			echo "<font size=8px color=red>Saldo insuficiente en esta bodega</font>";
		} elseif ($rsiexi->cantidad_tm == $tons) {
			$bsi="select fecha from gc_saldos_iniciales  where producto=" . $producto . " and bodega=" . $bodega . " and lote='" . $lote . "'";
			$rbsi=mysqli_query($objConexion,$bsi) or die('MySql Error4' . mysql_error());
			if (mysqli_num_rows($rbsi)!=0){
				$rsbsi=$rbsi->fetch_object();
				$entrada=$rsbsi->fecha;
			} else {
				$bpf="select min(fecha) as entrada from gc_despachos_producto where producto=" . $producto . " and bodega=" . $bodega . " and lote='" . $lote . "'";
				$rbpf=mysqli_query($objConexion,$bpf) or die('MySql Error4' . mysql_error());
				$rsbpf=$rbpf->fetch_object();
				$entrada=$rsbpf->entrada;
			}
			$tiempo_en_bodega=date_diff(date_create($entrada),date_create($salida));
			echo "<font size=8px color=red>Este despacho finaliza el lote " . $lote . ". Este lote estuvo " . $tiempo_en_bodega->format("%a") . " dias en bodega</font>";
		} else {
			echo "";			
		}
		break;
} 
?>