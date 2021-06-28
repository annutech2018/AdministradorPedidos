<?php

class Compra {
    private $rut;
    private $razon;
    private $giro;
    private $direccion;
    private $comuna;
    private $ciudad;
    private $tipoDoc;
    private $folioDoc;
    private $fechaDoc;
    private $neto;
    private $exento;
    private $iva;
    private $total;
    
    function getRut() {
        return $this->rut;
    }

    function getRazon() {
        return $this->razon;
    }

    function getGiro() {
        return $this->giro;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function getComuna() {
        return $this->comuna;
    }

    function getCiudad() {
        return $this->ciudad;
    }

    function getTipoDoc() {
        return $this->tipoDoc;
    }

    function getFolioDoc() {
        return $this->folioDoc;
    }

    function getFechaDoc() {
        return $this->fechaDoc;
    }

    function getNeto() {
        return $this->neto;
    }

    function getExento() {
        return $this->exento;
    }

    function getIva() {
        return $this->iva;
    }

    function getTotal() {
        return $this->total;
    }

    function setRut($rut) {
        $this->rut = $rut;
    }

    function setRazon($razon) {
        $this->razon = $razon;
    }

    function setGiro($giro) {
        $this->giro = $giro;
    }

    function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    function setComuna($comuna) {
        $this->comuna = $comuna;
    }

    function setCiudad($ciudad) {
        $this->ciudad = $ciudad;
    }

    function setTipoDoc($tipoDoc) {
        $this->tipoDoc = $tipoDoc;
    }

    function setFolioDoc($folioDoc) {
        $this->folioDoc = $folioDoc;
    }

    function setFechaDoc($fechaDoc) {
        $this->fechaDoc = $fechaDoc;
    }

    function setNeto($neto) {
        $this->neto = $neto;
    }

    function setExento($exento) {
        $this->exento = $exento;
    }

    function setIva($iva) {
        $this->iva = $iva;
    }

    function setTotal($total) {
        $this->total = $total;
    }


}
