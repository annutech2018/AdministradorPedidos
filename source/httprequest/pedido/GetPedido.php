<?php
    include '../../conexion/Conexion.php';

    header('Content-Type: application/json');

    $id = filter_input(INPUT_POST, 'id');
    $conn = new Conexion();
    try {
        $query = "SELECT * FROM tbl_pedido JOIN tbl_detalle ON pedido_id = detalle_pedido"
                . " LEFT JOIN tbl_usuario ON pedido_usuario = usuario_id "
                . " WHERE pedido_id = '$id'  ";
        $conn->conectar();
        $result = mysqli_query($conn->conn,$query);
        $ventas = mysqli_num_rows($result);
        $cont = "";
        while($row = mysqli_fetch_array($result)) {
            $date = new DateTime($row['pedido_fecha']);       
            $cont = "{\"pedido_id\":\"".$row['pedido_id']."\","
                . "\"pedido_fecha\":\"".$date->format('d-m-Y H:i:s')."\","
                . "\"pedido_cliente_mail\":\"".$row['pedido_cliente_mail']."\","
                . "\"pedido_codigo_pago\":\"".$row['pedido_codigo_pago']."\","
                . "\"pedido_codigo_despacho\":\"".$row['pedido_codigo_despacho']."\","
                . "\"pedido_estado\":\"".$row['pedido_estado']."\"}";
        }
        if($cont == ""){
            $cont = "{}";
        }
        
        echo $cont;
        
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
    }