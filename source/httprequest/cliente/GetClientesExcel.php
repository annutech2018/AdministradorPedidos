<?php
    include '../../conexion/Conexion.php';

    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=clientes.xls");
    
    $rut = filter_input(INPUT_POST, 'rut');
    $nombre = filter_input(INPUT_POST, 'nombre');
    $giro = filter_input(INPUT_POST, 'giro');    
    $mail = filter_input(INPUT_POST, 'mail');    
    $linea = 0;
    $conn = new Conexion();
    try {
        $qryRut = "";
        if($rut != ""){
            $qryRut = " AND cliente_rut LIKE '%$rut%' ";
        }
        $qryNombre = "";
        if($nombre != ""){
            $qryNombre = " AND cliente_nombre LIKE '%$nombre%' ";
        }
        $qryGiro = "";
        if($giro != ""){
            $qryGiro = " AND cliente_giro LIKE '%$giro%' ";
        }
        $qryMail = "";
        if($mail != ""){
            $qryMail = " AND cliente_mail LIKE '%$mail%' ";
        }
        $query = "SELECT * FROM tbl_cliente WHERE 1=1 $qryRut $qryNombre $qryGiro $qryMail ";
        $conn->conectar();
        $result = mysqli_query($conn->conn,$query) or die (mysqli_error($conn->conn)); 
        $clientes = mysqli_num_rows($result);
        $i = 0;
        echo "<table border='1'>";
        echo "<tr><th>RUT</th><th>NOMBRE</th><th>GIRO</th><th>E-MAIL</th><th>TEL&Eacute;FONO</th><th>DIRECCI&Oacute;N</th><th>COMUNA</th><th>CIUDAD</th></tr>";
        while($row = mysqli_fetch_array($result)) {
            echo "<tr><td>".$row['cliente_rut']."</td>"
                . "<td>".utf8_decode($row['cliente_nombre'])."</td>"
                . "<td>".utf8_decode($row['cliente_giro'])."</td>"
                . "<td>".utf8_decode($row['cliente_mail'])."</td>"
                . "<td>".$row['cliente_telefono']."</td>"
                . "<td>".utf8_decode($row['cliente_direccion'])."</td>"
                . "<td>".utf8_decode($row['cliente_comuna'])."</td>"
                . "<td>".utf8_decode($row['cliente_ciudad'])."</td></tr>";
        }
        echo "</table>";
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
    }