<?php
	session_start();
	if (!isset($_SESSION['codusu'])) {
		header('location: index.php');
	}
	require_once("conekta-php-lib\conekta-php\lib\Conekta.php");
	\Conekta\Conekta::setApiKey("key_D8CpFzCk4x7Ho5Cr9xosgcA");
	\Conekta\Conekta::setApiVersion("2.0.0");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Mi sistema E-Commerce</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Sen&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>
	<?php include("layouts/_main-header.php"); ?>
	<div class="main-content">
		<div class="content-page">
			<h2>Mi carrito de compras</h2>
			<div class="body-pedidos" id="space-list">
			</div>
			<br>
			<h3>Seleccione un método de pago</h3>
			<div class="metodo-pago">
				<input type="radio" name="tipopago" value="1" id="tipo1">
				<img src="https://assets.conekta.com/cpanel/statics/assets/brands/logos/spei-24px.svg">
				<label for="tipo1">&nbsp &nbsp	Pago por transferencia SPEI</label>
			</div>
			<br>
			<div class="metodo-pago">
				<input type="radio" name="tipopago" value="2" id="tipo2">
				<img src="https://assets.conekta.com/cpanel/statics/assets/brands/logos/master-card-24px.svg">
				<label for="tipo2">&nbsp &nbsp Pago con tarjeta de crédito/débito</label>
			</div>
			<br>
			<div class="metodo-pago">
				<input type="radio" name="tipopago" value="3" id="tipo3">
				<img src="https://assets.conekta.com/cpanel/statics/assets/brands/logos/oxxo-pay-24px.svg">
				<label for="tipo3">&nbsp &nbsp Pago en efectivo con OXXO PAY</label>
			</div>
			<br><br>
			<button onclick="procesar_compra()" style="margin-top: 5px;">Procesar compra</button>
<br>
			<button onclick="oxxo()" style="margin-top: 5px;">Prueba oxxo</button>
		</div>
	</div>
	<?php include("layouts/_footer.php");
		require_once("conekta-php-lib\conekta-php\lib\Conekta.php");
		\Conekta\Conekta::setApiKey("key_D8CpFzCk4x7Ho5Cr9xosgcA");
		\Conekta\Conekta::setApiVersion("2.0.0");
	?>
	<script type="text/javascript" src="js/main-scripts.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$.ajax({
				url:'servicios/pedido/get_porprocesar.php',
				type:'POST',
				data:{},
				success:function(data){
					console.log(data);
					let html='';
				//	let sumaMonto=0;
					for (var i = 0; i < data.datos.length; i++) {
						html+=
						'<div class="item-pedido">'+
							'<div class="pedido-img">'+
								'<img src="assets/products/'+data.datos[i].rutimapro+'">'+
							'</div>'+
							'<div class="pedido-detalle">'+
								'<h3>'+data.datos[i].nompro+'</h3>'+
								'<p><b>Precio:</b> S/ '+data.datos[i].prepro+'</p>'+
								'<p><b>Fecha:</b> '+data.datos[i].fecped+'</p>'+
								'<p><b>Estado:</b> '+data.datos[i].estado+'</p>'+
								'<p><b>Dirección:</b> '+data.datos[i].dirusuped+'</p>'+
								'<p><b>Celular:</b> '+data.datos[i].telusuped+'</p>'+
								'<button class="btn-delete-cart" onclick="delete_product('+data.datos[i].codped+')">Eliminar</button>'+
							'</div>'+
						'</div>';
						//sumaMonto+=parseInt(data.datos[i].prepro)+1;
					}
					if (data.datos.length==0) {
						alert("No hay productos en carrito");
						window.history.back();
					}
				 
					document.getElementById("space-list").innerHTML=html;
				},
				error:function(err){
					console.error(err);
				}
			});
		});
		function delete_product(codped){
			$.ajax({
				url:'servicios/pedido/delete_pedido.php',
				type:'POST',
				data:{
					codped:codped,
				},
				success:function(data){
					console.log(data);
					if (data.state) {
						window.location.reload();
					}else{
						alert(data.detail);
					}
				},
				error:function(err){
					console.error(err);
				}
			});
		}


		function procesar_compra(){
			let dirusu="Avenida Siempre Viva 123";
			let telusu=5512345678;
			let tipopago=1;
			if (document.getElementById("tipo2").checked) {
				tipopago=2;
			}
			if (document.getElementById("tipo3").checked) {
				tipopago=3;
			}
		//	if (dirusu=="" || telusu=="") {
		//		alert("Complete los campos");
		//	}else{
				if (!document.getElementById("tipo1").checked &&
					!document.getElementById("tipo2").checked&&
					!document.getElementById("tipo3").checked) {
					alert("Seleccione un método de pago!");
				}else{
					if (tipopago==3) {

							var url = "https://api.conekta.io/orders";

							var xhr = new XMLHttpRequest();
							xhr.open("POST", url);

							xhr.setRequestHeader("accept", "application/vnd.conekta-v2.0.0+json");
							xhr.setRequestHeader("content-type", "application/json");
							xhr.setRequestHeader("Authorization", "Bearer key_7L2SkBYyugLtsRsydECwkQ");

							xhr.onreadystatechange = function () {
							if (xhr.readyState === 4) {
								console.log(xhr.status);
								console.log(xhr.responseText);
								var datos = JSON.parse(xhr.responseText);
								datos.order.id

								
							//	window.location.href="pedido.php";												
							}};

							var data = `{
								"line_items": [{
								"name": "Ecolapices Faber Castell",
								"unit_price": 1199,
								"quantity": 1
								}],
								"shipping_lines": [{
								"amount": 3500,
								"carrier": "UPS"
								}],
								"currency": "MXN",
								"customer_info": {
								"name": "Damián Curiel",
								"email": "Damian@conekta.com",
								"phone": "+5218181818181"
								},
								"shipping_contact":{
								"address": {
								"street1": "Calle 123, int 2",
								"postal_code": "06100",
								"country": "MX"
								}
								},
								"charges":[{
								"payment_method": {
									"type": "oxxo_cash",
									"expires_at": 1690872197
								}
								}]
							}`;

							xhr.send(data);
						//	window.location.href="pedido.php";
			
				}						//alert("Seleccione un método de pago2!");
						else{						
						if (tipopago==2) {
							window.location.href="web_checkout_tokenizer.html";

						/*	$.ajax({
								url:'https://api.conekta.io/orders',
								success:function(data){
									console.log(data);
									if (data.state) {
										window.location.href="pedido.php";
									}else{
										alert(data.detail);
									}
								},
								error:function(err){
									console.error(err);
								}
							});
							*/
						}else{
					
					alert("Pago con SPEI");
					}
					}
			}
		}
	</script>
	<script src="https://checkout.culqi.com/js/v3"></script>
	<script type="text/javascript" src="https://pay.conekta.com/v1.0/js/conekta-checkout.min.js"></script>


</body>
</html>

