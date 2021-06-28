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
        <link rel="stylesheet" href="css/estado.css">
        <link rel="stylesheet" href="css/loader.css">
        <link rel="stylesheet" href="css/media-queries.css">
        <link rel="icon" type="image/ico" href="img/icono.ico" />
        <script src="js/lib/jquery.js" type="text/javascript"></script>
        <script src="js/lib/alertify.js" type="text/javascript"></script>
        <script src="js/lib/chart.js"></script>
        <script src="js/lib/jquery.datetimepicker.js" type="text/javascript"></script>
        <script src="js/funciones.js" type="text/javascript"></script>
        <script src="js/estado.js" type="text/javascript"></script>
    </head>
    <body style="background-image: linear-gradient(to bottom, #73CFDE, #73CFDE 50%, #19AFCA 50%); height: calc(100% - 0px)">
        <div class="barra-titulo">
            <img class="img1" src="img/LOGOBLEACH.png">
            SIGUE LA ORDEN DE TU PEDIDO
            <img class="img2" src="img/CAMION.png">
        </div>
        <div id="cont1" class="cont-buscador">
            <div class="titulo-buscador">
                BUSCA TU PEDIDO    
            </div>
            <input id="codigo" class="text-buscador" type="text">
            <div class="boton-buscador" onclick="buscar()"><img src="img/buscar.png" width="30" height="30"></div>
        </div>
        <img class="img3" src="img/PRODUCTO1.png">
        <img class="img4" src="img/PRODUCTO2.png">
        <div class="cont-id-pedido">
            <span id="nro_pedido">
                
            </span>
        </div>
        <div class="res1">
            <span>
                DATOS CLIENTE                
            </span>
            <table class="tabla-cliente" style="font-size: 20px;">
                <tr>
                    <td style="width: 50px">
                        NOMBRE:
                    </td>
                    <td>
                        <div id="nombre_pedido"></div>
                    </td>
                </tr>
                <tr>
                    <td style="width: 50px">
                        DIRECCIÓN:
                    </td>
                    <td>
                        <div id="dir_pedido"></div>
                    </td>
                </tr>
                <tr>
                    <td style="width: 50px">
                        ESTADO:
                    </td>
                    <td>
                        <div id="estado"></div>
                    </td>
                </tr>
                <tr>
                    <td style="width: 50px">
                        MEDIO DESPACHO:
                    </td>
                    <td>
                        <div id="despachado"></div>
                    </td>
                </tr>
                <tr>
                    <td style="width: 50px">
                        COMPROBANTE DE DESPACHO:
                    </td>
                    <td>
                        <div id="adjuntado"></div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="res2">
            <span>
                PRODUCTOS
            </span>
            <table id="tabla_detalle" class="tabla-productos">
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
<!--        <div class="cabecera" id="cabecera">
            <div class="btn-menu" id="btn_menu">
                <img src="img/menu.svg" id="btn_menu_img" width="20" height="20" alt="" title="">
            </div>
            <div class="img-logo" >
                <img src="img/icono.png" width="50" height="50" alt="" title="">
            </div>
            <div class="titulo">
                Estado de Pedidos
            </div>
            <img src="img/menu.svg" id="menu-telefono" class="menu-telefono">
        </div>
        <div id="contenido-central" class="contenido-central">
            <div class="centro">
                <div>
                    Ingrese código de pedido
                </div>
                <div>
                    <input type="text" id="codigo" style="width: 80%;"> 
                    <a class="boton" id="enlaceBuscar" onclick="buscar()">BUSCAR</a>
                </div>
            </div>
            <br>
            <div id="cont_estado" class="cont-cliente">
                <table id="tabla_contenido" class="tabla-mail detalle-tabla">
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
                            <th>
                                DESPACHADO POR: <span id="despachado"></span>
                            </th>
                            <th>
                                COMPROBANTE DE ENVIO: <span id="adjuntado"></span>
                            </th>
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
            <div class="cont-tabla max">
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
            <div class="pie-cliente">
                <div class="normal">
                    <span id="url_des"></span>
                </div>
                <div id="enlace-seg"></div>
                <div class="normal">
                    <span id="despa2"></span>
                </div>
                
            </div>
        </div>-->
        <div class="pie-cliente">
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
        <div class="volver" onclick="location.reload()">
            <img src="img/BOTONRETROCEDER.png" width="30" height="30">
        </div>
    </body>
</html>