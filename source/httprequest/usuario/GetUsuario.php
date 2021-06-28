<?php
    include '../../conexion/Conexion.php';

    header('Content-Type: application/json');

    $id = filter_input(INPUT_POST, 'id');
    $linea = 0;
    $conn = new Conexion();
    try {
        $query = "SELECT * FROM tbl_usuario WHERE usuario_id = '$id'";
        $conn->conectar();
        $result = mysqli_query($conn->conn,$query) or die (mysqli_error($conn->conn)); 
        while($row = mysqli_fetch_array($result)) {
            echo "{\"usuario_id\":\"".$row['usuario_id']."\","
                . "\"usuario_nombre\":\"".utf8_decode($row['usuario_nombre'])."\","
                . "\"usuario_tipo\":\"".$row['usuario_tipo']."\""
                ."}";
        }
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
    }