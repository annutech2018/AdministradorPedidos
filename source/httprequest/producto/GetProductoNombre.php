<?php
    include '../../conexion/Conexion.php';

    header('Content-Type: application/json');

    $nombre = filter_input(INPUT_POST, 'nombre');
    $nivel = filter_input(INPUT_POST, 'nivel');
    $linea = 0;
    $conn = new Conexion();
    try {
        $query = "SELECT * FROM tbl_producto WHERE producto_nombre = '$nombre' AND producto_nivel = $nivel";
        $conn->conectar();
        $result = mysqli_query($conn->conn,$query) or die (mysqli_error($conn->conn)); 
        while($row = mysqli_fetch_array($result)) {
            $cantidad = "0";
            $queryCant = "SELECT SUM(inventario_entrada) - SUM(inventario_salida) AS producto_cantidad FROM tbl_inventario WHERE inventario_producto = '".$row['producto_id']."' AND inventario_tipo = $nivel";
            $resultCant = mysqli_query($conn->conn,$queryCant) or die (mysqli_error($conn->conn)); 
            while($rowCant = mysqli_fetch_array($resultCant)) {
                if($rowCant["producto_cantidad"] != ""){
                    $cantidad = $rowCant["producto_cantidad"];
                }
            }
            echo "{\"producto_codigo\":\"".$row['producto_codigo']."\","
                . "\"producto_nombre\":\"".$row['producto_nombre']."\","
                . "\"producto_descripcion\":\"".$row['producto_descripcion']."\","
                . "\"producto_coste\":\"".$row['producto_coste']."\","
                . "\"producto_coste_iva\":\"".$row['producto_coste_iva']."\","
                . "\"producto_precio\":\"".$row['producto_precio']."\","
                . "\"producto_precio_iva\":\"".$row['producto_precio_iva']."\","
                . "\"producto_tipo\":\"".$row['producto_tipo']."\","
                . "\"producto_imagen\":\"".$row['producto_imagen']."\","
                . "\"producto_inventario\":\"".$row['producto_inventario']."\","
                . "\"producto_manufacturado\":\"".$row['producto_manufacturado']."\","
                . "\"producto_cantidad\":\"".round($cantidad,2)."\"}";
        }
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
    }