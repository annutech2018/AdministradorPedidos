<?php

class Conexion {
    
    private $host="127.0.0.1";
    private $user="root";
    private $pass="";
    private $dbname="pedidos_v3";

    public $conn;
    
    function conectar()
    {       
        $this->conn = mysqli_connect($this->host,$this->user,$this->pass, $this->dbname);
        return $this->conn;
    }
    
    function desconectar()
    {
        mysqli_close($this->conn);
    }
}