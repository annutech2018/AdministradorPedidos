<?php
    include '../../conexion/Conexion.php';

    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=productos.xls");
    
    $codigo = filter_input(INPUT_GET, 'codigo');
    $nombre = filter_input(INPUT_GET, 'nombre');
    $descripcion = filter_input(INPUT_GET, 'descripcion'); 
    $nivel = filter_input(INPUT_GET, 'nivel');
    $linea = 0;
    $conn = new Conexion();
    try {
        $qryCodigo = "";
        if($codigo != ""){
            $qryCodigo = " AND producto_id LIKE '%$codigo%' ";
        }
        $qryNombre = "";
        if($nombre != ""){
            $qryNombre = " AND producto_nombre LIKE '%$nombre%' ";
        }
        $qryDesc = "";
        if($descripcion != ""){
            $qryDesc = " AND producto_descripcion LIKE '%$descripcion%' ";
        }
        $query = "SELECT * FROM tbl_producto WHERE producto_nivel = $nivel $qryCodigo $qryNombre $qryDesc LIMIT 100";
        $conn->conectar();
        $result = mysqli_query($conn->conn,$query) or die (mysqli_error($conn->conn)); 
        $productos = mysqli_num_rows($result);
        $i = 0;
        echo "<table border='1'>";
        echo "<tr><th>C&Oacute;DIGO</th><th>NOMBRE</th><th>DESCRIPCI&Oacute;N</th><th>PRECIO COSTO</th><th>PRECIO VENTA</th><th>EXISTENCIA</th></tr>";
        while($row = mysqli_fetch_array($result)) {
            $cantidad = "0";
            $queryCant = "SELECT SUM(inventario_entrada) - SUM(inventario_salida) AS producto_cantidad "
                    . "FROM tbl_inventario WHERE inventario_producto = '".$row['producto_id']."' AND inventario_tipo = $nivel";
            $resultCant = mysqli_query($conn->conn,$queryCant) or die (mysqli_error($conn->conn)); 
            while($rowCant = mysqli_fetch_array($resultCant)) {
                if($rowCant["producto_cantidad"] != ""){
                    $cantidad = $rowCant["producto_cantidad"];
                }
            }
                echo "<tr><td>".$row['producto_id']."</td>"
                . "<td>".utf8_decode($row['producto_nombre'])."</td>"
                . "<td>".utf8_decode($row['producto_descripcion'])."</td>"
                . "<td>".round($row['producto_coste']+$row['producto_coste_iva'])."</td>"
                . "<td>".round($row['producto_precio']+$row['producto_precio_iva'])."</td>"
                . "<td>".round($cantidad,2)."</td></tr>";
        }
        echo "</table>";
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
    }