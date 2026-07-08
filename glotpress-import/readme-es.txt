=== Plogins Bundle - Product Bundles for WooCommerce ===
Contributors: motylanogha
Tags: woocommerce, product bundles, frequently bought together, bundle discount, upsell
Requires at least: 6.5
Tested up to: 7.0
Requires PHP: 8.1
Stable tag: 1.0.1
Requiere complementos: woocommerce
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Venda paquetes de productos y ofertas combinadas compradas con frecuencia con un descuento opcional en el paquete WooCommerce.

== Description ==

Bundle añade un cuadro de paquete de productos "comprados juntos con frecuencia" a las páginas de productos de WooCommerce. Vincule cualquier cantidad de productos a un producto, establezca un descuento de paquete opcional y permita que los clientes agreguen el conjunto completo de productos al carrito con un solo clic.

* Un cuadro de paquete debajo del resumen del producto que enumera los productos incluidos.
* "Añadir paquete al carrito" añade el producto principal más todos los artículos vinculados a la vez.
* Descuento de paquete opcional, que se aplica como tarifa de carrito único o como ajuste de precio por artículo.
* Una línea de ahorro opcional que muestra el total del paquete y el monto ahorrado.
* Un código corto `[bundle]` para colocar la caja del paquete en cualquier lugar, use `[bundle id="123"]` para apuntar a un producto específico.
* Título de cuadro editable, etiqueta de botón y etiqueta de línea de descuento, todo traducible.
* Las definiciones de paquetes se almacenan como metadatos de productos, sin tablas de bases de datos personalizadas.
* Desinstalación limpia: elimina sus opciones y definiciones de paquetes cuando se elimina.
* Una pequeña hoja de estilo, sin JavaScript en el escaparate y sin jQuery. Las imágenes reservan su espacio para que el cuadro no cambie el diseño a medida que se carga y siga la preferencia de modo oscuro del visitante.
* A "?" Burbuja de ayuda en cada configuración, accesible mediante el teclado, además el cuadro se oculta cuando a un producto no le queda ningún paquete para mostrar.

Configure el comportamiento global en WooCommerce → Paquete. Vincula productos y establece el descuento por producto en la pestaña "Paquete" del editor de productos. Desactive "Mostrar en la página del producto" para mostrar el cuadro solo donde coloca el código corto `[bundle]`.

El complemento se desarrolla de forma abierta. Código, informes de errores y parches disponibles en https://github.com/wppoland/plogins-bundle.

== Installation ==

1. Cargue el complemento en `/wp-content/plugins/bundle`, o instálelo a través de Complementos → Añadir nuevo.
2. Actívalo. WooCommerce debe estar activo.
3. Edite un producto, abra la pestaña "Paquete", ingrese los ID de los productos incluidos y un descuento opcional, luego guarde.
4. Ajuste las opciones globales en WooCommerce → Paquete.

== Frequently Asked Questions ==

= Documentation and links =

* <strong>Documentación</strong> - https://plogins.com/es/plogins-bundle/docs/
* <strong>Página de complementos</strong> - https://plogins.com/es/plogins-bundle/
* <strong>Código fuente</strong> - https://github.com/wppoland/plogins-bundle
* <strong>Informes de errores y solicitudes de funciones</strong> - https://github.com/wppoland/plogins-bundle/issues


= Does it require WooCommerce? =

Sí. WooCommerce debe estar instalado y activo.

= How is the discount applied? =

Elija entre una única tarifa de carrito negativa (una línea en el carrito) o un ajuste de precio por artículo en cada producto incluido. Configure esto en WooCommerce → Paquete.

= Can a bundle include a discount? =

Sí. Establezca un porcentaje de descuento opcional por paquete de productos. El paquete puede mostrar el total del paquete y la línea de ahorro antes de agregarlo al carrito.

= Does the bundle add all products to the cart? =

Sí. El botón "Añadir paquete al carrito" añade el producto principal y los productos vinculados.

= Does it create custom database tables? =

No. Las definiciones de paquetes se almacenan como meta de producto.

= Can I place the bundle box somewhere other than under the product summary? =

Sí. Utilice el código abreviado `[bundle]` en cualquier lugar donde se conozca el producto actual, o `[bundle id="123"]` para representar el paquete de un producto específico. Desactive "Mostrar en la página del producto" en WooCommerce → Paquete para usar solo el código corto.

= Does Bundle use JavaScript on the storefront? =

No. El paquete gratuito se procesa en el servidor con una pequeña hoja de estilo y sin JavaScript en la tienda.


= Does this plugin work on WordPress Multisite? =

Sí. Este complemento es compatible con WordPress Multisite. Activarlo en red o activarlo en sitios individuales; Cada sitio mantiene su propia configuración y datos.

== Screenshots ==

1. En el escaparate.
2. Configuración en el administrador de WordPress.
3. En un dispositivo móvil.
== External Services ==

El paquete no se conecta a ningún servicio externo. No realiza llamadas API remotas y no envía datos fuera de tu sitio. Su única hoja de estilo y script de administración se obtienen desde su propia instalación de WordPress (`assets/css/bundle.css`, `assets/css/admin.css` y `assets/js/admin.js`), sin fuentes, CDN ni análisis de terceros. Todos los datos permanecen en tu base de datos: opciones globales en `bundle_settings` y `bundle_db_version`, y el paquete de cada producto en el meta de la publicación `_bundle_definition`. El complemento no envía ningún correo electrónico.

== Changelog ==

= 1.0.1 =
* Primera versión estable.

= 0.2.1 =
* Renombrado a Plogins Bundle para WooCommerce para obtener un nombre de complemento más distintivo.

= 0.2.0 =
* Página de configuración dispuesta en forma de tarjetas, con un "?" Burbuja de ayuda que explica cada opción.
* Caja de escaparate rediseñada: tamaño fluido, compatibilidad con modo oscuro, espacio de imagen reservado para que no cambie el diseño y una línea de ahorro que detalla la cantidad ahorrada.
* Accesibilidad: burbujas de ayuda operables por teclado, estilos de enfoque visibles y soporte de movimiento reducido.
* Los productos agrupados eliminados o faltantes se omiten y el cuadro se oculta cuando no queda nada por agrupar.
* Nuevo: código abreviado `[bundle]` para representar el cuadro del paquete en cualquier lugar, con un atributo opcional `id` para apuntar a un producto específico.
* Nuevo: opción "Mostrar ahorros" que muestra el total del paquete y el monto ahorrado en la caja.
* Nuevo: el título del cuadro guardado por el administrador, la etiqueta del botón y la etiqueta de la línea de descuento ahora son utilizados por el cuadro del paquete (anteriormente el cuadro los ignoraba).
* Nuevo: la desinstalación limpia elimina las opciones del complemento y todas las definiciones de paquetes almacenadas.
* I18n: regeneró la plantilla de traducción con las nuevas cadenas.

= 0.1.0 =
* Lanzamiento inicial.
