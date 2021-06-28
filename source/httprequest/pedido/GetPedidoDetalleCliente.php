<?php
    include '../../conexion/Conexion.php';

    header('Content-Type: application/json');

    $id = filter_input(INPUT_POST, 'id');

    $conn = new Conexion();
    $conn->conectar();
    try {
        $noExiste = true;
        $query = "SELECT pedido_id,pedido_id_aux FROM tbl_pedido "
                . "WHERE pedido_id_aux = $id";
        $result = mysqli_query($conn->conn,$query);
        while($row = mysqli_fetch_array($result)) {
            $noExiste = false;
            $id = $row["pedido_id"];
            $aux = $row["pedido_id_aux"];
        }
        if($noExiste){
            $query = "SELECT pedido_id,pedido_id_aux FROM tbl_pedido "
                    . "WHERE pedido_id = $id";
            $result = mysqli_query($conn->conn,$query);
            while($row = mysqli_fetch_array($result)) {
                $id = $row["pedido_id"];
                $aux = $row["pedido_id_aux"];
            }   
        }
        
        if($aux != "0"){
            $query2 = "SELECT * FROM tbl_pedido JOIN tbl_detalle ON pedido_id = detalle_pedido "
                . "WHERE pedido_id_aux = $aux ";
        } else{
            $query2 = "SELECT * FROM tbl_pedido JOIN tbl_detalle ON pedido_id = detalle_pedido "
                . "WHERE pedido_id = $id";
        }
        $result2 = mysqli_query($conn->conn,$query2);
        $detalles = mysqli_num_rows($result2);
        $i = 0;
        echo "[";
        while($row2 = mysqli_fetch_array($result2)) {
            $date = new DateTime($row2['pedido_fecha']);       
            $hora = new DateTime($row2['pedido_fecha']);       
            echo "{\"pedido_id\":\"".$row2['pedido_id']."\","
                . "\"pedido_id_aux\":\"".$row2['pedido_id_aux']."\","
                . "\"pedido_fecha\":\"".$date->format('d/m/Y')."\","
                . "\"pedido_hora\":\"".$date->format('H:i')."\","
                . "\"pedido_descuento\":\"".$row2['pedido_descuento']."\","
                . "\"pedido_total\":\"".$row2['pedido_total']."\","
                . "\"pedido_estado\":\"".$row2['pedido_estado']."\","
                . "\"pedido_cliente\":\"".str_replace(array("\n", "\r"), '', addslashes($row2['pedido_cliente']))."\","
                . "\"pedido_cliente_nombre\":\"".preg_replace('/\s+/', ' ', $row2['pedido_cliente_nombre'])."\","
                . "\"pedido_cliente_direccion\":\"".str_replace(array("\n", "\r"), '', addslashes($row2['pedido_cliente_direccion']))."\","
                . "\"pedido_cliente_comuna\":\"".str_replace(array("\n", "\r"), '', addslashes($row2['pedido_cliente_comuna']))."\","
                . "\"pedido_cliente_telefono\":\"".$row2['pedido_cliente_telefono']."\","
                . "\"pedido_cliente_mail\":\"".str_replace(array("\n", "\r"), '', addslashes($row2['pedido_cliente_mail']))."\","
                . "\"pedido_ig\":\"".$row2['pedido_ig']."\","
                . "\"pedido_observacion\":\"".str_replace(array("\n", "\r"), '', addslashes($row2['pedido_observacion']))."\","
                . "\"pedido_despachado\":\"".$row2['pedido_despachado']."\","
                . "\"pedido_adicional\":\"".$row2['pedido_envio_adicional']."\","
                . "\"pedido_codigo_pago\":\"".$row2['pedido_codigo_pago']."\","
                . "\"pedido_codigo_despacho\":\"".$row2['pedido_codigo_despacho']."\","
                . "\"pedido_adjunto_pago\":\"".$row2['pedido_adjunto_pago']."\","
                . "\"pedido_adjunto_despacho\":\"".$row2['pedido_adjunto_despacho']."\","
                . "\"detalle_pedido\":\"".$row2['pedido_id']."\","
                . "\"producto_id\":\"".$row2['detalle_producto']."\","
                . "\"producto_nombre\":\"".$row2['detalle_producto_nombre']."\","
                . "\"producto_precio\":\"".$row2['detalle_producto_precio']."\","
                . "\"producto_precio_iva\":\"".$row2['detalle_producto_precio_iva']."\","
                . "\"detalle_cantidad\":\"".$row2['detalle_cantidad']."\"}";
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