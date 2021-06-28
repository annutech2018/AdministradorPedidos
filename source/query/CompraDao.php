<?php


class CompraDao {
    
    
    public static function agregar($compra){
        $id = 0;
        $rut = $compra->getRut();
        $razon = $compra->getRazon();
        $giro = $compra->getGiro();
        $direccion = $compra->getDireccion();
        $comuna = $compra->getComuna();
        $ciudad = $compra->getCiudad();
        $tipoDoc = $compra->getTipoDoc();
        $folioDoc = $compra->getFolioDoc();
        $fechaDoc = $compra->getFechaDoc();
        $neto = $compra->getNeto();
        $exento = $compra->getExento();
        $iva = $compra->getIva();
        $total = $compra->getTotal();
        $query = "INSERT INTO tbl_compra(compra_rut, compra_razon_social, compra_giro,"
                . " compra_direccion, compra_comuna, compra_ciudad, compra_folio,"
                . " compra_tipo, compra_fecha_emision, compra_neto, compra_iva, compra_exento,"
                . " compra_total) VALUES "
                . "('$rut','$razon','$giro','$direccion','$comuna','$ciudad','$folioDoc',"
                . "'$tipoDoc','$fechaDoc','$neto','$iva','$exento','$total')"; 
            $conn = new Conexion();
            $conn->conectar();
            if(mysqli_query($conn->conn,$query)){
                $id = mysqli_insert_id($conn->conn);
            }
        return $id;
    }
    
    public static function agregarDetalle($compra,$codigo,$nombre,$cantidad,$precio,$tipo){
        $id = 0;
        $query = "INSERT INTO tbl_compra_detalle(compradetalle_codigo, compradetalle_compra,"
                . " compradetalle_producto_nombre, compradetalle_producto_cantidad, compradetalle_producto_precio,compradetalle_producto_tipo)"
                . " VALUES ('$compra','$codigo','$nombre','$cantidad','$precio','$tipo')"; 
            $conn = new Conexion();
            $conn->conectar();
            if(mysqli_query($conn->conn,$query)){
                $id = 1;
            }
        return $id;
    }
}
