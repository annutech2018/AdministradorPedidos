<?php

class FolioDao{
     public static function getFolio($tipo)
    {
        try {
            $dato = '';
            $query = "SELECT folio_codigo FROM tbl_folio WHERE folio_estado = 0"
                . " AND folio_tipo = '".$tipo."' ORDER BY folio_codigo LIMIT 1";  
            $conn = new Conexion();
            $conn->conectar();
            $result = mysqli_query($conn->conn,$query); 
            if($row = mysqli_fetch_array($result)) {
                $dato= $row['folio_codigo'];
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $dato;
    }
}
