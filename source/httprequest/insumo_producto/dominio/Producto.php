<?php

class Producto {
    private $id;
    private $codigo;
    private $nombre;
    private $descripcion;
    private $precio;
    private $precioIva;
    private $costo;
    private $costoIva;
    private $departamento;
    private $tipo;
    private $descuento;
    private $descuentoNuevo;
    private $descuentoNormal;
    private $descuentoPremium;
    private $mostrarEnCatalogo;
    private $imagen;
    private $unidad;
    private $creador;
    private $inventario;
    private $manufacturado;
    private $cantidad;
    function getCantidad() {
        return $this->cantidad;
    }

    function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

        function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getPrecio() {
        return $this->precio;
    }

    function getPrecioIva() {
        return $this->precioIva;
    }

    function getCosto() {
        return $this->costo;
    }

    function getCostoIva() {
        return $this->costoIva;
    }

    function getDepartamento() {
        return $this->departamento;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getDescuento() {
        return $this->descuento;
    }

    function getDescuentoNuevo() {
        return $this->descuentoNuevo;
    }

    function getDescuentoNormal() {
        return $this->descuentoNormal;
    }

    function getDescuentoPremium() {
        return $this->descuentoPremium;
    }

    function getMostrarEnCatalogo() {
        return $this->mostrarEnCatalogo;
    }

    function getImagen() {
        return $this->imagen;
    }

    function getUnidad() {
        return $this->unidad;
    }
    
    function getCreador() {
        return $this->creador;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setPrecio($precio) {
        $this->precio = $precio;
    }

    function setPrecioIva($precioIva) {
        $this->precioIva = $precioIva;
    }

    function setCosto($costo) {
        $this->costo = $costo;
    }

    function setCostoIva($costoIva) {
        $this->costoIva = $costoIva;
    }

    function setDepartamento($departamento) {
        $this->departamento = $departamento;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setDescuento($descuento) {
        $this->descuento = $descuento;
    }

    function setDescuentoNuevo($descuentoNuevo) {
        $this->descuentoNuevo = $descuentoNuevo;
    }

    function setDescuentoNormal($descuentoNormal) {
        $this->descuentoNormal = $descuentoNormal;
    }

    function setDescuentoPremium($descuentoPremium) {
        $this->descuentoPremium = $descuentoPremium;
    }

    function setMostrarEnCatalogo($mostrarEnCatalogo) {
        $this->mostrarEnCatalogo = $mostrarEnCatalogo;
    }

    function setImagen($imagen) {
        $this->imagen = $imagen;
    }

    function setUnidad($unidad) {
        $this->unidad = $unidad;
    }

    function setCreador($creador) {
        $this->creador = $creador;
    }
    function getInventario() {
        return $this->inventario;
    }

    function getManufacturado() {
        return $this->manufacturado;
    }

    function setInventario($inventario) {
        $this->inventario = $inventario;
    }

    function setManufacturado($manufacturado) {
        $this->manufacturado = $manufacturado;
    }
    
    function getCodigo() {
        return $this->codigo;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }



}
