<?php
include '../../query/LogDao.php';
header('Content-Type: application/json');
ini_set('default_charset', 'ISO-8859-1');
$codigo = filter_input(INPUT_POST, 'codigo');
$nombre = filter_input(INPUT_POST, 'nombre');
$descripcion = filter_input(INPUT_POST, 'descripcion');
$precioCosto = filter_input(INPUT_POST, 'precioCosto');
$precioVenta = filter_input(INPUT_POST, 'precioVenta');
$imagen = filter_input(INPUT_POST, 'imagen');
$existencia = filter_input(INPUT_POST, 'existencia');
$entrada = filter_input(INPUT_POST, 'addStock');
$salida = filter_input(INPUT_POST, 'delStock');
session_start();
$usuario = $_SESSION["agente"];
$conn = new Conexion();
$conn->conectar();
$costoAux = $precioCosto / 1.19;
$costoIvaAux = $costoAux * 0.19;
$precioAux = $precioVenta / 1.19;
$precioIvaAux = $precioAux * 0.19;
$query = "INSERT INTO tbl_producto(producto_id, producto_nombre, producto_descripcion,"
        . " producto_precio,producto_precio_iva,producto_coste,producto_coste_iva,producto_imagen,"
        . " producto_usuario)"
        . " VALUES ('$codigo','$nombre','$descripcion',$precioAux,$precioIvaAux,$costoAux,$costoIvaAux,'$imagen',"
        . "'$usuario')";
if (mysqli_query($conn->conn,$query)) {
    LogDao::insertarLog("PRODUCTO AGREGADO CON EL ID: ".$codigo, 13);
    $query = "INSERT INTO tbl_inventario (inventario_producto,inventario_entrada,inventario_salida) VALUES ('$codigo',$entrada,0);";
    mysqli_query($conn->conn,$query);
    LogDao::insertarLog("INGRESO INVENTARIO: CODIGO=$codigo ENTRADAS=$entrada SALIDAS=0", 28);
    echo "{\"mensaje\":\"Producto agregado\"}";
}
else{
    echo "{\"error\":\"Error: ".mysqli_error($conn->conn)."\"}";
}