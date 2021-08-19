<script src="js/producto.js"></script>
<div class="buscador_ventas">
    <div class="titulo-sec">
        Buscar Producto
    </div>
    <div class="contenedor_busc">
        <div>
            Código
        </div>
        <div>
            <input type="text" id="buscaCodigo">
        </div>
        <div>
            Nombre
        </div>
        <div>
            <input type="text" id="buscaNombre">
        </div>
        <a class="boton" id="enlaceBuscar">BUSCAR</a>
        <a class="boton" id="enlaceLimpiar">LIMPIAR</a>
        <a class="boton" id="enlaceAgregar">AGREGAR</a>
        <a class="boton" id="enlaceExcel">EXCEL</a>
    </div>
</div>
<div class="contenedor-tabla">
    <table id="tabla_prod" class="tabla-mail">
        <thead>
            <tr>
                <th>CÓDIGO</th>
                <th>NOMBRE</th>
                <th>DESCRIPCIÓN</th>
                <th>PRECIO COSTO</th>
                <th>PRECIO VENTA</th>
                <th>EXISTENCIA</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
<div id="detalle_producto" class="detalle">
    <img src="img/cancelar.svg" width="30" height="30" class="img-cerrar" onclick="$('#detalle_producto').hide();$('#detalle_producto').css('visibility','hidden');">
    <div class="detalle_producto">
        <div>Datos producto</div>
        <div class="cont-detalle">
            <div>
                Codigo
            </div>
            <div>
                <input type="text" id="codigo" >
            </div>
        </div>
        <div class="cont-detalle">
            <div>
                Nombre
            </div>
            <div>
                <input type="text" id="nombre" >
            </div>
        </div>
        <div class="cont-detalle" style='width: 350px;' >
            <div>
                Descripción
            </div>
            <div>
                <input type="text" id="descripcion"  style='width: 300px;'>
            </div>
        </div>
        <div class="cont-detalle">
            <div>
                Precio costo
            </div>
            <div>
                <input type="text" id="costo" disabled>
            </div>
        </div>
        <div class="cont-detalle">
            <div>
                Precio venta
            </div>
            <div>
                <input type="text" id="precio" >
            </div>
        </div>
<!--        <div class="cont-detalle">
            <div>
                Departamento
            </div>
            <div>
                <select id='depto'>
                    
                </select>
            </div>
        </div>-->
        <div class="cont-detalle">
            <div>
                Tipo
            </div>
            <div>
                <select id='tipo'>
                    <option value="0">Unidad</option>
                    <option value="1">Granel</option>
                    <option value="2">Por metros</option>
                    <option value="3">Por Litros</option>
                </select>
            </div>
        </div>
        <div class="cont-detalle">
            <div>
                Afecto a inventario
            </div>
            <div>
                <input type='checkbox' id='inventario' checked>
            </div>
        </div>
        <div class="cont-detalle">
            <div>
                Es manufacturado
            </div>
            <div>
                <input type='checkbox' id='manufacturado' checked>
            </div>
        </div>
    </div>
    <div class="detalle_inv">
        <div>Inventario</div>
        <div class="cont-detalle">
            <div>
                Existencia
            </div>
            <div>
                <input type="text" id="existencia" value="0" readonly>
            </div>
        </div>
        <div class="cont-detalle">
            <div>
                Agregar stock
            </div>
            <div>
                <input type="number" value="0" step="1" min="0" max="100000" id="addStock" >
            </div>
        </div>
        <div class="cont-detalle">
            <div>
                Quitar stock
            </div>
            <div>
                <input  type="number" value="0" step="1" min="0" max="100000" id="delStock" disabled>
            </div>
        </div>
    </div>
    <a style="float: right" class="boton" id="enlaceGuatdar" onclick="guardarProducto()">GUARDAR</a>
</div>
<div id="composicion_producto" class="detalle" style="width: calc(97%);height: 400px;">
    <img src="img/cancelar.svg" width="30" height="30" class="img-cerrar" onclick="$('#composicion_producto').hide();$('#composicion_producto').css('visibility','hidden');">
    <div class="detalle_producto" style="width: 100%;height: 125px;">
        <div>Datos producto</div>
<!--        <div class="cont-detalle" style='width: 180px;'>
            <div>
                Codigo
            </div>
            <div>
                <input type="text" id="codigoInsumo" onblur="verInsumo()">
            </div>
        </div>-->
        <div class="cont-detalle" style='width: 180px;'>
            <div>
                Nombre
            </div>
            <div>
                <select id="nombreInsumo" onchange="verInsumo()">
                    <option val="">Seleccione</option>
                </select>
            </div>
        </div>
        <div class="cont-detalle" style='width: 250px;' >
            <div>
                Descripción
            </div>
            <div>
                <input type="text" id="descripcionInsumo"  style='width: 200px;'>
            </div>
        </div>
        <div class="cont-detalle" style='width: 180px;'>
            <div>
                Precio
            </div>
            <div>
                <input type="text" id="costoInsumo" disabled>
            </div>
        </div>
        <div class="cont-detalle" style='width: 180px;'>
            <div>
                Tipo
            </div>
            <div>
                <select id="tipoInsumo" disabled>
                    <option value=""></option>
                    <option value="0">Unidad</option>
                    <option value="1">Granel</option>
                    <option value="2">Por metros</option>
                    <option value="3">Por litros</option>
                </select>
            </div>
        </div>
        <div class="cont-detalle">
            <div>
                Cantidad
            </div>
            <div>
                <input type="number" id="cantidadInsumo" value="1">
            </div>
        </div>
        <div class="cont-detalle">
            <div class="boton" onclick="agregarInsumoProducto()">
                AGREGAR
            </div>
        </div>
    </div>
    <div style="height: 225px;overflow: auto;">
        <table id="insumos" class="tabla-mail" style="text-align: center;">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Tipo</th>
                    <th>Costo</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
        <div class="input-final">
            Precio Costo
            <input type="text" id="costoFinal">
        </div>
        
    </div>
</div>
<div class="trasero"></div>