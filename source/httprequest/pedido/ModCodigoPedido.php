<?php
    include '../../conexion/Conexion.php';

    header('Content-Type: application/json');

    session_start();
    if($_SESSION['tipo'] == '2'){
        exit();
    }
    
    $id = filter_input(INPUT_POST, 'id');
    $codigo = filter_input(INPUT_POST, 'codigo');
    $tipo = filter_input(INPUT_POST, 'tipo');

    $conn = new Conexion();
    try {
        $query = "";
        if($tipo == "0"){
            $query = "UPDATE tbl_pedido SET pedido_codigo_pago = '$codigo' WHERE pedido_id = ".$id;
        } else{
            $query = "UPDATE tbl_pedido SET pedido_codigo_despacho = '$codigo' WHERE pedido_id = ".$id;
        }
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