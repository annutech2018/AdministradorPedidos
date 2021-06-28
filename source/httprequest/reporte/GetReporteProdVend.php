<?php
    include '../../conexion/Conexion.php';

    header('Content-Type: application/json');

    $cliente = filter_input(INPUT_POST, 'cliente');
    $desde ='';
    $hasta='';
    if(filter_input(INPUT_POST, 'desde') != ''){
        $desde = DateTime::createFromFormat('d/m/Y', filter_input(INPUT_POST, 'desde'))->format('Y/m/d');
    }else{
        $desde = '2000-01-01 00:00:00';
    }
    if(filter_input(INPUT_POST, 'hasta') != ''){
        $hasta = DateTime::createFromFormat('d/m/Y', filter_input(INPUT_POST, 'hasta'))->format('Y/m/d');
    }else{
        $hasta = '2100-01-01 00:00:00';
    }
    
    $conn = new Conexion();
    try {
        
        $query = "SELECT detalle_producto,detalle_producto_nombre,COUNT(detalle_producto) AS cantidad FROM tbl_pedido "
                . "JOIN tbl_detalle ON pedido_id = detalle_pedido WHERE pedido_cliente LIKE '%$cliente%' "
                . "AND pedido_fecha >= '$desde' AND pedido_fecha <= '$hasta' GROUP BY detalle_producto "
                . "ORDER BY COUNT(detalle_producto) DESC LIMIT 20";
        $conn->conectar();
        $result = mysqli_query($conn->conn,$query);
        $detalles = mysqli_num_rows($result);
        $i = 0;
        echo "[";
        while($row = mysqli_fetch_array($result)) {            
            echo "{\"reporte_item\":\"".$row["detalle_producto"]."-".$row["detalle_producto_nombre"]."\","
            . "\"reporte_valor\":\"".$row["cantidad"]."\"}";
            if (($i+1) != $detalles)
            {
                echo ",";
            }
            $i++;
        }
        echo "]";
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
    }
?>   
 