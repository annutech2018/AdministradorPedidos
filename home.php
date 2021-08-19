<script src="js/home.js"></script>
<div class="cont-indicadores">
    <div class="contenedor-indicador">
        Pedidos Normales
        <div id="normal" class="valor-indicador">
            <span id="normalSpan" style="cursor:pointer" onclick="validarCambioModulo($('#normalSpan').html(),{estado:0})">0</span>
        </div>
    </div>
    <div class="contenedor-indicador">
        Pedidos Rappi
        <div id="rappi" class="valor-indicador">
            <span id="rappiSpan" style="cursor:pointer" onclick="validarCambioModulo($('#rappiSpan').html(),{estado:1})">0</span>
        </div>
    </div>
    <div class="contenedor-indicador">
        Pedidos PedidosYa
        <div id="pedidosYa" class="valor-indicador">
            <span id="pedidosYaSpan" style="cursor:pointer" onclick="validarCambioModulo($('#pedidosYaSpan').html(),{estado:2})">0</span>
        </div>
    </div>
</div>
<div class="cont-pedidos-nuevos" id="contenedor_pedidos">
    
</div>