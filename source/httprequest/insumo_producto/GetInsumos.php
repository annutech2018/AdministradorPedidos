<?php
include 'dao/InsumoProductoDao.php';
include 'dominio/Producto.php';
include '../../conexion/Conexion.php';

header('Content-Type: application/json');

$insumos = InsumoProductoDao::obtenerInsumos();
echo "[";
for($i = 0; $i < count($insumos);$i++) {
    $insumo = $insumos[$i];
    echo "{\"id\":\"".$insumo->getId()."\","
        . "\"codigo\":\"".addslashes($insumo->getCodigo())."\","
        . "\"nombre\":\"".addslashes($insumo->getNombre())."\","
        . "\"descripcion\":\"".addslashes($insumo->getDescripcion())."\","
        . "\"precio\":".$insumo->getPrecio().","
        . "\"precioIva\":".$insumo->getPrecioIva().","
        . "\"costo\":".$insumo->getCosto().","
        . "\"costoIva\":".$insumo->getCostoIva().","
        . "\"tipo\":".$insumo->getTipo().","
        . "\"imagen\":\"".$insumo->getImagen()."\""
        ."}";
    if (($i+1) != count($insumos)){
        echo ",";
    }
}
echo "]";