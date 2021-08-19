<?php
include 'dao/InsumoProductoDao.php';
include 'dominio/Producto.php';
include '../../conexion/Conexion.php';

header('Content-Type: application/json');

$id = addslashes(filter_input(INPUT_POST, 'id'));
$insumo = InsumoProductoDao::obtenerInsumo($id);
if ($insumo->getId() != "")
{
    echo "{\"id\":\"".$insumo->getId()."\","
        . "\"codigo\":\"".addslashes($insumo->getCodigo())."\","
        . "\"nombre\":\"".addslashes($insumo->getNombre())."\","
        . "\"descripcion\":\"".addslashes($insumo->getDescripcion())."\","
        . "\"precio\":".$insumo->getPrecio().","
        . "\"precioIva\":".$insumo->getPrecioIva().","
        . "\"costo\":".$insumo->getCosto().","
        . "\"costoIva\":".$insumo->getCostoIva().","
        . "\"tipo\":".$insumo->getTipo().","
        . "\"imagen\":\"".$insumo->getImagen()."\","
        . "\"unidad\":\"".$insumo->getUnidad()."\""
        ."}";
}