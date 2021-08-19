<script src="js/pedido.js"></script>
<div class="buscador_ventas">
    <div class="contenedor_busc" style="height: calc(100% - 0px);border-bottom: 0px;">
        <div>
            ID pedido
        </div>
        <div>
            <input type="text" id="idpedido">
        </div>
        <div>
            N° Teléfono
        </div>
        <div>
            <input type="text" id="nro_tel">
        </div>
<!--        <div>
            Usuario Instagram
        </div>-->
<!--        <div>
            <input type="text" id="user_ig">
        </div>-->
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
        <div>
            Estado
        </div>
        <div>
            <select id="estadoCombo"  width="50">
                <option value="">SELECCIONE</option>
                <option value="0">CREADO</option>
                <option value="1">ACEPTADO</option>
                <option value="2">DESPACHADO</option>
                <option value="3">ENTREGADO</option>
                <option value="4">ANULADO</option>
            </select>
        </div>
        <div>
            Usuario
        </div>
        <div>
            <select id="usuarioCombo"  width="50">
                <option value="">SELECCIONE</option>
            </select>
        </div>
        <div>
            Cliente
        </div>
        <div>
            <select id="clienteCombo"  width="50">
                <option value="">SELECCIONE</option>
            </select>
        </div>
        
        <a class="boton2" id="enlaceBuscar"><img src="img/buscar.png" width="30" height="30" alt="Buscar pedidos" title="Buscar pedidos"></a>
        <a class="boton2" id="enlaceAgregarPedido"><img src="img/agregar.png" width="30" height="30" alt="Agregar pedido" title="Agregar pedido"></a>
        <a class="boton2" id="enlacePistolear" onclick="pistolear()"><img src="img/scanner.png" width="30" height="30" alt="Pistolear ticket" title="Pistolear Ticket"></a>
        <a class="boton2" id="enlaceLimpiar"><img src="img/escoba.png" width="30" height="30" alt="Limpiar busqueda" title="Limpiar busqueda"></a>
        <a class="boton2" id="enlaceExcel"><img src="img/icon.svg" width="30" height="30" alt="Exportar a excel" title="Exportar a excel"></a>
        <a class="boton2" id="enlaceImportar"><img src="img/adjuntar2.png" width="30" height="30" alt="Adjuntar pedidos" title="Adjuntar pedidos" onClick="abrirFile(event,$('#pedidoExcel:hidden'))" ></a>
        <input type="hidden" id="excelPedidoOculta">
        <form id="formPedidoExcel" enctype="multipart/form-data" method="POST"
                                            onsubmit="subirFichero(event,$('#formPedidoExcel'),'',$('#excelPedidoOculta'),'1',0,'xls')">
            <input name="comprobante" type="file" class="file" id="pedidoExcel" onchange="enviarFormFile($('#pedidoExcel').val(),$('#excelPedidoOculta'),$('#formPedidoExcel'),1)">
        </form>
    </div>
</div>
<div class="contenedor-tabla">
    <div style="border-bottom: 1px solid black;margin-bottom: 10px;">
       <div>
           <b>Carga Masiva de Pedidos</b>
       </div>
       <div style="color: red">
           Importante:
       </div>
       <div>
           - Los archivos deben cargarse en formato .XLSX. 
       </div>
       <div>
           - Se debe cargar en el siguiente <a href="formato.zip" style="color: green">formato</a>.
       </div>
    </div>
    <table id="tabla_ventas" class="tabla-mail">
        <thead>
            <tr>
                <th>ID PEDIDO</th>
                <th>FECHA</th>
                <th>ESTADO</th>
                <th>TOTAL</th>
                <th>VENDEDOR</th>
                <th>CLIENTE</th>
                <th>TELÉFONO</th>
                <th>TIPO</th>
                <th></th>
                <th></th>
                <th></th>
                <th colspan="3">PAGO</th>
                <th colspan="3">DESPACHO</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

<div id="detalle_venta" class="detalle" style="z-index:10;height:512px">
    <img src="img/cancelar.svg" width="30" height="30" class="img-cerrar" onclick="cerrarModal($('#detalle_venta'))">
    <div class="detalle_cliente" id="detalle_cliente">
        <div>Datos Pedido</div>
        <div class="cont-detalle" id="cont-pedido">
            <div>
                ID Pedido
            </div>
            <div>
                <input type="text" id="pedidoDetalle" >
            </div>
        </div>
        <div class="cont-detalle">
            <div>
                Fecha
            </div>
            <div>
                <input type="text" id="fechaDetalle" >
            </div>
        </div>
        <div class="cont-detalle">
            <div>
                Hora
            </div>
            <div>
                <input type="text" id="horaDetalle" >
            </div>
        </div>
        <div class="cont-detalle">
            <div>
                RUT
            </div>
            <div>
                <input type="text" id="clienteDetalle" list="clienteDetalleList" >
                <datalist id="clienteDetalleList">
                    
                </datalist>
            </div>
        </div>
        <div class="cont-detalle">
            <div>
                Nombre
            </div>
            <div>
                <input type="text" id="nombreDetalle" >
            </div>
        </div>
        <div class="cont-detalle" style="width:400px">
            <div>
                Dirección
            </div>
            <div>
                <input type="text" id="direccionDetalle" style="width:340px">
            </div>
        </div>
        <div class="cont-detalle">
            <div>
                Comuna
            </div>
            <div>
                <input type="text" id="comunaDetalle">
            </div>
        </div>
        <div class="cont-detalle">
            <div>
                Teléfono
            </div>
            <div>
                <input type="text" id="telefonoDetalle" max="9">
            </div>
        </div>
        <div class="cont-detalle">
            <div>
                E-mail
            </div>
            <div>
                <input type="text" id="mailDetalle">
            </div>
        </div>
