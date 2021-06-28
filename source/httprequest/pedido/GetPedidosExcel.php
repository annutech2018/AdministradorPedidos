<?php
    include '../../conexion/Conexion.php';
    include '../../util/Funciones.php';

    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=pedidos.xls");
    
    $id = filter_input(INPUT_POST, 'id');
    $estado = filter_input(INPUT_POST, 'estado');
    $cliente = filter_input(INPUT_POST, 'cliente');
    $usuario = filter_input(INPUT_POST, 'usuario');
    $telefono = filter_input(INPUT_POST, 'telefono');
    
    if(filter_input(INPUT_POST, 'desde') != '')
    {
        $desde = DateTime::createFromFormat('d/m/Y', filter_input(INPUT_POST, 'desde'))->format('Y/m/d');
    }
    else
    {
        $desde = '2000-01-01 00:00:00';
    }
    if(filter_input(INPUT_POST, 'hasta') != '')
    {
        $hasta = DateTime::createFromFormat('d/m/Y', filter_input(INPUT_POST, 'hasta'))->format('Y/m/d');
    }
    else
    {
        $hasta = '2100-01-01 00:00:00';
    }
    
    $conn = new Conexion();
    try {
        $qryId = "";
        $qryEstado = "";
        $qryUser = "";
        $qryTel = "";
        $qryClien = "";
        
        if($id != ""){
            $qryId = " AND pedido_id = '$id' ";
        }
        if($estado != ""){
            $qryEstado = " AND pedido_estado = '$estado' ";            
        }
        if($usuario != ""){
            $qryUser = " AND pedido_usuario = '$usuario' ";            
        }
        if($telefono != ""){
            $qryTel = " AND pedido_cliente_telefono = '$telefono' ";            
        }
        if($cliente != ""){
            $qryClien = " AND pedido_cliente = '$cliente' ";            
        }
        $query = "SELECT * FROM tbl_pedido JOIN tbl_detalle ON pedido_id = detalle_pedido"
                . " LEFT JOIN tbl_usuario ON pedido_usuario = usuario_id "
                . " WHERE pedido_fecha BETWEEN '$desde' AND '$hasta' "
                . "".$qryId.$qryEstado.$qryUser.$qryTel.$qryClien."  "
                . "GROUP BY pedido_id  ORDER BY pedido_id DESC";
        $conn->conectar();
        $result = mysqli_query($conn->conn,$query);
        $detalles = mysqli_num_rows($result);
        $i = 0;
        echo "<table border='1'>";
        echo "<tr><th>ID PEDIDO</th><th>FECHA</th><th>ESTADO</th><th>TOTAL</th><th>VENDEDOR</th><th>CLIENTE</th><th>TEL&Eacute;FONO</th><th>DESPACHADO POR</th><th>C&Oacute;DIGO</th></tr>";
        while($row = mysqli_fetch_array($result)) {    
            $estado = "";
            if($row["pedido_estado"] == '0'){
                $estado = 'CREADO';
            } else if($row["pedido_estado"] == '1'){
                $estado = 'ACEPTADO';
            } else if($row["pedido_estado"] == '2'){
                $estado = 'DESPACHADO';
            } else if($row["pedido_estado"] == '3'){
                $estado = 'ENTREGADO';
            }
            $codigo = "";
            $largo = 13 - strlen($row["pedido_id"]);
            for($i = 0; $i < $largo;$i++){
                $codigo.="0";
            }
            $codigo.=$row["pedido_id"];
            $id = $row["pedido_id"];
            if($row["pedido_id_aux"] != '0'){
                $id = $row["pedido_id_aux"]. '('.$row["pedido_id"].')';
            }
            echo "<tr><td>".$id."</td><td>".$row["pedido_fecha"]."</td><td>".$estado."</td><td>".
            round($row["pedido_total"])."</td><td>".utf8_encode($row["usuario_nombre"])."</td><td>".utf8_decode($row["pedido_cliente_nombre"]).
                    "</td><td>".$row["pedido_cliente_telefono"]."</td><td>".$row["pedido_despachado"]."</td><td>".$codigo.".</td></tr>";
        }
        echo "</table>";
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
    }
?>   
 