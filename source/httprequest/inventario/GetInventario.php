<?php
    include '../../conexion/Conexion.php';

    $id = filter_input(INPUT_POST, 'id');
    $nombre = filter_input(INPUT_POST, 'nombre');
    $depto = filter_input(INPUT_POST, 'depto');
    $linea = 0;
    $conn = new Conexion();
    try {
        $qryId = "";
        if($id != ""){
            $qryId = " AND producto_id = $id ";
        }
        $qryNombre = "";
        if($nombre != ""){
            $qryNombre = " AND producto_nombre LIKE '%$nombre%' ";
        }
        $qryDepto = "";
        if($depto != ""){
            $qryDepto = " AND departamento_nombre LIKE '%$depto%' ";
        }
        $query = "SELECT * FROM tbl_producto LEFT JOIN tbl_departamento ON "
                . "producto_departamento = departamento_id WHERE 1=1 $qryId $qryNombre $qryDepto LIMIT 100";
        $conn->conectar();
        $result = mysqli_query($conn->conn,$query); 
        while($row = mysqli_fetch_array($result)) {
            $cantidad = "0";
            $queryCant = "SELECT SUM(inventario_entrada) - SUM(inventario_salida) AS producto_cantidad FROM tbl_inventario WHERE inventario_producto = '".$row['producto_id']."'";
            $resultCant = mysqli_query($conn->conn,$queryCant) or die (mysqli_error($conn->conn)); 
            while($rowCant = mysqli_fetch_array($resultCant)) {
                if($rowCant["producto_cantidad"] != ""){
                    $cantidad = $rowCant["producto_cantidad"];
                }
            }
            if($linea % 2 == 0){
                echo "<tr style='background-color:white;'>";
            }
            else{
                echo "<tr'>";
            }
                echo "<td>".$row['producto_id']."</td>";
                echo "<td>".$row['producto_nombre']."</td>";
                echo "<td>".$row['producto_descripcion']."</td>";
                echo "<td>".$row['departamento_nombre']."</td>";
                echo "<td>".$row['producto_precio']."</td>";
                echo "<td>".$cantidad."</td>";
                echo "<td><a onclick=\"abrirModificar(".$row['producto_id'].",$cantidad)\" href=\"javascript:void(0)\">MODIFICAR</a></td>";
            $linea++;
            echo "</tr>";
        }
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
    }
?>   