<!--        <div class="cont-detalle">
            <div>
                Usuario Instagram
            </div>
            <div>
                <input type="text" id="igDetalle">
            </div>
        </div>-->
        <div class="cont-detalle" style="width:400px">
            <div>
                Observaciones
            </div>
            <div>
                <input type="text" id="observacionDetalle"  style="width:340px" maxlength="100">
            </div>
        </div>
        <div class="cont-detalle">
            <div>
                Descuento (%) 
            </div>
            <div>
                <input type="number" id="descuentoDetalle" value="0" step="10" min="0" max="100">
            </div>
        </div>
        <div class="cont-detalle">
            <div>
                Total
            </div>
            <div>
                <input type="text" id="totalDetalle" readonly>
            </div>
        </div>
    </div>
    <div class="detalle_venta">
        <div>Productos</div>
        <a class="boton boton-grande" id="enlaceAddProd" onclick="agregarProducto()">AGREGAR</a>
        <div class="cont-tabla" style="height:220px">
            <table style="float: left;width:20%;background: white;height: calc(100%);">
                <tr>
                    <td colspan="4">
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="boton-calc" onclick="calcular(7)">
                           7 
                        </div>
                        
                    </td>
                    <td>
                        <div class="boton-calc" onclick="calcular(8)">
                            8
                        </div>
                    </td>
                    <td>
                        <div class="boton-calc" onclick="calcular(9)">
                            9
                        </div>
                    </td>
                    <td>
                        <div class="boton-calc" onclick="vaciar()">
                           C 
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="boton-calc" onclick="calcular(4)">
                            4
                        </div>
                    </td>
                    <td>
                        <div class="boton-calc" onclick="calcular(5)">
                          5  
                        </div>
                    </td>
                    <td>
                        <div class="boton-calc" onclick="calcular(6)">
                        6
                        </div>
                    </td>
                    <td>
                        <div class="boton-calc" onclick="borrar()">
                        B
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="boton-calc" onclick="calcular(1)">
                            1
                        </div>
                    </td>
                    <td>
                        <div class="boton-calc" onclick="calcular(2)">
                            2
                        </div>
                    </td>
                    <td>
                        <div class="boton-calc" onclick="calcular(3)">
                           3 
                        </div>
                    </td>
                    <td>
                        
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="boton-calc" onclick="calcular(0)">
                            0
                        </div>
                    </td>
                    <td>
                        <div class="boton-calc" onclick="calcular('00')">
                            00
                        </div>
                    </td>
                    <td>
                        <div class="boton-calc" onclick="calcular('000')">
                            000
                        </div>
                    </td>
                </tr>
            </table>
            <table class="tabla-mail detalle-tabla" id="detalle_productos" style="width:80%;">
                <thead>
                    <tr>
                        <th>
                            CODIGO
                        </th>
                        <th>
                            NOMBRE
                        </th>
                        <th>
                            PRECIO
                        </th>
                        <th>
                            CANTIDAD
                        </th>
                        <th>
                            TOTAL
                        </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div style="float: right">
            <a class="boton boton-grande" id="enlaceGuardar" onclick="guardarPedido()">GUARDAR</a>            
        </div>
    </div>
</div>

<div id="ingresar_codigo_pago" class="enviar_correo" style="z-index: 11">
    <img src="img/cancelar.svg" width="30" height="30" class="img-cerrar" onclick="cerrarModal($('#ingresar_codigo_pago'));">
    <div>
        <input type="text" id="codigoPago" placeholder="Ingrese código de pago" style="width: 80%;">
    </div>
    <div>
        <a class="boton" id="enlacePago" onclick="ingresarCodigo($('#codigoPago').val(),0)">GUARDAR</a>
    </div>
</div>

<div id="ingresar_codigo_despacho" class="enviar_correo" style="z-index: 11">
    <img src="img/cancelar.svg" width="30" height="30" class="img-cerrar" onclick="cerrarModal($('#ingresar_codigo_despacho'));">
    <div>
        <input type="text" id="codigoDespacho" placeholder="Ingrese código de despacho" style="width: 80%;">
    </div>
    <div>
        <a class="boton" id="enlaceDespacho" onclick="ingresarCodigo($('#codigoDespacho').val(),1)">GUARDAR</a>
    </div>
</div>

<div id="ingresar_codigo_pistola" class="enviar_correo" style="z-index: 11">
    <img src="img/cancelar.svg" width="30" height="30" class="img-cerrar" onclick="cerrarModal($('#ingresar_codigo_pistola'));">
    <div>
        <input type="text" id="codigoPistola" placeholder="Ingrese código" style="width: 80%;">
    </div>
    <div>
        <a class="boton" id="enlaceCodigo" onclick="cargarID()">CONTINUAR</a>
    </div>
</div>
<div id="form_cargando" class="cargando" style="z-index: 11">
    <img id="img-cargando" width="50" height="30" src="img/loading.gif">
</div>

<div class="trasero"></div>