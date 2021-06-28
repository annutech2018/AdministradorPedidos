<script src="js/home.js"></script>
<div class="contenedor-indicador">
    Pedidos creados
    <div id="creados" class="valor-indicador">
        <span id="creadosSpan" style="cursor:pointer" onclick="validarCambioModulo($('#creadosSpan').html(),{estado:0})">0</span>
    </div>
</div>
<div class="contenedor-indicador">
    Pedidos aceptados
    <div id="aceptados" class="valor-indicador">
        <span id="aceptadosSpan" style="cursor:pointer" onclick="validarCambioModulo($('#aceptadosSpan').html(),{estado:1})">0</span>
    </div>
</div>
<div class="contenedor-indicador">
    Pedidos despachados
    <div id="despachados" class="valor-indicador">
        <span id="despachadosSpan" style="cursor:pointer" onclick="validarCambioModulo($('#despachadosSpan').html(),{estado:2})">0</span>
    </div>
</div>
<div class="contenedor-indicador">
    <div id="folio56" class="valor-indicador">
        <span></span>
    </div>
</div>
<div class="contenedor-indicador">
    Pedidos entregados
    <div id="entregados" class="valor-indicador">
         <span id="entregadosSpan" style="cursor:pointer" onclick="validarCambioModulo($('#entregadosSpan').html(),{estado:3})">0</span>
    </div>
</div>
<div class="contenedor-indicador">
    <div id="folio56" class="valor-indicador">
        <span></span>
    </div>
</div>