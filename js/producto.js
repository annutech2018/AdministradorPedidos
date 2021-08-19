/* global alertify */

    var accion = 'agregar';
    
    var insumoAux;
    var productoAux;
    var insumos = new Map();
    var insumos_agregados = new Map();
    
    $(document).ready(()=>{
        
        getInsumos();
        
        cargarProductos();

        $("#enlaceBuscar").click(()=>{
            cargarProductos();
        });
        
        $("#enlaceLimpiar").click(()=>{
            $("#buscaCodigo").val("");
            $("#buscaNombre").val("");
            $("#buscaDepto").prop('selectedIndex',0);  
            $("#buscaTipo").prop('selectedIndex',0);  
            cargarProductos();
        });
        
        $("#enlaceAgregar").click(()=>{
            accion = 'agregar';
            $("#codigo").val("");
            reset();
            $("#detalle_producto").css('visibility','visible');
            $("#detalle_producto").show();
            $("#codigo").blur(()=>{
                if($("#codigo").val() === ''){
                    reset();
                    return;
                }
                if(!validarNumero($("#codigo").val())){
                    alertify.error("Codigo invalido");
                    $("#codigo").val("");
                    return;
                }
                abrirModificar($("#codigo").val());
            });
        });
        
        $("#enlaceExcel").click(function(){
            var params = "codigo="+$('#buscaCodigo').val()+"&nombre="+$("#buscaNombre").val()+"&nivel=1"
            exportar('source/httprequest/producto/GetProductosExcel',params);            
        });
        
        $("#tipo").change(()=>{
            let aux = $("#tipo").val();
            if(aux === '0'){
                let add = Math.round($("#addStock").val());
                $("#addStock").val(add);
                $("#addStock").attr("step","1");
                let del = Math.round($("#delStock").val());
                $("#addStock").val(del);
                $("#delStock").attr("step","1");
            } else{
                $("#addStock").attr("step","0.125");
                $("#delStock").attr("step","0.125");
            }
        });
    });

    function cargarProductos(){
        var url = "source/httprequest/producto/GetProductos.php";
        $("#tabla_prod tbody").html("");
        var params = {codigo : $("#buscaCodigo").val(), nombre : $("#buscaNombre").val(),
            depto : $("#buscaDepto").val(),tipo : $("#buscaTipo").val(),nivel : "1"};
        var success = function(response)
        {
           if(response.length === 0){
                alertify.error("No hay registros que mostrar");
                return;
            }
            var contenido = '';
            $("#tabla_prod tbody").html("");
            for(var i = 0; i < response.length; i++){
                let producto = response[i];
                if(i % 2 === 0){
                    contenido += "<tr style='background-color:white;'>";
                }
                else{
                    contenido +=  "<tr>";
                }

                contenido += "<td>"+producto.producto_codigo+"</td>\n\
                              <td>"+producto.producto_nombre+"</td>\n\
                              <td>"+producto.producto_descripcion+"</td>";
                if(producto.producto_manufacturado){
                    contenido += "<td>$ "+Math.round((parseFloat(producto.producto_coste_manu)))+"</td>";
                } else {
                    contenido += "<td>$ "+Math.round((parseFloat(producto.producto_coste) + parseFloat(producto.producto_coste_iva)))+"</td>";
                }
                            contenido += "<td>$ "+Math.round((parseFloat(producto.producto_precio) + parseFloat(producto.producto_precio_iva)))+"</td>";
                            if(producto.producto_manufacturado === "1"){
                                contenido += "<td>-</td>";
                            } else{
                              contenido += "<td>"+(producto.producto_tipo === '0' ? Math.round(producto.producto_cantidad) : producto.producto_cantidad)+"</td>";
                }
                              contenido += "<td><a onclick=\"abrirModificar('"+producto.producto_codigo+"',true)\" href=\"javascript:void(0)\"><img src= \"img/editar.png\" width=\"20\" height=\"20\"></a></td>\n\
                              <td><a onclick=\"verComposicion('"+producto.producto_codigo+"')\" href=\"javascript:void(0)\"><img src= \"img/composicion.png\" width=\"20\" height=\"20\"></a></td>\n\
                              <td><a onclick=\"eliminarProducto('"+producto.producto_codigo+"')\" href=\"javascript:void(0)\"><img src= \"img/eliminar.png\" width=\"20\" height=\"20\"></a></td>";           
            }
            $("#tabla_prod tbody").html(contenido);
        };
        postRequest(url,params,success);
    }
    
    function verComposicion(codigo){
        productoAux = codigo;
        var url = "source/httprequest/insumo_producto/GetInsumosProductos.php";
        var params = {codigo : codigo};
        var success = function(response)
        {
            var costoTotal = 0 ;
            $("#insumos tbody").html("");
            insumos_agregados.clear();
            for(var i = 0 ; i < response.length;i++){
                var data = response[i];
                var tipo = '';
                if(data.tipo === 0){
                    tipo = 'UD';
                } else if(data.tipo === 1){
                    tipo = 'KG';
                } else if(data.tipo === 2){
                    tipo = 'MT';
                } else if(data.tipo === 3){
                    tipo = 'LT';
                }
                
                var precioReal = (data.costo + data.costoIva) * response[i].cantidad;
                costoTotal += parseInt(precioReal);
                
                if(i % 2 === 0){ 
                    $("#insumos tbody").append("<tr id='tr_"+data.codigo+"' style='background-color:white;text-align:center'>");
                }
                else{
                    $("#insumos tbody").append("<tr id='tr_"+data.codigo+"'>");
                }                
                
                $("#insumos tbody").append("<td>"+data.codigo+"</td><td>"+data.nombre+
                        "</td><td>"+data.descripcion+"</td><td>"+Math.round(data.precio+data.precioIva)+"</td><td>"+
                        response[i].cantidad+"</td><td>"+tipo+"</td><td>$ "+precioReal+"</td><td><img style='cursor:pointer' onclick='eliminarInsumoProducto("+data.codigo+");' src='img/eliminar.png'></td></tr>");
                insumos_agregados.set(data.codigo,data.codigo);
            }
            $("#nombreInsumo").html("<option value=''>Seleccione</option>");
            for (let [key, value] of insumos) {
                $("#nombreInsumo").append("<option value='"+key+"'>"+value+"</option>");
            }
            
            
            
            $("#costoFinal").val(costoTotal);
            $("#composicion_producto").css('visibility','visible');
            $("#composicion_producto").show();
        };
        postRequest(url,params,success);
    }
    
    
    function getCosto(codigo,obj){
        var costoTotal = 0;
        var url = "source/httprequest/insumo_producto/GetInsumosProductos.php";
        var params = {codigo : codigo};
        var success = function(response)
        {
            var data = response.insumo;
            for(var i = 0 ; i < response.length;i++){
                costoTotal += data.costo * response[i].cantidad;
            }
            obj.html(costoTotal);
                
        };
        postRequest(url,params,success);
    }
    
    function getInsumo(codigo){
        var url = "source/httprequest/insumo_producto/GetInsumo.php";
        var params = {codigo : codigo};
        var success = function(response)
        {
            var costoTotal = 0 ;
            
            for(var i = 0 ; i < response.length;i++){
                var data = response[i].insumo;
                var tipo = '';
                if(data.tipo === '0'){
                    tipo = 'UD';
                } else if(data.tipo === '1'){
                    tipo = 'KG';
                } else if(data.tipo === '2'){
                    tipo = 'MT';
                } else if(data.tipo === '3'){
                    tipo = 'LT';
                }
                
                var precioReal = data.costo * data.cantidad;
                costoTotal += parseInt(precioReal);
                $("#insumos tbody").append("<tr><td>"+data.codigo+"</td><td>"+data.nombre+
                        "</td><td>"+data.descripcion+"</td><td>"+data.precio+"</td><td>"+
                        data.cantidad+"</td><td>"+tipo+"</td><td>"+precioReal+"</td></tr>");
            }
            $("#composicion_producto").css('visibility','visible');
            $("#composicion_producto").show();
        };
        postRequest(url,params,success);
    }
    
    function getInsumos(){
        var params = {};
        var url = "source/httprequest/insumo_producto/GetInsumos.php";
        var success = function(response)
        {            
            for(var i = 0 ; i < response.length;i++){
                let insumo = response[i];
                insumos.set(insumo.codigo,insumo.nombre);
            }
        };
        postRequest(url,params,success);
    }
    
    function abrirModificar(codigo, mod = false){
        var url = "source/httprequest/producto/GetProducto.php";
        var params = {codigo : codigo,nivel:"1"};
        var success = function(response)
        {
            if(response.producto_nombre !== undefined){
                $("#delStock").prop("disabled",false);
                $("#codigo").val(codigo);
                $("#nombre").val(response.producto_nombre);
                $("#descripcion").val(response.producto_descripcion);
                $("#costo").val(Math.round((parseFloat(response.producto_coste) + parseFloat(response.producto_coste_iva))));
                $("#precio").val(Math.round((parseFloat(response.producto_precio) + parseFloat(response.producto_precio_iva))));
                $("#tipo").val(response.producto_tipo);
                if(response.producto_inventario ==='1'){
                    $("#inventario").prop('checked',true);
                } else{
                    $("#inventario").prop('checked',false);
                }
                $("#existencia").val(response.producto_cantidad);
                $("#addStock").val("0");
                $("#delStock").val("0");
                $("#img").attr("src",response.producto_imagen === '' ? 'img/default.jpg' : 'img/productos/'+response.producto_imagen);
                accion = 'modificar';
                $("#detalle_producto").css('visibility','visible');
                $("#detalle_producto").show();
            }
            else{
                accion = 'agregar';
                if(mod){
                    alertify.error("Producto no disponible");
                }
                reset();
            }
        };
        postRequest(url,params,success);
    }
    
    function guardarProducto(){
        let codigo = $("#codigo").val();
        let nombre = $("#nombre").val();
        let descripcion = $("#descripcion").val();
        let precioCosto = $("#costo").val()===''?'0':$("#costo").val();
        let precioVenta = $("#precio").val();
        let tipo = $("#tipo").val();
        let imagen = $("#imagenOculta").val();
        let existencia = $("#existencia").val();        
        let addStock = $("#addStock").val();
        let delStock = $("#delStock").val();
        let inventario = $("#inventario").prop("checked")?1:0;
        let manufacturado = $("#manufacturado").prop("checked")?1:0;
        if(codigo === '' || nombre === '' || descripcion === '' || precioVenta === ''){
            alertify.error("Ingrese todos los campos necesarios");
            return;
        }
        if(manufacturado === 0){
            if(!validarNumero(precioCosto)){
                alertify.error("Precio costo debe ser numérico");
                return;
            }
        }
        if(!validarNumero(precioVenta)){
            alertify.error("Precio venta debe ser numérico");
            return;
        }
        if(!validarNumero(existencia)){
            alertify.error("Existencia debe ser numérico");
            return;
        }
        if(!validarNumero(addStock)){
            alertify.error("Agregar Stock debe ser numérico");
            return;
        }
        if(!validarNumero(delStock)){
            alertify.error("Quitar stock debe ser numérico");
            return;
        }
        if (parseInt(precioCosto) >= parseInt(precioVenta)){
            alertify.error("El precio de costo no puede ser igual o mayor al precio de venta");
            return;
        }
        if (parseInt(addStock) > 100000){
            alertify.error("Agregar stock debe ser menor o igual a 100000");
            $("#addStock").val("0");
            return;
        }
        if (parseInt(delStock) > 100000){
            alertify.error("Quitar stock debe ser menor o igual a 100000");
            $("#delStock").val("0");
            return;
        }
        
        var params = {codigo : codigo, nombre : nombre,descripcion : descripcion, 
            precioCosto : precioCosto, precioVenta : precioVenta,tipo : tipo, imagen: imagen,
            existencia : existencia, addStock: addStock, delStock: delStock,nivel:"1",inventario:inventario,
            manufacturado:manufacturado};
        if(accion === 'agregar'){
            agregarProducto(params);
        }
        else{
            modificarProducto(params);
        }   
    }

    function modificarProducto(params){
        let url = "source/httprequest/producto/ModProducto.php";
        let success = (response)=>{
            if(response.error === undefined){
                $("#detalle_producto").css('visibility','hidden');
                $("#detalle_producto").hide();
                cargarProductos();
                alertify.success(response.mensaje);
            }
            else if(response.error === '-5'){
                
            }
            else{
                alertify.error(response.error);
            }
        };
        postRequest(url,params,success);
    }
    
    function agregarProducto(params){
        let url = "source/httprequest/producto/AddProducto.php";
        let success = (response)=>{
            if(response.error === undefined){
                $("#detalle_producto").css('visibility','hidden');
                $("#detalle_producto").hide();
                cargarProductos();
                alertify.success(response.mensaje);
            }
            else if(response.error === '-5'){
                cargarProductoNombre(params.nombre);
            }
            else{
                alertify.error(response.error);
            }
        };
        postRequest(url,params,success);
    }
    
    function eliminarProducto(codigo){
        confirmar('Eliminar producto','Esta seguro que desea eliminar el producto '+codigo,()=>{
            let url = "source/httprequest/producto/DelProducto.php";
            let success = (response)=>{
                if(response.error === undefined){
                    cargarProductos();
                    alertify.success(response.mensaje);
                } else{
                    alertify.error(response.error);
                }
            };
            var params = {codigo : codigo,nivel:"1"};
            postRequest(url,params,success); 
        },()=>{
            
        });
    }
    
    function cargarProductoNombre(nombre){
        let params = {nombre: nombre,nivel:"1"};
        let url = "source/httprequest/producto/GetProductoNombre.php";
        let success = (response)=>{
            let producto = response;
            confirmar('Producto repetido','El producto '+nombre+
                    " esta asociado al codigo " + producto.producto_codigo + ", ¿ desea editar el producto "+producto.producto_id+" ?",
            ()=>{
                abrirModificar(producto.producto_codigo);
                return;
            },
            ()=>{
                return;
            });
        };
        postRequest(url,params,success); 
    }
    
    function reset(){
        //$("#codigo").val("");
        $("#nombre").val("");
        $("#descripcion").val("");
        $("#costo").val("");
        $("#precio").val("");
        $("#depto").val("");
        $("#tipo").val("0");
        $("#existencia").val("0");
        $("#addStock").val("0");
        $("#delStock").val("0");
        $("#nuevo").val("0");
        $("#normal").val("0");
        $("#premium").val("0");
        $("#catalogo").prop("checked",false);
        $("#img").attr("src","img/default.jpg");
    }
   
    function ocultar(){
        $("#detalle_producto").css('visibility','hidden');
        $("#detalle_producto").hide();
    }
    
    function eliminarInsumoProducto(id){
        confirmar('Eliminar insumo','Esta seguro que desea eliminar este insumo ?',
            ()=>{
                $("#tr_"+id).remove();
                let insumo = id;
                let producto = productoAux;
                let params = {insumo: insumo,producto:producto};
                let url = "source/httprequest/insumo_producto/DelInsumoProducto.php";
                let success = (response)=>{
                    verComposicion(productoAux);
                    alertify.success('Insumo eliminado');

                };
                postRequest(url,params,success); 
            },
            ()=>{
                return;
            });
    }
    
    function verInsumo(){
        let insumo = $("#nombreInsumo").val();
        let params = {id:insumo};
        let url = "source/httprequest/insumo_producto/GetInsumo.php";
        let success = (response)=>{
            insumoAux = response.codigo;
            //$("#nombreInsumo").val(response.nombre);
            $("#descripcionInsumo").val(response.descripcion);
            var precio = aplicarLeyRedondeo(parseInt(response.precio) + parseInt(response.precioIva));
            $("#costoInsumo").val(precio);
            $("#tipoInsumo").val(response.tipo);
                    
            if(response.tipo === '0'){
                $("#cantidadInsumo").val("1");
                $("#cantidadInsumo").attr("step","1");
            } else{
                $("#cantidadInsumo").val("1");
                $("#cantidadInsumo").attr("step","0.125");
            }
        };
        postRequest(url,params,success); 
    }
    
    function agregarInsumoProducto(){
        if($("#nombreInsumo").val()==="" || $("#descripcionInsumo").val()==="" || $("#costoInsumo").val()==="" || $("#tipoInsumo").val()===""){
            alertify.error("Ingrese todos los campos necesarios");
            return;
        }
        let url ='';

        if(insumos_agregados.get($("#nombreInsumo").val())!==undefined){
            url = "source/httprequest/insumo_producto/ModInsumoProducto.php";
        } else{
            url = "source/httprequest/insumo_producto/AddInsumoProducto.php";
        }
        let cantidad = $("#cantidadInsumo").val();
        let params = {insumo:insumoAux,producto:productoAux,cantidad:cantidad};
        let success = (response)=>{
            insumos_agregados.set($("#nombreInsumo").val(),$("#nombreInsumo").val());
            $("#nombreInsumo").val("");
            $("#descripcionInsumo").val("");
            $("#costoInsumo").val("");
            $("#tipoInsumo").val("");
            console.log(insumos_agregados)
            verComposicion(productoAux);
        };
        postRequest(url,params,success); 
    }