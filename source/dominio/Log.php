<?php

class Log {
    private $id;
    private $resumen;
    private $usuario;
    private $fecha;
    private $ip;
    private $tipo;
    
    function getId() {
        return $this->id;
    }

    function getResumen() {
        return $this->resumen;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getIp() {
        return $this->ip;
    }

    function getTipo() {
        return $this->tipo;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setResumen($resumen) {
        $this->resumen = $resumen;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setIp($ip) {
        $this->ip = $ip;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }


}
