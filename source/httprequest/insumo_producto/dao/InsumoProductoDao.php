<?php

class InsumoProductoDao {

    public static function agregar($insumo,$producto,$cantidad){
        $id= 0;
        $conn = new Conexion();
        $conn->conectar();
        $query = "INSERT INTO tbl_insumo_producto(insumoproducto_insumo, insumoproducto_producto, insumoproducto_cantidad)"
                . " VALUES ('".$insumo."','". $producto. "','".$cantidad."')";
        if (mysqli_query($conn->conn,$query) or die (mysqli_error($conn->conn)." ".$query)) {
            $id = 1;

            } else {
            $error = mysqli_error($conexion);
        }
        return $id;
    }
    
     public static function modificar($insumo,$producto,$cantidad){
        $id= 0;
        $conexion = new Conexion();
        $conexion->conectar();
        $query = "UPDATE tbl_insumo_producto SET insumoproducto_cantidad = insumoproducto_cantidad + $cantidad WHERE insumoproducto_insumo = $insumo AND insumoproducto_producto = $producto ";
        if (mysqli_query($conexion->conn,$query) or die (mysqli_error($conexion->conn)." ".$query)) {
            $id = 1;

            }
        return $id;
    }
    
    public static function obtener($id){
        $insumosProductos = array();
        $conexion = new Conexion();
        $conexion->conectar();
        $query = "select * from tbl_producto p join tbl_insumo_producto ip ON p.producto_codigo"
                . " = ip.insumoproducto_insumo where producto_nivel = 0 and ip.insumoproducto_producto = $id";
        $result = mysqli_query($conexion->conn,$query) or die (mysqli_error($conexion->conn)." ".$query); 
        while($row = mysqli_fetch_array($result)) {
            $producto = new Producto();
            $producto->setId($row["producto_id"]);
            $producto->setCodigo($row["producto_codigo"]);
            $producto->setNombre(utf8_decode($row["producto_nombre"]));
            $producto->setDescripcion(utf8_decode($row["producto_descripcion"]));
            $producto->setPrecio($row["producto_precio"]);
            $producto->setPrecioIva($row["producto_precio_iva"]);
            $producto->setCosto($row["producto_coste"]);
            $producto->setCostoIva($row["producto_coste_iva"]);
            $producto->setTipo($row["producto_tipo"]);
            $producto->setCantidad($row["insumoproducto_cantidad"]);
            array_push($insumosProductos, $producto);
        }
        return $insumosProductos;
    }
    
    public static function eliminar($idInsumo,$idProducto){
        $id= 0;
        $conn = new Conexion();
        $conn->conectar();
        $query = "DELETE FROM tbl_insumo_producto WHERE insumoproducto_insumo = $idInsumo AND insumoproducto_producto = $idProducto";
        if (mysqli_query($conn->conn,$query) or die (mysqli_error($conn->conn)." ".$query)) {
            $id = 1;
        } 
        return $id;
    }
    
    public static function obtenerInsumo($id){
        $insumo = new Producto();
        $conn = new Conexion();
        $conn->conectar();
        $query = "SELECT * FROM tbl_producto WHERE producto_codigo = '$id' AND producto_nivel = 0;";
        $result = mysqli_query($conn->conn,$query) or die (mysqli_error($conn->conn)." ".$query); 
        while($row = mysqli_fetch_array($result)) {
            $insumo->setId($row["producto_id"]);
            $insumo->setCodigo($row["producto_codigo"]);
            $insumo->setNombre(utf8_decode($row["producto_nombre"]));
            $insumo->setDescripcion(utf8_decode($row["producto_descripcion"]));
            $insumo->setPrecio($row["producto_precio"]);
            $insumo->setPrecioIva($row["producto_precio_iva"]);
            $insumo->setCosto($row["producto_coste"]);
            $insumo->setCostoIva($row["producto_coste_iva"]);
            $insumo->setTipo($row["producto_tipo"]);
            $insumo->setImagen($row["producto_imagen"]);
        }
        return $insumo;
    }
    
    public static function obtenerInsumos(){
        $insumos = array();
        $conn = new Conexion();
        $conn->conectar();
        $query = "SELECT * FROM tbl_producto WHERE producto_nivel = 0;";
        $result = mysqli_query($conn->conn,$query) or die (mysqli_error($conn->conn)." ".$query); 
        while($row = mysqli_fetch_array($result)) {
            $insumo = new Producto();
            $insumo->setId($row["producto_id"]);
            $insumo->setCodigo($row["producto_codigo"]);
            $insumo->setNombre(utf8_decode($row["producto_nombre"]));
            $insumo->setDescripcion(utf8_decode($row["producto_descripcion"]));
            $insumo->setPrecio($row["producto_precio"]);
            $insumo->setPrecioIva($row["producto_precio_iva"]);
            $insumo->setCosto($row["producto_coste"]);
            $insumo->setCostoIva($row["producto_coste_iva"]);
            $insumo->setTipo($row["producto_tipo"]);
            $insumo->setImagen($row["producto_imagen"]);
            array_push($insumos, $insumo);
        }
        return $insumos;
    }
}