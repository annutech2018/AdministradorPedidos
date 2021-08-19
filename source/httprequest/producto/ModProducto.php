<?php
include '../../query/LogDao.php';
header('Content-Type: application/json');
ini_set('default_charset', 'ISO-8859-1');
$codigo = filter_input(INPUT_POST, 'codigo');
$nombre = filter_input(INPUT_POST, 'nombre');
$descripcion = filter_input(INPUT_POST, 'descripcion');
$precioCosto = filter_input(INPUT_POST, 'precioCosto');
$precioVenta = filter_input(INPUT_POST, 'precioVenta');
$tipo = filter_input(INPUT_POST, 'tipo');
$imagen = filter_input(INPUT_POST, 'imagen');
$existencia = filter_input(INPUT_POST, 'existencia');
$entrada = filter_input(INPUT_POST, 'addStock')==""?"0":filter_input(INPUT_POST, 'addStock');
$salida = filter_input(INPUT_POST, 'delStock')==""?"0":filter_input(INPUT_POST, 'delStock');
$nivel = filter_input(INPUT_POST, 'nivel');
$inventario = filter_input(INPUT_POST, 'inventario')==""?"0":filter_input(INPUT_POST, 'inventario');
$manufacturado = filter_input(INPUT_POST, 'manufacturado')==""?"0":filter_input(INPUT_POST, 'manufacturado');

$conn = new Conexion();
$conn->conectar();

$costoAux = round($precioCosto / 1.19,2);
$costoIvaAux = round($costoAux * 0.19,2);
$precioAux = round($precioVenta / 1.19,2);
$precioIvaAux = round($precioAux * 0.19,2);



$modificaNombre = ", producto_nombre = '$nombre' ";
$modificaDesc = ", producto_descripcion = '$descripcion' ";
$modificaPrecio = ", producto_precio = $precioAux ";
$modificaIva = ", producto_precio_iva = $precioIvaAux ";
$modificaCosto = ", producto_coste = $costoAux ";
$modificaCostoIva = ", producto_coste_iva = $costoIvaAux ";

$query = "UPDATE tbl_producto SET "
        . "producto_imagen = '$imagen', producto_tipo = $tipo,"
        . " producto_inventario = $inventario, producto_manufacturado = $manufacturado "
        . $modificaNombre.$modificaDesc.$modificaPrecio.$modificaIva.$modificaCosto
        . $modificaCostoIva
        . " WHERE producto_codigo = '$codigo' AND producto_nivel = $nivel;";
if (mysqli_query($conn->conn,$query)) {
    $id = mysqli_insert_id($conn->conn);
    LogDao::insertarLog("PRODUCTO MODIFICADO CON EL ID: $codigo%$nombre%$descripcion%$costoAux%$precioAux", 14);
    if($entrada > 0 || $salida > 0){
        if ($entrada != 0){
            $query = "INSERT INTO tbl_inventario (inventario_producto,inventario_entrada,inventario_salida,inventario_tipo) VALUES ('$codigo',$entrada,0,$nivel);";
            mysqli_query($conn->conn,$query);
            LogDao::insertarLog("INGRESO INVENTARIO: CODIGO=$codigo ENTRADAS=$entrada SALIDAS=$salida", 28);
        }
        if ($salida != 0){
            $cantidad = "0";
            $queryCant = "SELECT SUM(inventario_entrada) - SUM(inventario_salida) AS producto_cantidad FROM tbl_inventario WHERE inventario_producto = '".$codigo."'";
            $resultCant = mysqli_query($conn->conn,$queryCant) or die (mysqli_error($conn->conn)); 
            while($rowCant = mysqli_fetch_array($resultCant)) {
                if($rowCant["producto_cantidad"] != ""){
                    $cantidad = $rowCant["producto_cantidad"];
                }
            }
            if (($existencia + $entrada) < $salida){
                echo "{\"error\":\"Se puede quitar un maximo de $existencia a este producto\"}";
                return;
            }
            $query = "INSERT INTO tbl_inventario (inventario_producto,inventario_entrada,inventario_salida) VALUES ('$codigo',0,$salida);";
            mysqli_query($conn->conn,$query);
            LogDao::insertarLog("INGRESO INVENTARIO: CODIGO=$codigo ENTRADAS=0 SALIDAS=$salida", 28);
        }
        
    }
    echo "{\"mensaje\":\"Producto modificado\"}";
} else {
    echo "{\"error\":\"".mysqli_error($conn->conn)."\"}";
}

