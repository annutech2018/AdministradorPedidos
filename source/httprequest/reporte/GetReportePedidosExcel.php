<?php
    include '../../conexion/Conexion.php';

    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=detalle_pedidos.xls");
    
    $cliente = filter_input(INPUT_POST, 'cliente');
    $desde ='';
    $hasta='';
    if(filter_input(INPUT_POST, 'desde') != ''){
        $desde = DateTime::createFromFormat('d/m/Y', filter_input(INPUT_POST, 'desde'))->format('Y/m/d');
    }else{
        $desde = '2000-01-01 00:00:00';
    }
    if(filter_input(INPUT_POST, 'hasta') != ''){
        $hasta = DateTime::createFromFormat('d/m/Y', filter_input(INPUT_POST, 'hasta'))->format('Y/m/d');
    }else{
        $hasta = '2100-01-01 00:00:00';
    }
    
    $conn = new Conexion();
    try {
        
        $query = "SELECT pedido_estado,count(*) as pedido_total FROM tbl_pedido "
                . "WHERE pedido_fecha >= '$desde' AND pedido_fecha <= '$hasta' GROUP BY pedido_estado ORDER BY pedido_estado"; 
        $conexion = new Conexion();
        $conexion->conectar();
        $result = mysqli_query($conexion->conn,$query); 
        $detalles = mysqli_num_rows($result);
        $i = 0;
        echo "<table border='1'>";
        echo "<tr><th>ITEM</th><th>CANTIDAD</th></tr>";
        while($row = mysqli_fetch_array($result)) {            
            $aux = "";
            if($row["pedido_estado"] == "0"){
                $aux = "PEDIDOS CREADOS";
            } else if($row["pedido_estado"] == "1"){
                $aux = "PEDIDOS ACEPTADOS";
            } else if($row["pedido_estado"] == "2"){
                $aux = "PEDIDOS DESPACHADOS";
            } else if($row["pedido_estado"] == "3"){
                $aux = "PEDIDOS ENTREGADOS";
            } else if($row["pedido_estado"] == "4"){
                $aux = "PEDIDOS ANULADOS";
            }
            echo "<tr><td>".$aux."</td><td>".$row["pedido_total"]."</td></tr>";
        }
        echo "</table>";
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
    }
?>   
 