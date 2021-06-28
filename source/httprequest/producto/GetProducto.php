<?php
    include '../../conexion/Conexion.php';

    header('Content-Type: application/json');

    $codigo = filter_input(INPUT_POST, 'codigo');
    $linea = 0;
    $conn = new Conexion();
    try {
        $query = "SELECT * FROM tbl_producto WHERE producto_id = '$codigo'";
        $conn->conectar();
        $result = mysqli_query($conn->conn,$query) or die (mysqli_error($conn->conn)); 
        $existe = false;
        while($row = mysqli_fetch_array($result)) {
            $existe = true;
            $cantidad = "0";
            $queryCant = "SELECT SUM(inventario_entrada) - SUM(inventario_salida) AS producto_cantidad FROM tbl_inventario WHERE inventario_producto = '".$row['producto_id']."'";
            $resultCant = mysqli_query($conn->conn,$queryCant) or die (mysqli_error($conn->conn)); 
            while($rowCant = mysqli_fetch_array($resultCant)) {
                if($rowCant["producto_cantidad"] != ""){
                    $cantidad = $rowCant["producto_cantidad"];
                }
            }
            echo "{\"producto_id\":\"".$row['producto_id']."\","
                . "\"producto_nombre\":\"".utf8_decode($row['producto_nombre'])."\","
                . "\"producto_descripcion\":\"".utf8_decode($row['producto_descripcion'])."\","
                . "\"producto_coste\":\"".$row['producto_coste']."\","
                . "\"producto_coste_iva\":\"".$row['producto_coste_iva']."\","
                . "\"producto_precio\":\"".$row['producto_precio']."\","
                . "\"producto_precio_iva\":\"".$row['producto_precio_iva']."\","
                . "\"producto_tipo\":\"".$row['producto_tipo']."\","
                . "\"producto_imagen\":\"".$row['producto_imagen']."\","
                . "\"producto_cantidad\":".round($cantidad)."}";
        }
        if(!$existe){
            echo "{}";
        }
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
    }