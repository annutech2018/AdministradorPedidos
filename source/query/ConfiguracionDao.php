<?php

class ConfiguracionDao {
    public static function getConfiguracion($clave)
    {
        $dato = "";
        try {
            $query = "SELECT * FROM tbl_configuracion WHERE configuracion_nombre = '$clave'";  
            $conn = new Conexion();
            $conn->conectar();
            $result = mysqli_query($conn->conn,$query); 
            while($row = mysqli_fetch_array($result)) {
                $dato= $row['configuracion_valor'];
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $dato;
    }
}
