<?php
include 'dao/InsumoProductoDao.php';
include 'dominio/InsumoProducto.php';
include '../../conexion/Conexion.php';

header('Content-Type: application/json');

$idInsumo = filter_input(INPUT_POST, 'insumo');
$idProducto = filter_input(INPUT_POST, 'producto');

$id = InsumoProductoDao::eliminar($idInsumo,$idProducto);
echo "{\"mensaje\":".$id."}";