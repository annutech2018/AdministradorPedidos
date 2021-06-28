<?php
include '../../query/LogDao.php';
header('Content-Type: application/json');
ini_set('default_charset', 'ISO-8859-1');

$codigo = filter_input(INPUT_POST, 'codigo');
$nombre= filter_input(INPUT_POST, 'nombre');
$precio = filter_input(INPUT_POST, 'precio') / 1.19;
$precioIva = $precio * 0.19;
$cantidad = filter_input(INPUT_POST, 'cantidad');
$pedido = filter_input(INPUT_POST, 'pedido');

$conn = new Conexion();
$conn->conectar();
$query = "INSERT INTO tbl_detalle (detalle_producto,detalle_producto_nombre,detalle_producto_precio,"
        . "detalle_producto_precio_iva,detalle_cantidad,detalle_pedido)"
        . " VALUES ('$codigo','$nombre','$precio','$precioIva','$cantidad','$pedido');";
mysqli_query($conn->conn,$query);

$query = "INSERT INTO tbl_inventario (inventario_producto,inventario_entrada,inventario_salida) VALUES ('$codigo',0,$cantidad);";
mysqli_query($conn->conn,$query);