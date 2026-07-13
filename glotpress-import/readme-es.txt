=== Plogins Bundle - Product Bundles for WooCommerce ===
Contributors: motylanogha
Tags: woocommerce, product bundles, frequently bought together, bundle discount, upsell
Requires at least: 6.5
Tested up to: 7.0
Requires PHP: 8.1
Stable tag: 1.0.2
Requiere plugins: woocommerce
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Vende paquetes de productos y ofertas de «comprados juntos con frecuencia» con un descuento de paquete opcional de WooCommerce.

== Description ==

Bundle añade un cuadro de paquete «comprados juntos con frecuencia» a tus páginas de producto de WooCommerce. Vincula cualquier número de productos a un producto, define un descuento de paquete opcional y permite a los clientes añadir todo el conjunto al carrito con un solo clic.

* Un cuadro de paquete bajo el resumen del producto que lista los productos incluidos.
* «Añadir paquete al carrito» añade el producto principal y todos los artículos vinculados a la vez.
* Descuento de paquete opcional, aplicado como una sola tarifa en el carrito o como ajuste de precio por artículo.
* Una línea de ahorro opcional que muestra el total del paquete y el importe ahorrado.
* Shortcode `[bundle]` para colocar el cuadro del paquete en cualquier sitio; usa `[bundle id="123"]` para apuntar a un producto concreto.
* Título del cuadro, etiqueta del botón y etiqueta de la línea de descuento editables, todo traducible.
* Las definiciones de paquete se almacenan como metadatos del producto, sin tablas de base de datos personalizadas.
* Desinstalación limpia: elimina sus opciones y definiciones de paquete al borrarlo.
* Una hoja de estilos pequeña, sin JavaScript en la tienda y sin jQuery. Las imágenes reservan su espacio para que el cuadro no provoque saltos de diseño al cargar y respete la preferencia de modo oscuro del visitante.
* Una burbuja de ayuda «?» en cada ajuste, accesible con el teclado; el cuadro se oculta cuando a un producto no le queda ningún paquete que mostrar.

Configura el comportamiento global en WooCommerce → Bundle. Vincula productos y define el descuento por producto en la pestaña «Bundle» del editor de productos. Desactiva «Mostrar en la página del producto» para renderizar el cuadro solo donde insertes el shortcode `[bundle]`.

El plugin se desarrolla de forma abierta (código abierto). El código, los informes de errores y los parches están en https://github.com/wppoland/plogins-bundle.

== Installation ==

1. Sube el plugin a `/wp-content/plugins/bundle` o instálalo desde Plugins → Añadir nuevo.
2. Actívalo. WooCommerce debe estar activo.
3. Edita un producto, abre la pestaña «Bundle», introduce los ID de los productos del paquete y un descuento opcional, y guarda.
4. Ajusta las opciones globales en WooCommerce → Bundle.

== Frequently Asked Questions ==

= Documentation and links =

* <strong>Documentación</strong> - https://plogins.com/es/plogins-bundle/docs/
* <strong>Página del plugin</strong> - https://plogins.com/es/plogins-bundle/
* <strong>Código fuente</strong> - https://github.com/wppoland/plogins-bundle
* <strong>Informes de errores y peticiones de funciones</strong> - https://github.com/wppoland/plogins-bundle/issues


= Does it require WooCommerce? =

Sí. WooCommerce debe estar instalado y activo.

= How is the discount applied? =

Elige entre una sola tarifa negativa en el carrito (una línea en el carrito) o un ajuste de precio por artículo en cada producto del paquete. Configúralo en WooCommerce → Bundle.

= Can a bundle include a discount? =

Sí. Define un descuento porcentual opcional por paquete de productos. Bundle puede mostrar el total del paquete y la línea de ahorro antes de añadir al carrito.

= Does the bundle add all products to the cart? =

Sí. El botón «Añadir paquete al carrito» añade el producto principal y los productos vinculados juntos.

= Does it create custom database tables? =

No. Las definiciones de paquete se almacenan como metadatos del producto.

= Can I place the bundle box somewhere other than under the product summary? =

Sí. Usa el shortcode `[bundle]` en cualquier sitio donde se conozca el producto actual, o `[bundle id="123"]` para renderizar el paquete de un producto concreto. Desactiva «Mostrar en la página del producto» en WooCommerce → Bundle para usar solo el shortcode.

= Does Bundle use JavaScript on the storefront? =

No. El cuadro de paquete gratuito se renderiza en el servidor con una hoja de estilos pequeña y sin JavaScript en la tienda.


= Does this plugin work on WordPress Multisite? =

Sí. Este plugin es compatible con WordPress Multisite. Actívalo en red o en sitios concretos; cada sitio conserva sus propios ajustes y datos.

== Screenshots ==

1. En la tienda.
2. Ajustes en la administración de WordPress.
3. En un dispositivo móvil.
== External Services ==

Bundle no se conecta a ningún servicio externo. No realiza llamadas API remotas ni envía datos fuera de tu sitio. Su única hoja de estilos y su script de administración se sirven desde tu propia instalación de WordPress (`assets/css/bundle.css`, `assets/css/admin.css` y `assets/js/admin.js`), sin fuentes, CDN ni analítica de terceros. Todos los datos permanecen en tu base de datos: opciones globales en `bundle_settings` y `bundle_db_version`, y el paquete de cada producto en el post meta `_bundle_definition`. El plugin no envía ningún correo electrónico.

== Translations ==

Plogins Bundle incluye traducciones al polaco, al alemán y al español para la interfaz del plugin. El dominio de texto es `plogins-bundle`, así que los paquetes de idioma de WordPress.org también pueden sustituir o ampliar estas traducciones incluidas.

== Changelog ==

= 1.0.2 =
* Añadidas traducciones incluidas al polaco, al alemán y al español para la interfaz del plugin.

= 1.0.1 =
* Primera versión estable.

= 0.2.1 =
* Renombrado a Plogins Bundle para WooCommerce, para un nombre de plugin más distintivo.

= 0.2.0 =
* Página de ajustes organizada en tarjetas, con una burbuja de ayuda «?» que explica cada opción.
* Cuadro de la tienda rediseñado: tamaño fluido, compatibilidad con modo oscuro, espacio de imagen reservado para evitar saltos de diseño y una línea de ahorro con el importe ahorrado.
* Accesibilidad: burbujas de ayuda operables con el teclado, estilos de foco visibles y soporte de movimiento reducido.
* Los productos del paquete eliminados o ausentes se omiten, y el cuadro se oculta cuando no queda nada que agrupar.
* Nuevo: shortcode `[bundle]` para renderizar el cuadro del paquete en cualquier sitio, con un atributo opcional `id` para apuntar a un producto concreto.
* Nuevo: opción «Mostrar ahorros» que muestra el total del paquete y el importe ahorrado en el cuadro.
* Nuevo: el título del cuadro, la etiqueta del botón y la etiqueta de la línea de descuento guardados en el admin ahora los usa el cuadro del paquete (antes los ignoraba).
* Nuevo: la desinstalación limpia elimina las opciones del plugin y todas las definiciones de paquete guardadas.
* I18n: plantilla de traducción regenerada con las nuevas cadenas.

= 0.1.0 =
* Lanzamiento inicial.
