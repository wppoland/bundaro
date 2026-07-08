=== Plogins Bundle - Product Bundles for WooCommerce ===
Contributors: motylanogha
Tags: woocommerce, product bundles, frequently bought together, bundle discount, upsell
Requires at least: 6.5
Tested up to: 7.0
Requires PHP: 8.1
Stable tag: 1.0.1
Erfordert Plugins: woocommerce
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Verkaufe Produktpakete und häufig zusammen gekaufte Angebote mit einem optionalen WooCommerce-Paketrabatt.

== Description ==

Bundle fügt deinen WooCommerce-Produktseiten eine „häufig zusammen gekaufte“ Produktpaketbox hinzu. Verknüpfe eine beliebige Anzahl von Produkten mit einem Produkt, lege einen optionalen Bundle-Rabatt fest und ermögliche Kunden, das gesamte Produktset mit einem Klick in den Warenkorb zu legen.

* Ein Paketfeld unter der Produktübersicht, in dem die gebündelten Produkte aufgeführt sind.
* „Paket zum Warenkorb hinzufügen“ fügt das Hauptprodukt und alle verknüpften Artikel auf einmal hinzu.
* Optionaler Paketrabatt, der entweder als Gebühr für einen einzelnen Warenkorb oder als Preisanpassung pro Artikel angewendet wird.
* Eine optionale Sparzeile, die die Paketsumme und den gesparten Betrag anzeigt.
* Ein Shortcode „[bundle]“, um die Bundle-Box an einer beliebigen Stelle zu platzieren. Verwende „[bundle id="123"]“, um ein bestimmtes Produkt anzusprechen.
* Bearbeitbarer Feldtitel, Schaltflächenbeschriftung und Rabattzeilenbeschriftung, alle übersetzbar.
* Bundle-Definitionen werden als Produkt-Meta gespeichert, keine benutzerdefinierten Datenbanktabellen.
* Saubere Deinstallation: Entfernt seine Optionen und Bundle-Definitionen, wenn es gelöscht wird.
* Ein kleines Stylesheet, kein JavaScript auf der Storefront und kein jQuery. Bilder reservieren ihren Platz, damit die Box beim Laden das Layout nicht verschiebt und den Dunkelmodus-Vorlieben des Besuchers folgt.
* A "?" Hilfe-Blase in jeder Einstellung, erreichbar über die Tastatur, außerdem wird die Box ausgeblendet, wenn für ein Produkt kein Bundle mehr angezeigt werden kann.

Konfiguriere das globale Verhalten unter WooCommerce → Bundle. Verknüpfe Produkte und lege den Rabatt pro Produkt im Reiter „Bundle“ des Produkteditors fest. Deaktiviere „Auf Produktseite anzeigen“, um das Feld nur dort anzuzeigen, wo Sie den Shortcode „[bundle]“ einfügen.

Das Plugin wird im Freien entwickelt. Code, Fehlerberichte und Patches live unter https://github.com/wppoland/plogins-bundle.

== Installation ==

1. Lade das Plugin nach „/wp-content/plugins/bundle“ hoch oder installiere es über Plugins → Neu hinzufügen.
2. Aktiviere es. WooCommerce muss aktiv sein.
3. Bearbeite ein Produkt, öffne die Registerkarte „Bundle“, gib die gebündelten Produkt-IDs und einen optionalen Rabatt ein und speichere dann.
4. Passe die globalen Optionen unter WooCommerce → Bundle an.

== Frequently Asked Questions ==

= Documentation and links =

* <strong>Dokumentation</strong> - https://plogins.com/de/plogins-bundle/docs/
* <strong>Plugin-Seite</strong> - https://plogins.com/de/plogins-bundle/
* <strong>Quellcode</strong> – https://github.com/wppoland/plogins-bundle
* <strong>Fehlerberichte und Funktionsanfragen</strong> – https://github.com/wppoland/plogins-bundle/issues


= Does it require WooCommerce? =

Ja. WooCommerce muss installiert und aktiv sein.

= How is the discount applied? =

Wähle zwischen einer einzelnen negativen Warenkorbgebühr (eine Zeile im Warenkorb) oder einer Preisanpassung pro Artikel für jedes gebündelte Produkt. Stelle dies unter WooCommerce → Bundle ein.

