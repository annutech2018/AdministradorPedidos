<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
    
?>
<script>
    TIPO_USUARIO = "<?php echo $_SESSION['tipo'] ?>";
</script>
<?php

    if($_SESSION['tipo'] != '4')
    {
?>
<div class="opcion-menu menu-activo" id="home" onclick="cambiarModulo('home')">
    <div class="cont-img-menu">
        <img class="img-menu" src="img/dashboard.png">
    </div>
    <div class="contenido-menu">
        Dashboard
    </div>
    <div class="tooltip" id="tooltip_home">
        Dashboard
    </div>
</div>
<div class="opcion-menu" id="pedido" onclick="cambiarModulo('pedido')">
    <div class="cont-img-menu">
        <img class="img-menu" src="img/pedido.png">
    </div>
    <div class="contenido-menu">
        Pedidos
    </div>
    <div class="tooltip" id="tooltip_pedido">
        Pedidos
    </div>
</div>
<?php
    }
    
    if($_SESSION['tipo'] == '2' || $_SESSION['tipo'] == '0'){
        ?>
        <div class="opcion-menu" id="reportes" onclick="cambiarModulo('reportes')">
            <div class="cont-img-menu">
                <img class="img-menu" src="img/reportes.png">
            </div>
            <div class="contenido-menu">
                Reportes
            </div>
            <div class="tooltip" id="tooltip_reportes">
                Reportes
            </div>
        </div>
            
        <?php
        
    }
    
    if($_SESSION['tipo'] == '0')
    {
?>
<div class="opcion-menu" id="insumo" onclick="cambiarModulo('insumo')">
    <div class="cont-img-menu">
        <img class="img-menu" src="img/insumo.png">
    </div>
    <div class="contenido-menu">
        Insumos
    </div>
    <div class="tooltip" id="tooltip_insumo">
        Insumos
    </div>
</div>
<div class="opcion-menu" id="producto" onclick="cambiarModulo('producto')">
    <div class="cont-img-menu">
        <img class="img-menu" src="img/producto.png">
    </div>
    <div class="contenido-menu">
        Productos
    </div>
    <div class="tooltip" id="tooltip_producto">
        Productos
    </div>
</div>
<div class="opcion-menu" id="cliente" onclick="cambiarModulo('cliente')">
    <div class="cont-img-menu">
        <img class="img-menu" src="img/cliente.png">
    </div>
    <div class="contenido-menu">
        Clientes
    </div>
    <div class="tooltip" id="tooltip_cliente">
        Clientes
    </div>
</div>
<div class="opcion-menu" id="usuario" onclick="cambiarModulo('usuario')">
    <div class="cont-img-menu">
        <img class="img-menu" src="img/usuario.png">
    </div>
    <div class="contenido-menu">
        Usuarios
    </div>
    <div class="tooltip" id="tooltip_usuario">
        Usuarios
    </div>
</div>
<div class="opcion-menu menu-salir" id="salir" onclick="salir()">
    <div class="contenido-menu">
        Salir
    </div>
    <div class="tooltip" id="tooltip_salir">
        Salir
    </div>
</div>
<?php
    }
?>