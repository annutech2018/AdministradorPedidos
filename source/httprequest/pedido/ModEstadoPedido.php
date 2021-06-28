<?php
    include '../../conexion/Conexion.php';

    header('Content-Type: application/json');

    session_start();
    if($_SESSION['tipo'] == '1'){
        exit();
    }
    
    $id = filter_input(INPUT_POST, 'id');
    $estado = filter_input(INPUT_POST, 'estado');

    $conn = new Conexion();
    try {
        
        $query = "UPDATE tbl_pedido SET pedido_estado = '$estado' WHERE pedido_id = ".$id;
        $conn->conectar();
        if (mysqli_query($conn->conn,$query) or die(mysqli_error($conn->conn))) {
            echo "{\"mensaje\":\"1\"}";
        } else {
            echo "{\"mensaje\":\"0\"}";
        }
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
    }
?>   