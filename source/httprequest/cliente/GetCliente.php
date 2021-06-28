<?php
    include '../../conexion/Conexion.php';

    header('Content-Type: application/json');

    $rut = filter_input(INPUT_POST, 'rut');
    $linea = 0;
    $conn = new Conexion();
    try {
        $query = "SELECT * FROM tbl_cliente WHERE cliente_rut = '$rut'";
        $conn->conectar();
        $result = mysqli_query($conn->conn,$query) or die (mysqli_error($conn->conn)); 
        while($row = mysqli_fetch_array($result)) {
            echo "{\"cliente_rut\":\"".$row['cliente_rut']."\","
                . "\"cliente_nombre\":\"".utf8_decode($row['cliente_nombre'])."\","
                . "\"cliente_giro\":\"".utf8_decode($row['cliente_giro'])."\","
                . "\"cliente_mail\":\"".utf8_decode($row['cliente_mail'])."\","
                . "\"cliente_telefono\":\"".$row['cliente_telefono']."\","
                . "\"cliente_direccion\":\"".utf8_decode($row['cliente_direccion'])."\","
                . "\"cliente_comuna\":\"".utf8_decode($row['cliente_comuna'])."\","
                . "\"cliente_ciudad\":\"".utf8_decode($row['cliente_ciudad'])."\""
                ."}";
        }
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
    }