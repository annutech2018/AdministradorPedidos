<!DOCTYPE html>
<html>
    <head>
        <title>
            Panel principal
        </title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, user-scalable=no, 
              initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="Expires" content="0">
        <meta http-equiv="Last-Modified" content="0">
        <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
        <meta http-equiv="Pragma" content="no-cache">
<!--        <meta http-equiv="Content-Security-Policy" content="default-src https:">-->
        <link rel="stylesheet" href="css/lib/alertify.css">
        <link rel="stylesheet" href="css/lib/jquery.datetimepicker.css">
        <!--<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />-->
        <link rel="stylesheet" href="css/estilo.css">
        <link rel="stylesheet" href="css/loader.css">
        <link rel="stylesheet" href="css/media-queries.css">
        <link rel="icon" type="image/ico" href="img/icono.ico" />
        <script src="js/lib/jquery.js" type="text/javascript"></script>
        <script src="js/lib/alertify.js" type="text/javascript"></script>
        <script src="js/lib/chart.js"></script>
        <script src="js/lib/jquery.datetimepicker.js" type="text/javascript"></script>
        <script src="js/funciones.js" type="text/javascript"></script>
        <script src="js/despacho.js" type="text/javascript"></script>
    </head>
    <body>
        <input type="hidden" id="id" value="<?php echo $_GET['id'] ?>">
        <input type="hidden" id="aux" value="<?php echo $_GET['aux'] ?>">
        <div class="cabecera" id="cabecera">
<!--            <div class="btn-menu" id="btn_menu">
                <img src="img/menu.svg" id="btn_menu_img" width="20" height="20" alt="" title="">
            </div>-->
            <div class="img-logo" >
                <img src="img/icono.png" width="50" height="50" alt="" title="">
            </div>
            <div class="titulo">
                Entrega de Pedidos
            </div>
            <!--<img src="img/menu.svg" id="menu-telefono" class="menu-telefono">-->
        </div>
        <div id="contenido-central" class="contenido-central">
            <div id="cont_estado">
                <table id="tabla_contenido" class="tabla-mail">
                    <thead>
                        <tr>
                            <th>
                                ID PEDIDO: <span id="nro_pedido"></span>
                            </th>
                            <th>
                                NOMBRE: <span id="nombre_pedido"></span>
                            </th>
                            <th>
                                DIRECCIÓN: <span id="dir_pedido"></span>
                            </th>
                            <th>
                                ESTADO: <span id="estado"></span>
                            </th>
<!--                            <th>
                                DESPACHADO POR: <span id="despachado"></span>
                            </th>
                            <th>
                                COMPROBANTE DE ENVIO: <span id="adjuntado"></span>
                            </th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <br>
            <div style="text-align: center">
                <div>
                    USUARIO:     
                </div>
                <div>
                    <input id="usuario" type="text">
                </div>
                <div>
                    PASSWORD:
                </div>
                <div>
                    <input id="password" type="password">
                </div>
                <div>
                    ADJUNTO:
                </div>
                <div>
                    <input type="hidden" id="comprobanteOcultaPago">
                    <form id="formComprobantePago" enctype="multipart/form-data" method="POST"
                        onsubmit="subirFichero(event,$('#formComprobantePago'),<?php echo $_GET['id'] ?>,$('#comprobanteOcultaPago'),'0',0,'despacho')">
                        <input name="comprobante" type="file" class="file" id="comprobantePago" accept="image/x-png,image/jpeg,application/pdf" onchange="enviarFormFile($('#comprobantePago').val(),$('#comprobanteOcultaPago'),$('#formComprobantePago'))">
                    </form>
                    <a href='javascript:void(0)' onClick="abrirFile(event,$('#comprobantePago:hidden'))" >
                        <img alt='Adjuntar comprobante de pago' title='Adjuntar comprobante de pago' width='20' height='20' src='img/adjuntar.png'>
                    </a>
                </div>
                <div id="aceptar" class="boton boton-gigante" onclick="login()">
                    MARCAR COMO ENTREGADO
                </div>
            </div>
            <br>
            <br>
            <div class="cont-tabla" style="width: 100% ;margin-top: 40px;height: auto">
                <table id="tabla_detalle" class="tabla-mail detalle-tabla">
                    <thead>
                        <tr>
                            <th>
                            DETALLE PRODUCTO
                        </th>
                        <th>
                            CANTIDAD
                        </th>
                        <th>
                            TOTAL
                        </th>
                        <th>

                        </th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="pie-cliente" style="visibility: visible">
                <div class="normal">
                    <span id="url_des"></span>
                </div>
                <div id="enlace-seg"></div>
                <div class="normal">
                    <span id="despa2"></span>
                </div>
                <div class="normal">
                    Dudas o consultas contactarse al siguiente número: <span id="num">+56987179841</span>
                </div>
                <div class="normal">
                    <?php
                        $date = getdate();
                        echo "Bleach ".$date['year'];
                    ?>
                </div>
            </div>
        </div>
    </body>
    <script>
        buscar();
    </script>
</html>
