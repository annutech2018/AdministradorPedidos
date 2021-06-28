<?php
    include '../../conexion/Conexion.php';

    header('Content-Type: application/json');

    $id = filter_input(INPUT_POST, 'id');

    $conn = new Conexion();
    try {
        
        $query = "SELECT * FROM tbl_pedido JOIN tbl_detalle ON pedido_id = detalle_pedido "
                . "WHERE pedido_id = $id";
        $conn->conectar();
        $result = mysqli_query($conn->conn,$query);
        $detalles = mysqli_num_rows($result);
        $i = 0;
        echo "[";
        while($row = mysqli_fetch_array($result)) {
            $date = new DateTime($row['pedido_fecha']);       
            $hora = new DateTime($row['pedido_fecha']);       
            echo "{\"pedido_id\":\"".$row['pedido_id']."\","
                . "\"pedido_id_aux\":\"".$row['pedido_id_aux']."\","
                . "\"pedido_fecha\":\"".$date->format('d/m/Y')."\","
                . "\"pedido_hora\":\"".$date->format('H:i')."\","
                . "\"pedido_descuento\":\"".$row['pedido_descuento']."\","
                . "\"pedido_total\":\"".$row['pedido_total']."\","
                . "\"pedido_estado\":\"".$row['pedido_estado']."\","
                . "\"pedido_cliente\":\"".str_replace(array("\n", "\r"), '', addslashes($row['pedido_cliente']))."\","
                . "\"pedido_cliente_nombre\":\"".preg_replace('/\s+/', ' ', $row['pedido_cliente_nombre'])."\","
                . "\"pedido_cliente_direccion\":\"".str_replace(array("\n", "\r"), '', addslashes($row['pedido_cliente_direccion']))."\","
                . "\"pedido_cliente_comuna\":\"".str_replace(array("\n", "\r"), '', addslashes($row['pedido_cliente_comuna']))."\","
                . "\"pedido_cliente_telefono\":\"".$row['pedido_cliente_telefono']."\","
                . "\"pedido_cliente_mail\":\"".str_replace(array("\n", "\r"), '', addslashes($row['pedido_cliente_mail']))."\","
                . "\"pedido_ig\":\"".$row['pedido_ig']."\","
                . "\"pedido_observacion\":\"".str_replace(array("\n", "\r"), '', addslashes($row['pedido_observacion']))."\","
                . "\"pedido_despachado\":\"".$row['pedido_despachado']."\","
                . "\"pedido_adicional\":\"".$row['pedido_envio_adicional']."\","
                . "\"pedido_codigo_pago\":\"".$row['pedido_codigo_pago']."\","
                . "\"pedido_codigo_despacho\":\"".$row['pedido_codigo_despacho']."\","
                . "\"pedido_adjunto_pago\":\"".$row['pedido_adjunto_pago']."\","
                . "\"pedido_adjunto_despacho\":\"".$row['pedido_adjunto_despacho']."\","
                . "\"detalle_pedido\":\"".$row['pedido_id']."\","
                . "\"producto_id\":\"".$row['detalle_producto']."\","
                . "\"producto_nombre\":\"".$row['detalle_producto_nombre']."\","
                . "\"producto_precio\":\"".$row['detalle_producto_precio']."\","
                . "\"producto_precio_iva\":\"".$row['detalle_producto_precio_iva']."\","
                . "\"detalle_cantidad\":\"".$row['detalle_cantidad']."\"}";
            if (($i+1) != $detalles){
                echo ",";
            }
            $i++;
        }
        echo "]";
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
    }
?>   