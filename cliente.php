<script src="js/cliente.js"></script>
<div class="buscador_ventas">
    <div class="titulo-sec">
        Buscar Cliente
    </div>
    <div class="contenedor_busc" style="height: 96%;">
        <div>
            Rut
        </div>
        <div>
            <input type="text" id="buscaRut">
        </div>
        <div>
            Nombre
        </div>
        <div>
            <input type="text" id="buscaNombre">
        </div>
        <div>
            Giro
        </div>
        <div>
            <input type="text" id="buscaGiro">
        </div>
        <div>
            E-mail
        </div>
        <div>
            <input type="text" id="buscaMail">
        </div>
        <a class="boton" id="enlaceBuscar">BUSCAR</a>
        <a class="boton" id="enlaceLimpiar">LIMPIAR</a>
        <a class="boton" id="enlaceAgregar">AGREGAR</a>
        <a class="boton" id="enlaceExcel">EXCEL</a>
    </div>
</div>
<div class="contenedor-tabla">
    <table id="tabla_cli" class="tabla-mail">
        <thead>
            <tr>
                <th>RUT</th>
                <th>NOMBRE</th>
                <th>GIRO</th>
                <th>E-MAIL</th>
                <th>TELÉFONO</th>
                <th>DIRECCIÓN</th>
                <th>COMUNA</th>
                <th>CIUDAD</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
<div id="detalle_cliente" class="detalle" style="width: calc(63%);height: 250px;z-index:10">
    <img src="img/cancelar.svg" width="30" height="30" class="img-cerrar" onclick="cerrarModal($('#detalle_cliente'));">
    <div class="detalle_cliente2">
        <div>Datos cliente</div>
        <div class="cont-detalle">
            <div>
                Rut
            </div>
            <div>
                <input type="text" id="rut" >
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
        <div class="cont-detalle">
            <div>
                Giro
            </div>
            <div>
                <input type="text" id="giro" >
            </div>
        </div>
        <div class="cont-detalle">
            <div>
                E-mail
            </div>
            <div>
                <input type="text" id="mail" >
            </div>
        </div>
        <div class="cont-detalle">
            <div>
                Teléfono
            </div>
            <div>
                <input type="text" id="telefono" >
            </div>
        </div>
        <div class="cont-detalle">
            <div>
                Dirección
            </div>
            <div>
                <input type="text" id="direccion">
            </div>
        </div>
        <div class="cont-detalle">
            <div>
                Comuna
            </div>
            <div>
                <input type="text" id="comuna">
            </div>
        </div>
        <div class="cont-detalle">
            <div>
                Ciudad
            </div>
            <div>
                <input type="text" id="ciudad">
            </div>
        </div>
    </div>
    <a style="float: right" class="boton" id="enlaceGuatdar" onclick="guardarCliente()">GUARDAR</a>
</div>
<div class="trasero"></div>