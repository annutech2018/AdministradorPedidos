<?php

class EnvioDao {
    public static function enviarDocumento($id,$tipo){
        try {
            $dato = '';
            $query = "INSERT INTO tbl_envio(envio_venta,envio_tipo) VALUES ('$id','$tipo')";  
            $conn = new Conexion();
            $conn->conectar();
            mysqli_query($conn->conn,$query); 
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $dato;
    }
}
