<script src="js/reportes.js"></script>
<div class="buscador_ventas">
    <div class="contenedor_busc" style="height: calc(100% - 290px)">
        <div>
            Tipo
        </div>
        <div>
            <select id="tipo">
                <option value="">SELECCIONE</option>
                <option value="0">PRODUCTOS MAS VENDIDOS</option>
                <option value="1">DETALLE PEDIDOS</option>
            </select>
        </div>
        <div>
            Cliente
        </div>
        <div>
            <select id="clienteCombo">
                <option value="">SELECCIONE</option>
            </select>
        </div>
        <div>
            Fecha desde
        </div>
        <div>
            <input type="text" id="desde" >
        </div>
        <div>
            Fecha hasta
        </div>
        <div>
            <input type="text" id="hasta" >
        </div>
        <a class="boton" id="enlaceBuscar">BUSCAR</a>
        <a class="boton" id="enlaceLimpiar">LIMPIAR</a>
        <a class="boton" id="enlaceExcel">EXCEL</a>
    </div>
</div>
<div class="contenedor-tabla">
    <table id="tabla_ventas" class="tabla-mail">
        <thead>
            <tr>
                <th>ITEM</th>
                <th>CANTIDAD</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>