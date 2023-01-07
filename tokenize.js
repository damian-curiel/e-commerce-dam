//Inicializa checkout
const deunaCheckout = window.DunaCheckout();

//Función para abrir widget con orden tokenizada

async function shouldOpen()
{
   // const shouldOpen = async () => {
    try 
 {
//Variables de DB y payload de orden, todo debe estar en mismo bloque para pasar token de orden a widget
        $.ajax
    ({
 
            url:'servicios/pedido/get_porprocesar.php',
            type:'POST',
            data:{},
            success:async function(data){
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
                    Nombre+=data.datos[i].nompro+'+ ';
                    console.log("Producto: ",Nombre);
                    Descripcion+=data.datos[i].despro+'+ ';
                    console.log("Desc: ",Descripcion);
                    Imagen=data.datos[i].imagen;
                    console.log("Img: ",Imagen);
                }

                        //Generador de # de orden aleatorio
                    let r = (Math.random() + 1).toString(36).substring(7);
                    console.log("random", "orden"+ r);

                    const tax = total*0.15;
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
                        ],/*
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
                        ],*/
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
                    };

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
    
}})} catch (error) {
        alert(error);
    }
}

     