<script src="js/usuario.js"></script>
<div class="buscador_ventas">
    <div class="titulo-sec">
        Buscar Usuario
    </div>
    <div class="contenedor_busc" style="height: 96%;">
        <div>
            Nombre
        </div>
        <div>
            <input type="text" id="buscaNombre">
        </div>
        <a class="boton" id="enlaceBuscar">BUSCAR</a>
        <a class="boton" id="enlaceLimpiar">LIMPIAR</a>
        <a class="boton" id="enlaceAgregar">AGREGAR</a>
    </div>
</div>
<div class="contenedor-tabla">
    <table id="tabla_usr" class="tabla-mail">
        <thead>
            <tr>
                <th>ID</th>
                <th>NOMBRE</th>
                <th>TIPO</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
<div id="detalle_usuario" class="detalle" style="width: calc(35%);height: 200px;z-index:10">
    <img src="img/cancelar.svg" width="30" height="30" class="img-cerrar" onclick="cerrarModal($('#detalle_usuario'))">
    <div class="detalle_usuario">
        <div>Datos usuario</div>
        <div class="cont-detalle">
            <div>
                Nombre
            </div>
            <div>
                <input type="hidden" id="id" >
                <input type="text" id="nombre" autocomplete="off">
            </div>
        </div>
        <div class="cont-detalle">
            <div>
                Clave
            </div>
            <div>
                <input type="password" id="clave1" >
            </div>
        </div>
        <div class="cont-detalle">
            <div>
                Repite clave
            </div>
            <div>
                <input type="password" id="clave2" >
            </div>
        </div>
        <div class="cont-detalle">
            <div>
                Tipo
            </div>
            <div>
                <select id="tipo">
                    <option value="">SELECCIONE</option>
                    <option value="0">ADMINISTRADOR</option>
                    <option value="1">VENDEDOR</option>
                    <option value="2">MONITOR</option>
                </select>
            </div>
        </div>
    </div>
    <a style="float: right" class="boton" id="enlaceGuatdar" onclick="guardarUsuario()">GUARDAR</a>
</div>
<div class="trasero"></div>