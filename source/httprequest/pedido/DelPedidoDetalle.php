<?php
include '../../query/LogDao.php';
header('Content-Type: application/json');
$id = filter_input(INPUT_POST, 'id');
$conn = new Conexion();
$conn->conectar();
$query = "DELETE FROM tbl_detalle WHERE detalle_pedido = '$id'";
if (mysqli_query($conn->conn,$query)) {
    echo "{\"mensaje\":\"1\"}";
} else {
    echo mysqli_error($conn->conn);
}

