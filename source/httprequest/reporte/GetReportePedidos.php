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
        
        $query = "SELECT pedido_estado,count(*) as pedido_total FROM tbl_pedido "
                . "WHERE pedido_fecha >= '$desde' AND pedido_fecha <= '$hasta' GROUP BY pedido_estado ORDER BY pedido_estado"; 
        $conexion = new Conexion();
        $conexion->conectar();
        $result = mysqli_query($conexion->conn,$query); 
        $detalles = mysqli_num_rows($result);
        $i = 0;
        echo "[";
        while($row = mysqli_fetch_array($result)) {            
            $aux = "";
            if($row["pedido_estado"] == "0"){
                $aux = "PEDIDOS CREADOS";
            } else if($row["pedido_estado"] == "1"){
                $aux = "PEDIDOS ACEPTADOS";
            } else if($row["pedido_estado"] == "2"){
                $aux = "PEDIDOS DESPACHADOS";
            } else if($row["pedido_estado"] == "3"){
                $aux = "PEDIDOS ENTREGADOS";
            } else if($row["pedido_estado"] == "4"){
                $aux = "PEDIDOS ANULADOS";
            }
            echo "{\"reporte_item\":\"".$aux."\","
            . "\"reporte_valor\":\"".$row["pedido_total"]."\"}";
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
 