<?php
	session_start();
	if (!isset($_SESSION['codusu'])) {
		header('location: index.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>DEUNA CHECKOUT 🤌🏼</title>
<!-- 	<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>		-->
	<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
	<link href="https://fonts.googleapis.com/css?family=Sen&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<!-- Cross Domain Login -->
	<script src="https://cdn.getduna.com/cdl/index.js"></script>
    <!-- DEUNA Checkout Widget-->
    <script src="https://cdn.getduna.com/checkout-widget/index.js"></script>
	<!--Payload de orden, tokenización y render de widget -->
	<script src="tokenize.js"></script>
	
</head>
<body>
	<header>
		<div class="logo-place"><a href="index.php"><img src="assets/logo.png"></a></div>
		<div class="search-place">
			<input type="text" id="idbusqueda" placeholder="Encuenta todo lo que necesitas...">
			<button class="btn-main btn-search"><i class="fa fa-search" aria-hidden="true"></i></button>
		</div>
		<div class="options-place">
			<?php
			if (isset($_SESSION['codusu'])) {
				echo
				'<div class="item-option"><i class="fa fa-user-circle-o" aria-hidden="true"></i><p>'.$_SESSION['nomusu'].'</p></div>';
			}else{
			?>
			<div class="item-option" title="Registrate"><i class="fa fa-user-circle-o" aria-hidden="true"></i></div>
			<div class="item-option" title="Ingresar"><i class="fa fa-sign-in" aria-hidden="true"></i></div>
			<?php
			}
			?>
			<div class="item-option" title="Mis compras">
				<a href="carrito.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
			</div>
		</div>
	</header>
	<div class="main-content">
		<div class="content-page">
			<h1>Mi carrito 🛒</h1>
			<div class="body-pedidos" id="space-list">
			</div>
<!--
			<input class="ipt-procom" type="text" id="dirusu" placeholder="Dirección">
			<br>
			<input class="ipt-procom" type="text" id="telusu" placeholder="Celular">
			<br>
			<h4>Tipos de pago</h4>
			<div class="metodo-pago">
				<input type="radio" name="tipopago" value="1" id="tipo1">
				<label for="tipo1">Pago por transferencia</label>
			</div>
			<div class="metodo-pago">
				<input type="radio" name="tipopago" value="2" id="tipo2">
				<label for="tipo2">Pago con tarjeta de crédito/débito</label>
			</div>
--> 			
			<!--<button onclick="procesar_compra()" style="margin-top: 5px;">Procesar compra</button>--> 
			<br><br>
			<button id="button-checkout-deuna" onclick="shouldOpen()">
  			<img src="https://images.getduna.com/logo-full-deuna-D.svg" alt=" DEUNA"> Pagar Ahora
			</button>
		</div>
	</div>

	<!--
<script>
//Variables de DB y payload de orden

$.ajax({
        url:'servicios/pedido/get_porprocesar.php',
        type:'POST',
        data:{},
        success:function(data){
            console.log(data);
            let sumaMonto=0;
            let total=00;
            let Nombre="";
            let Descripcion="";
            let Imagen="";
            for (var i = 0; i < data.datos.length; i++) {
                
                sumaMonto+=Math.floor(data.datos[i].prepro);
                total= ""+sumaMonto+0;
                total= ""+total+0;
                console.log("Total",total);
                Nombre+=data.datos[i].nompro;
                console.log("Producto: ",Nombre);
                Descripcion+=data.datos[i].despro;
                console.log("Desc: ",Descripcion);
                Imagen+=data.datos[i].imagen;
                console.log("Img: ",Imagen);
            }


//Generador de # de orden aleatorio
let r = (Math.random() + 1).toString(36).substring(7);
console.log("random", "orden"+ r);

const tax = 1500;
const envio = 5000;
const descuento = 10000;
const subtotal = +total+tax+envio;
//+++++++++ARRIBA SE OBTENIERON VARIABLES DE PRODUCTOS PARA CREAR ORDEN+++++++++++++

//######################TOKENIZACION DE ORDEN###############################

const datos = {
    "checkout_flow": "TOKENIZATION_PLUGINS",
    "order": {
        "order_id": "DEUNA_Orden_"+r,
        "currency": "MXN",
        "timezone": "America/Mexico_City",
        "tax_amount": tax,
        "shipping_amount": envio,
        "items_total_amount": total,
        "sub_total": total,
        "total_amount": subtotal,
        "store_code": "cdmx1",
        "webhook_urls": {
            "notify_order": "https://webhook.site/1f21c2b3-7e52-4dba-94f0-079a0daef64b",
            "apply_coupon": "https://{url_comercio}/api/v1/orders/{order_token}/coupons",
            "remove_coupon": "https://{url_comercio}/api/v1/orders/{order_token}/coupons/{coupon_code}",
            "get_shipping_methods": "",
            "update_shipping_method": "",
            "shipping_rate": "https://webhook.site/1f21c2b3-7e52-4dba-94f0-079a0daef64b"
        },
        "items": [
            {
                "id": "666",
                "name": Nombre,
                "description": Descripcion,
                "options": "opciones, sólo físico",
                "total_amount": {
                    "amount": total,
                    "currency": "MXN",
                    "currency_symbol": "$"
                },
                "unit_price": {
                    "amount": total,
                    "currency": "MXN",
                    "currency_symbol": "$"
                },
                "tax_amount": {
                    "amount": tax,
                    "currency": "MXN",
                    "currency_symbol": "$"
                },
                "quantity": 1,
                "uom": "string",
                "upc": "string",
                "sku": "SKU-11021",
                "isbn": "",
                "brand": "DEUNA GameStore",
                "manufacturer": "DEUNA Studios",
                "category": "Videogames",
                "color": "",
                "size": "",
                "weight": {
                    "weight": 600,
                    "unit": "gr"
                },
                "image_url": Imagen,
                "details_url": "https://image.api.playstation.com/vulcan/ap/rnd/202205/2017/Ry0b7FGqNjHQvNRpRE9RjU3I.png",
                "type": "physical",
                "taxable": false
            }
        ],
        "discounts": [
            {
                "amount": descuento,
                "code": "DEUNA100",
                "reference": "DEUNA100",
                "description": "100 pesos de descuento en compras mayores a 1,000 pesos",
                "details_url": "https://your-ecommerce.com/discounts/#12345",
                "free_shipping": {
                    "is_free_shipping": true,
                    "maximum_cost_allowed": descuento
                },
                "discount_category": "coupon"
            }
        ],
        "shipping_address": {
            "id": 1868,
            "user_id": "2ae5e29e-459e-4f9c-b4d4-638885d2f4aa",
            "first_name": "Damián",
            "last_name": "Curiel",
            "phone": "593999999999",
            "identity_document": "1150218418",
            "lat": -0.100032,
            "lng": -78.46956,
            "address1": "Rancho de Los Arcos 24, Coapa, Girasoles II, Coyoacán, 04920 Ciudad de México, CDMX, México",
            "city": "cdmx",
            "zipcode": "09880",
            "state_name": "cdmx",
            "country": "MEX",
            "additional_description": "Descripción adicional",
            "address_type": "home",
            "is_default": true,
            "created_at": "2021-11-03T22:09:09.086990957Z",
            "updated_at": "2021-11-03T22:09:09.087014623Z"
        },
        "shipping_options": {
            "type": "delivery",
            "details": {
                "store_name": "cdmx1",
                "address": "José Luis Lagrange 103, Polanco, Polanco I Secc, Miguel Hidalgo, 11510 Ciudad de México, CDMX, México",
                "address_coordinates": {
                    "lat": 19.4383287,
                    "lng": -99.2132272
                },
                "contact": {
                    "name": "jhon snow",
                    "phone": "972514910"
                },
                "additional_details": {
                    "address_notes": "Piso 12"
                }
            }
        },
        "user_instructions": "This item is a gift."
    }
}
console.log(datos);

	const options = {   
	method: 'POST',
	headers:{
		'content-type': 'application/json',
		'X-API-KEY': '3b6b9679f3147da1f49bb0802b0267abfbcb5cd4756517dcf3d303874d7236b90ad56ad8b32917c9800632c1de3d4cc9f7edd94527ad61fa5c958a8c66ef',
			},
	body: JSON.stringify(datos)
}

async function shouldOpen(){
//    const shouldOpen = async () => {
    try {
        const respuesta = await fetch('https://api.stg.deuna.io/merchants/orders', options);

    const token = await respuesta.json();
	console.log("token:",token.token);

    //Setup del checkout widget
    
    await deunaCheckout.configure({
        env: "staging",
        apiKey: "ce936cff1a2f9e61bc71d25ef936184fef35ba2251a67979025833e5c532fed20fc156650aee2fe5625c71167165e192cdb97b5906b13d52c8e4d82a197b",
      //  orderToken: "1003b539-8c40-409c-9385-39e98090465a",
        orderToken: token.token,
      });
      await deunaCheckout.show();
    } catch (error) {
        alert(error);
      }	<script src="tokenize.js"></script>
    };
</script>
-->

<script>

//console.log(options);
		$(document).ready(function(){
			$.ajax({
				url:'servicios/pedido/get_porprocesar.php',
				type:'POST',
				data:{},
				success:function(data){
					//console.log(data);
					let html='';
					let sumaMonto=0;
					let total=00;
					let Nombre="";
					let Descripcion="";
					let Imagen="";
					for (var i = 0; i < data.datos.length; i++) {
						html+=
						'<div class="item-pedido">'+
							'<div class="pedido-img">'+
								'<img src="assets/products/'+data.datos[i].rutimapro+'">'+
							'</div>'+
							'<div class="pedido-detalle">'+
								'<h2>'+data.datos[i].nompro+'</h2>'+
								'<h3>'+data.datos[i].despro+'</h3>'+								
								'<p><b>Fecha:</b> '+data.datos[i].fecped+'</p>'+
								'<p><b>Estado:</b> '+data.datos[i].estado+'</p>'+
								'<h2><b>Total:</b> $ '+data.datos[i].prepro+'</h2>'+
							'</div>'+
						'</div>';

					}

	    Culqi.settings({
				        title: 'Mi tienda',
				        currency: 'PEN',
				        description: 'Productos escolares',
				        amount: sumaMonto
				    });
					document.getElementById("space-list").innerHTML=html;
				},
				error:function(err){
					console.error(err);
				}
			});
		});

	</script>
	<script src="https://checkout.culqi.com/js/v3"></script> 
	<script>
	  //  Culqi.publicKey = 'pk_test_3adf22bd8acf4efc';
	</script>
</body>
</html>

