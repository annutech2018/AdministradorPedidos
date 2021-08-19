<?php
    include '../../conexion/Conexion.php';

    header('Content-Type: application/json');

    $id = filter_input(INPUT_POST, 'id');
    $estado = filter_input(INPUT_POST, 'estado');
    $cliente = filter_input(INPUT_POST, 'cliente');
    $usuario = filter_input(INPUT_POST, 'usuario');
    $telefono = filter_input(INPUT_POST, 'telefono');
    $ig = filter_input(INPUT_POST, 'ig');
    
    session_start();
    
    if(filter_input(INPUT_POST, 'desde') != '')
    {
        $desde = DateTime::createFromFormat('d/m/Y', filter_input(INPUT_POST, 'desde'))->format('Y/m/d');
    }
    else
    {
        $desde = '2000-01-01 00:00:00';
    }
    if(filter_input(INPUT_POST, 'hasta') != '')
    {
        $hasta = DateTime::createFromFormat('d/m/Y', filter_input(INPUT_POST, 'hasta'))->format('Y/m/d');
    }
    else
    {
        $hasta = '2100-01-01 00:00:00';
    }
    $linea = 0;
    $conn = new Conexion();
    try {
        $qryId = "";
        $qryEstado = "";
        $qryUser = "";
        $qryTel = "";
        $qryIg = "";
        $qryClien = "";
        $qryDespacho = "";
        
        if($id != ""){
            $qryId = " AND pedido_id_aux = '$id' ";
        }
        if($estado != ""){
            $qryEstado = " AND pedido_estado = '$estado' ";
        }
        if($usuario != ""){
            $qryUser = " AND pedido_usuario = '$usuario' ";
        }
        if($telefono != ""){
            $qryTel = " AND pedido_cliente_telefono = '$telefono' ";
        }
        if($ig != ""){
            $qryIg = " AND pedido_ig = '$ig' ";
        }
        if($cliente != ""){
            $qryClien = " AND pedido_cliente = '$cliente' ";
        }
        if($_SESSION["tipo"] == '3'){
            $qryDespacho = " AND pedido_estado NOT IN (0,4) ";
        }
        $query = "SELECT * FROM tbl_pedido JOIN tbl_detalle ON pedido_id = detalle_pedido"
                . " LEFT JOIN tbl_usuario ON pedido_usuario = usuario_id "
                . " WHERE pedido_fecha BETWEEN '$desde' AND '$hasta' "
                . "".$qryId.$qryEstado.$qryUser.$qryTel.$qryIg.$qryClien.$qryDespacho."  "
                . "GROUP BY pedido_id ORDER BY pedido_id DESC LIMIT 300";
        $conn->conectar();
        $result = mysqli_query($conn->conn,$query);
        $ventas = mysqli_num_rows($result);
        $i = 0;
        $noExiste = true;
        echo "[";
        while($row = mysqli_fetch_array($result)) {
            $noExiste = false;
            $date = new DateTime($row['pedido_fecha']);       
            echo "{\"pedido_id\":\"".$row['pedido_id']."\","
                . "\"pedido_id_aux\":\"".$row['pedido_id_aux']."\","
                . "\"pedido_total\":\"".$row['pedido_total']."\","
                . "\"pedido_fecha\":\"".$date->format('d-m-Y H:i')."\","
                . "\"detalle_cantidad\":\"".$row['detalle_cantidad']."\","
                . "\"pedido_codigo_pago\":\"".$row['pedido_codigo_pago']."\","
                . "\"pedido_codigo_despacho\":\"".$row['pedido_codigo_despacho']."\","
                . "\"pedido_adjunto_pago\":\"".$row['pedido_adjunto_pago']."\","
                . "\"pedido_adjunto_despacho\":\"".$row['pedido_adjunto_despacho']."\","
                . "\"pedido_estado\":\"".$row['pedido_estado']."\","
                . "\"pedido_tipo\":\"".$row['pedido_tipo']."\","
                . "\"pedido_despachado\":\"".$row['pedido_despachado']."\","
                . "\"pedido_usuario\":\"".$row['usuario_nombre']."\","
                . "\"pedido_cliente\":\"".$row['pedido_cliente']."\","
                . "\"pedido_cliente_nombre\":\"".preg_replace('/\s+/', ' ', $row['pedido_cliente_nombre'])."\","
                . "\"pedido_cliente_telefono\":\"".$row['pedido_cliente_telefono']."\"}";
            if (($i+1) != $ventas)
            {
                echo ",";
            }
            $i++;
        }
        if($noExiste){
            if($id != ""){
                $qryId = " AND pedido_id = '$id' ";
            }    
            $query = "SELECT * FROM tbl_pedido JOIN tbl_detalle ON pedido_id = detalle_pedido"
                . " LEFT JOIN tbl_usuario ON pedido_usuario = usuario_id "
                . " WHERE pedido_fecha BETWEEN '$desde' AND '$hasta' "
                . "".$qryId.$qryEstado.$qryUser.$qryTel.$qryIg.$qryClien.$qryDespacho."  "
                . "GROUP BY pedido_id ORDER BY pedido_id DESC LIMIT 300";
            $conn->conectar();
            $result = mysqli_query($conn->conn,$query);
            $ventas = mysqli_num_rows($result);
            $i = 0;
            while($row = mysqli_fetch_array($result)) {
                $date = new DateTime($row['pedido_fecha']);       
                echo "{\"pedido_id\":\"".$row['pedido_id']."\","
                    . "\"pedido_id_aux\":\"".$row['pedido_id_aux']."\","
                    . "\"pedido_total\":\"".$row['pedido_total']."\","
                    . "\"pedido_fecha\":\"".$date->format('d-m-Y H:i')."\","
                    . "\"detalle_cantidad\":\"".$row['detalle_cantidad']."\","
                    . "\"pedido_codigo_pago\":\"".$row['pedido_codigo_pago']."\","
                    . "\"pedido_codigo_despacho\":\"".$row['pedido_codigo_despacho']."\","
                    . "\"pedido_adjunto_pago\":\"".$row['pedido_adjunto_pago']."\","
                    . "\"pedido_adjunto_despacho\":\"".$row['pedido_adjunto_despacho']."\","
                    . "\"pedido_estado\":\"".$row['pedido_estado']."\","
                    . "\"pedido_despachado\":\"".$row['pedido_despachado']."\","
                    . "\"pedido_usuario\":\"".$row['usuario_nombre']."\","
                    . "\"pedido_cliente\":\"".$row['pedido_cliente']."\","
                    . "\"pedido_cliente_nombre\":\"".preg_replace('/\s+/', ' ', $row['pedido_cliente_nombre'])."\","
                    . "\"pedido_cliente_telefono\":\"".$row['pedido_cliente_telefono']."\"}";
                if (($i+1) != $ventas)
                {
                    echo ",";
                }
                $i++;
            }
        }
        echo "]";
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
    }
?>