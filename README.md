# CHUPAPRECIOS
## Back End Developer

## Index

- [Requerimientos](#the-task)
- [Instalación](#installation)
- [Instalación](#installation)
- [API endpoints](#api-endpoints)
  - [GET /api/customers](#get-apicustomers)
  - [GET /api/customers/id](#get-apicustomersid)
- [Unit Testing](#unit-testing)

## Requerimientos (Modulo de Magento)

1 - Crear un módulo que mande a una página en una ruta dada y muestre un mensaje, la página no estará en blanco con el mensaje sino que se cargará el diseño del sitio. (cabecera, footer y todo el layout)

2 - Agregar una campo en Store -> Configuration -> “Mi Configuracion” que sea "sobreprecio" y otro campo, "costo envió" y pueda el administrador cambiar este valor según lo necesite

3 - Extender un módulo del core, concretamente la búsqueda y que sobreescriba el resultado de esta, cambiando el precio de los productos por "precio del producto" + "sobreprecio" creado en el ejercicio anterior.

4 - Crear un método de envío nuevo con un costo igual al campo "costo envío" y que esté disponible en el checkout

5 - Crear un observer que se ejecute luego de la compra y que escriba en un log en consola, archivo o donde te quede mas cómodo, un json con los artículos que se compraron, todos los costos y los datos del cliente que compro.

6 - Agregar campos al checkout, puede ser un campo de texto "comentarios" que permita ingresar un texto y un select que sea obligatorio y permita seleccionar entre por lo menos 2 valores por ejemplo si el select se llama "sexo" permitiría seleccionar entre "hombre" o "mujer".


## Requisitos


Se requiere una instalación de magento activa, éste módulo se probó con las siguientes características:

- Magento 2.3.7
- PHP 7.4
- MySQL 5.7
- Composer 1.10



## Instalación

Bajar el repositorio de GIT.
```shell 
git clone git@github.com:reynaldoeg/magento2_module_test.git
```

Este módulo deberá copiarse (o descargarse directamente) en la ruta:

```shell 
app/code/ChupaPrecios/TechnicalTest/
```



Ejecutar los siguientes comandos en la raíz del proyecto
```shell 
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy
```


## Test

Para hacer las pruebas asumiremos que el sito esta configurado para visualizarse en la ruta local http://magento.local.com/

1. Para ver la página creada visitar la url:


```shell 
http://magento.local.com/example
```



2. Para ver el nuevo campo de configuración, entrar al administrador del sitio, menú Stores => Configuration => Pestaña "Chupaprecios" => "Mi Configuración"


3. TODO

4. Para ver la configuración del nuevo método de envío, entrar al administrador del sitio, menú Stores => Configuration => Pestaña "Sales" => "Shipping Methods" => "Chupaprecios Shipping Method". Verificar que esté activado.

Para ver el método de envío en el front, se debe agregar un producto y dirigirse al checkout, éste aparecerá en la sección de "Shipping Methods"

5. Una vez realizada la compra, para ver los logs que registra el observer creado, abrir el archivo: var/log/system.log, al final, deberá verse el JSON con la información de la compra:

```json 
{
   "order_id":"000000016",
   "created_at":"2023-06-06 04:01:12",
   "customer_id":null,
   "customer_firstname":"Anonimous",
   "customer_lastname":"Test",
   "customer_email":"anonimous@mailinator.com",
   "subtotal":"33.0000",
   "shipping":"5.0000",
   "total":"38.0000",
   "items":[
      {
         "product_id":"11",
         "name":"Endeavor Daytrip Backpack",
         "sku":"24-WB06",
         "qty_ordered":"1.0000",
         "price":"33.0000",
         "original_price":"33.0000"
      }
   ]
}
```

6. Para ver los nuevos campos del checkout, se deberá agregar un producto al carrito y dirigirse al checkout (no estar logueado), debajo de los campos de dirección aparecerán los nuevos campos: "Phone Type" y "Delivery Notes"


Para ver los nuevos campos desde el admin, abrir la orden generada y aparecerán en la sección de "Account Information" y "Additional Information"


