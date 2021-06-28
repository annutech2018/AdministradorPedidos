<?php
include '../../query/LogDao.php';
header('Content-Type: application/json');
$codigo = filter_input(INPUT_POST, 'codigo');
$conn = new Conexion();
$conn->conectar();


$cantidad = 0;
$queryCant = "SELECT SUM(inventario_entrada) - SUM(inventario_salida) AS producto_cantidad FROM tbl_inventario WHERE inventario_producto = '".$codigo."'";
$resultCant = mysqli_query($conn->conn,$queryCant) or die (mysqli_error($conn->conn)); 
while($rowCant = mysqli_fetch_array($resultCant)) {
    if($rowCant["producto_cantidad"] != ""){
        $cantidad = round($rowCant["producto_cantidad"]);
    }
}

if($cantidad > 0){
    echo "{\"error\":\"No se puede eliminar un producto con existencias\"}"; 
    return;
}

$query = "DELETE FROM tbl_producto WHERE producto_id = '$codigo'";
if (mysqli_query($conn->conn,$query)) {
    $id = mysqli_insert_id($conn->conn);
    LogDao::insertarLog("PRODUCTO ELIMINADO CON EL ID: ".$codigo, 15);
    echo "{\"mensaje\":\"Producto eliminado\"}";
    $query = "DELETE FROM tbl_inventario WHERE inventario_producto = '$codigo'";
    mysqli_query($conn->conn,$query);
} else {
    if(strpos(mysqli_error($conn->conn),"fk_prod_deta") == true){
        echo "{\"error\":\"No se pueden eliminar productos usados en ventas anteriores\"}";   
    }
    else{
        echo "{\"error\":\"Error: ".mysqli_error($conn->conn)."\"}";
    }
}