= Can a bundle include a discount? =

Ja. Lege einen optionalen prozentualen Rabatt pro Produktpaket fest. Das Bundle kann die Gesamtsumme des Bundles und die Sparzeile anzeigen, bevor es in den Warenkorb gelegt wird.

= Does the bundle add all products to the cart? =

Ja. Über die Schaltfläche „Paket zum Warenkorb hinzufügen“ werden das Hauptprodukt und die verknüpften Produkte zusammengefügt.

= Does it create custom database tables? =

Nein. Bundle-Definitionen werden als Produkt-Meta gespeichert.

= Can I place the bundle box somewhere other than under the product summary? =

Ja. Verwende den Shortcode „[bundle]“ überall dort, wo das aktuelle Produkt bekannt ist, oder „[bundle id="123"]“, um das Bundle eines bestimmten Produkts zu rendern. Deaktiviere „Auf Produktseite anzeigen“ unter WooCommerce → Bundle, um nur den Shortcode zu verwenden.

= Does Bundle use JavaScript on the storefront? =

Nein. Die kostenlose Bundle-Box wird vom Server mit einem kleinen Stylesheet und ohne Storefront-JavaScript gerendert.


= Does this plugin work on WordPress Multisite? =

Ja. Dieses Plugin ist mit WordPress Multisite kompatibel. Aktiviere es im Netzwerk oder auf einzelnen Websites. Jede Site behält ihre eigenen Einstellungen und Daten.

== Screenshots ==

1. Im Schaufenster.
2. Einstellungen im WordPress-Admin.
3. Auf einem mobilen Gerät.
== External Services ==

Das Bundle stellt keine Verbindung zu externen Diensten her. Es führt keine Remote-API-Aufrufe durch und sendet keine Daten von deiner Site. Das einzige Stylesheet und Admin-Skript werden von deiner eigenen WordPress-Installation („assets/css/bundle.css“, „assets/css/admin.css“ und „assets/js/admin.js“) bereitgestellt, ohne Schriftarten, CDNs oder Analysen von Drittanbietern. Alle Daten bleiben in deiner Datenbank: globale Optionen in „bundle_settings“ und „bundle_db_version“ und das Bundle jedes Produkts im Post-Meta „_bundle_definition“. Das Plugin sendet keine E-Mail.

== Changelog ==

= 1.0.1 =
* Erste stabile Version.

= 0.2.1 =
* Für einen eindeutigeren Plugin-Namen in Plogins Bundle für WooCommerce umbenannt.

= 0.2.0 =
* Einstellungsseite als Karten angelegt, mit einem „?“ Hilfeblase, die jede Option erklärt.
* Storefront-Box neu gestaltet: flüssige Größenanpassung, Unterstützung des Dunkelmodus, reservierter Bildplatz, damit das Layout nicht verschoben wird, und eine Sparzeile, die den eingesparten Betrag anzeigt.
* Barrierefreiheit: über die Tastatur bedienbare Hilfeblasen, sichtbare Fokusstile und Unterstützung für reduzierte Bewegungen.
* Gelöschte oder fehlende gebündelte Produkte werden übersprungen und die Box wird ausgeblendet, wenn nichts mehr zum Bündeln übrig ist.
* Neu: „[bundle]“-Shortcode zum Rendern der Bundle-Box an einer beliebigen Stelle, mit einem optionalen „id“-Attribut, um auf ein bestimmtes Produkt abzuzielen.
* Neu: Option „Ersparnisse anzeigen“, die die Gesamtsumme des Pakets und den auf der Box gesparten Betrag anzeigt.
* Neu: Der vom Administrator gespeicherte Boxtitel, die Schaltflächenbeschriftung und die Rabattzeilenbeschriftung werden jetzt von der Bundle-Box verwendet (zuvor wurden sie von der Box ignoriert).
* Neu: Bei der sauberen Deinstallation werden die Optionen des Plugins und alle gespeicherten Bundle-Definitionen entfernt.
* I18n: Die Übersetzungsvorlage wurde mit den neuen Zeichenfolgen neu generiert.

= 0.1.0 =
* Erstveröffentlichung.
