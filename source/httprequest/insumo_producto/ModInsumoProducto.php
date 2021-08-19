<?php
include 'dao/InsumoProductoDao.php';
include 'dominio/InsumoProducto.php';
include '../../conexion/Conexion.php';

header('Content-Type: application/json');

$insumo = filter_input(INPUT_POST, 'insumo');
$producto = filter_input(INPUT_POST, 'producto');
$cantidad = filter_input(INPUT_POST, 'cantidad');


$id = InsumoProductoDao::modificar($insumo,$producto,$cantidad);
echo "{\"mensaje\":".$id."}";