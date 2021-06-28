<?php
    include '../../conexion/Conexion.php';

    header('Content-Type: application/json');
    
    $nombre = filter_input(INPUT_POST, 'nombre');
    $linea = 0;
    $conn = new Conexion();
    try {
        $qryNombre = "";
        if($nombre != ""){
            $qryNombre = " AND usuario_nombre LIKE '%$nombre%' ";
        }
        $query = "SELECT * FROM tbl_usuario WHERE 1=1 $qryNombre LIMIT 100";
        $conn->conectar();
        $result = mysqli_query($conn->conn,$query) or die (mysqli_error($conn->conn)); 
        $usuarios = mysqli_num_rows($result);
        $i = 0;
        echo "[";
        while($row = mysqli_fetch_array($result)) {
            echo "{\"usuario_id\":\"".$row['usuario_id']."\","
            . "\"usuario_nombre\":\"".utf8_decode($row['usuario_nombre'])."\","
            . "\"usuario_tipo\":\"".$row['usuario_tipo']."\"}";
            if (($i+1) != $usuarios)
            {
                echo ",";
            }
            $i++;
        }
        echo "]";
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
    }