<script src="js/insumo.js"></script>
<div class="buscador_ventas">
    <div class="titulo-sec">
        Buscar Insumo
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
                <th>C&Oacute;DIGO</th>
                <th>NOMBRE</th>
                <th>DESCRIPC&Oacute;N</th>
                <th>PRECIO COSTO</th>
                <!--<th>PRECIO VENTA</th>-->
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
    <img class="img" id="img" src="img/default.jpg" width="200" height="150" onclick="abrirFile(event,$('#imagen:hidden'))">
        <input type="hidden" id="imagenOculta">
        <form style="display: none;" id="form" enctype="multipart/form-data" method="POST" onsubmit="subirFicheroImagen(event,$('#form'),$('#imagenOculta').val())">
            <input name="imagen" type="file" class="imagen" id="imagen" accept="image/x-png,image/jpeg" 
                   onchange="enviarFormFileIMG($('#imagen').val(),$('#imagenOculta'),$('#form'))">         
        </form>
    <div class="detalle_producto">
        <div>Datos producto</div>
        <div class="cont-detalle">
            <div>
                C&oacute;digo
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
                Descripci&oacute;n
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
                <input type="text" id="costo" >
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
<!--    <div class="detalle_desc">
        <div>Descuentos</div>
        <div class="cont-detalle">
            <div>
                Clientes nuevos %
            </div>
            <div>
                <input  type="number" value="0" step="1" min="0" max="100" id="nuevo" >
            </div>
        </div>
        <div class="cont-detalle">
            <div>
                Clientes normales %
            </div>
            <div>
                <input  type="number" value="0" step="1" min="0" max="100" id="normal" >
            </div>
        </div>
        <div class="cont-detalle">
            <div>
                Clientes premium %
            </div>
            <div>
                <input  type="number" value="0" step="1" min="0" max="100" id="premium" >
            </div>
        </div>
        <div class="cont-detalle">
            <div>
                Mostrar en catalogo
            </div>
            <div>
                <input type="checkbox" id="catalogo" >
            </div>
        </div>
    </div>-->
    <a style="float: right" class="boton" id="enlaceGuatdar" onclick="guardarProducto()">GUARDAR</a>
</div>
<div class="trasero"></div>