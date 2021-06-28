<?php
    include '../../conexion/Conexion.php';

    header('Content-Type: application/json');

    $nombre = filter_input(INPUT_POST, 'nombre');
    $linea = 0;
    $conn = new Conexion();
    try {
        $query = "SELECT * FROM tbl_producto WHERE producto_nombre = '$nombre'";
        $conn->conectar();
        $result = mysqli_query($conn->conn,$query) or die (mysqli_error($conn->conn)); 
        while($row = mysqli_fetch_array($result)) {
            $cantidad = "0";
            $queryCant = "SELECT SUM(inventario_entrada) - SUM(inventario_salida) AS producto_cantidad FROM tbl_inventario WHERE inventario_producto = '".$row['producto_id']."'";
            $resultCant = mysqli_query($conn->conn,$queryCant) or die (mysqli_error($conn->conn)); 
            while($rowCant = mysqli_fetch_array($resultCant)) {
                if($rowCant["producto_cantidad"] != ""){
                    $cantidad = $rowCant["producto_cantidad"];
                }
            }
            echo "{\"producto_id\":\"".$row['producto_id']."\","
                . "\"producto_nombre\":\"".$row['producto_nombre']."\","
                . "\"producto_descripcion\":\"".$row['producto_descripcion']."\","
                . "\"producto_coste\":\"".$row['producto_coste']."\","
                . "\"producto_coste_iva\":\"".$row['producto_coste_iva']."\","
                . "\"producto_precio\":\"".$row['producto_precio']."\","
                . "\"producto_precio_iva\":\"".$row['producto_precio_iva']."\","
                . "\"producto_dep_id\":\"".$row['departamento_id']."\","
                . "\"producto_dep_nombre\":\"".$row['departamento_nombre']."\","
                . "\"producto_tipo\":\"".$row['producto_tipo']."\","
                . "\"producto_imagen\":\"".$row['producto_imagen']."\","
                . "\"producto_descuento_nuevo\":\"".$row['producto_descuento_nuevo']."\","
                . "\"producto_descuento_normal\":\"".$row['producto_descuento_normal']."\","
                . "\"producto_descuento_premium\":\"".$row['producto_descuento_premium']."\","
                . "\"producto_mostrar_en_catalogo\":\"".$row['producto_mostrar_en_catalogo']."\","    
                . "\"producto_cantidad\":\"".round($cantidad,2)."\"}";
        }
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
    }