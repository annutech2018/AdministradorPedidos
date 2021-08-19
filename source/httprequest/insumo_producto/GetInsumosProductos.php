<?php
include 'dao/InsumoProductoDao.php';
include 'dominio/InsumoProducto.php';
include 'dominio/Producto.php';
include '../../conexion/Conexion.php';

header('Content-Type: application/json');

$id = addslashes(filter_input(INPUT_POST, 'codigo'));
$insumosProductos = InsumoProductoDao::obtener($id);
echo "[";
for($i = 0; $i < count($insumosProductos);$i++) {
    $producto = $insumosProductos[$i];
     echo "{"
            . "\"id\":\"".$producto->getId()."\","
            . "\"codigo\":\"".addslashes($producto->getCodigo())."\","
            . "\"nombre\":\"".addslashes($producto->getNombre())."\","
            . "\"descripcion\":\"".addslashes($producto->getDescripcion())."\","
            . "\"precio\":".$producto->getPrecio().","
            . "\"precioIva\":".$producto->getPrecioIva().","
            . "\"costo\":".$producto->getCosto().","
            . "\"costoIva\":".$producto->getCostoIva().","
            . "\"tipo\":".$producto->getTipo().","
            . "\"cantidad\":".$producto->getCantidad().""
            . "}";
    if (($i+1) != count($insumosProductos)){
        echo ",";
    }
}
echo "]";