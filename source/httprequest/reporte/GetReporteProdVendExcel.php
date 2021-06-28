<?php
    include '../../conexion/Conexion.php';

    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=mas_vendidos.xls");

    $cliente = filter_input(INPUT_GET, 'cliente');
    $desde ='';
    $hasta='';
    if(filter_input(INPUT_GET, 'desde') != ''){
        $desde = DateTime::createFromFormat('d/m/Y', filter_input(INPUT_POST, 'desde'))->format('Y/m/d');
    }else{
        $desde = '2000-01-01 00:00:00';
    }
    if(filter_input(INPUT_GET, 'hasta') != ''){
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
        echo "<table border='1'>";
        echo "<tr><th>ITEM</th><th>CANTIDAD</th>";
        while($row = mysqli_fetch_array($result)) {            
            echo "<tr><td>(".$row["detalle_producto"].") ".$row["detalle_producto_nombre"]."</td>";
            echo "<td>".$row["cantidad"]."</td></tr>";
        }
        echo "</table>";
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
    }
?>   
 