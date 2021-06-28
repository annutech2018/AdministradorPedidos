<?php

class Data {
    
   private $item;
   private $cantidad;
   
   function getItem() {
       return $this->item;
   }

   function getCantidad() {
       return $this->cantidad;
   }

   function setItem($item) {
       $this->item = $item;
   }

   function setCantidad($cantidad) {
       $this->cantidad = $cantidad;
   }

}
