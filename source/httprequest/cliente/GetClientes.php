<?php
    include '../../conexion/Conexion.php';

    header('Content-Type: application/json');

    $rut = filter_input(INPUT_POST, 'rut');
    $nombre = filter_input(INPUT_POST, 'nombre');
    $giro = filter_input(INPUT_POST, 'giro');    
    $mail = filter_input(INPUT_POST, 'mail');    
    $linea = 0;
    $conn = new Conexion();
    try {
        $qryRut = "";
        if($rut != ""){
            $qryRut = " AND cliente_rut LIKE '%$rut%' ";
        }
        $qryNombre = "";
        if($nombre != ""){
            $qryNombre = " AND cliente_nombre LIKE '%$nombre%' ";
        }
        $qryGiro = "";
        if($giro != ""){
            $qryGiro = " AND cliente_giro LIKE '%$giro%' ";
        }
        $qryMail = "";
        if($mail != ""){
            $qryMail = " AND cliente_mail LIKE '%$mail%' ";
        }
        $query = "SELECT * FROM tbl_cliente WHERE 1=1 $qryRut $qryNombre $qryGiro $qryMail ";
        $conn->conectar();
        $result = mysqli_query($conn->conn,$query) or die (mysqli_error($conn->conn)); 
        $clientes = mysqli_num_rows($result);
        $i = 0;
        echo "[";
        while($row = mysqli_fetch_array($result)) {
            echo "{\"cliente_rut\":\"".$row['cliente_rut']."\","
                . "\"cliente_nombre\":\"".utf8_decode($row['cliente_nombre'])."\","
                . "\"cliente_giro\":\"".utf8_decode($row['cliente_giro'])."\","
                . "\"cliente_mail\":\"".utf8_decode($row['cliente_mail'])."\","
                . "\"cliente_telefono\":\"".$row['cliente_telefono']."\","
                . "\"cliente_direccion\":\"".utf8_decode($row['cliente_direccion'])."\","
                . "\"cliente_comuna\":\"".utf8_decode($row['cliente_comuna'])."\","
                . "\"cliente_ciudad\":\"".utf8_decode($row['cliente_ciudad'])."\""
                . "}";
            if (($i+1) != $clientes)
            {
                echo ",";
            }
            $i++;
        }
        echo "]";
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
    }