<script src="js/inventario.js"></script>
<div class="buscador_ventas">
    <div class="contenedor_busc">
        <div>
            Código
        </div>
        <div>
            <input type="text" id="id">
        </div>
        <div>
            Nombre
        </div>
        <div>
            <input type="text" id="nombre">
        </div>
            <div>
            Departamento
        </div>
        <div>
            <input type="text" id="depto">
        </div>

        <a class="boton" id="enlaceBuscar">BUSCAR</a>
    </div>
    <div class="contenedor_mod" style="visibility: hidden">
        <div>
            Código
        </div>
        <div>
            <input type="text" id="idMod" readonly="">
        </div>
        <div>
            Stock Actual
        </div>
        <div>
            <input type="text" id="stockMod" readonly="">
        </div>
        <div>
            Entrada
        </div>
        <div>
            <input type="text" id="entrada" readonly="">
            <div id="modEntrada" class="boton-chico">+</div>
        </div>
        <div>
            Salida
        </div>
        <div>
            <input type="text" id="salida" readonly="">
            <div id="modSalida" class="boton-chico">-</div>
        </div>
        <div class="boton" id="modificar">Modificar</div>
    </div>
</div>
<div class="contenedor-tabla">
    <table id="tabla_inv" class="tabla-mail">
        <thead>
            <tr>
                <th>CODIGO</th>
                <th>NOMBRE</th>
                <th>DESCRIPCION</th>
                <th>DEPARTAMENTO</th>
                <th>PRECIO</th>
                <th>CANTIDAD</th>
                <th></th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
