<?php

class InsumoProducto {
    
    private $insumo;
    private $producto;
    private $cantidad;
    
    function getInsumo() {
        return $this->insumo;
    }

    function getProducto() {
        return $this->producto;
    }

    function getCantidad() {
        return $this->cantidad;
    }

    function setInsumo($insumo) {
        $this->insumo = $insumo;
    }

    function setProducto($producto) {
        $this->producto = $producto;
    }

    function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }


}