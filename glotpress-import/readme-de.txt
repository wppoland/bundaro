=== Plogins Bundle - Product Bundles for WooCommerce ===
Contributors: motylanogha
Tags: woocommerce, product bundles, frequently bought together, bundle discount, upsell
Requires at least: 6.5
Tested up to: 7.0
Requires PHP: 8.1
Stable tag: 1.0.2
Erfordert Plugins: woocommerce
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Verkaufe Produktpakete und „häufig zusammen gekauft“-Angebote mit einem optionalen WooCommerce-Paketrabatt.

== Description ==

Bundle fügt deinen WooCommerce-Produktseiten eine „häufig zusammen gekauft“-Paketbox hinzu. Verknüpfe eine beliebige Anzahl von Produkten mit einem Produkt, lege einen optionalen Paketrabatt fest und ermögliche der Kundschaft, das gesamte Produktset mit einem Klick in den Warenkorb zu legen.

* Eine Paketbox unter der Produktzusammenfassung mit einer Liste der gebündelten Produkte.
* „Paket in den Warenkorb“ fügt das Hauptprodukt und alle verknüpften Artikel auf einmal hinzu.
* Optionaler Paketrabatt — entweder als einzelne Warenkorbgebühr oder als Preisanpassung pro Artikel.
* Eine optionale Ersparniszeile, die die Paketsumme und den gesparten Betrag anzeigt.
* Shortcode `[bundle]`, um die Paketbox überall zu platzieren; nutze `[bundle id="123"]`, um ein bestimmtes Produkt anzusprechen.
* Bearbeitbarer Boxtitel, Button-Beschriftung und Rabattzeilen-Beschriftung — alles übersetzbar.
* Paketdefinitionen werden als Produktmeta gespeichert, ohne eigene Datenbanktabellen.
* Saubere Deinstallation: entfernt beim Löschen seine Optionen und Paketdefinitionen.
* Ein kleines Stylesheet, kein JavaScript im Shop und kein jQuery. Bilder reservieren ihren Platz, sodass die Box beim Laden keine Layout-Verschiebung verursacht und der Dark-Mode-Präferenz des Besuchers folgt.
* Ein „?“-Hilfe-Bubble bei jeder Einstellung, per Tastatur erreichbar; die Box blendet sich aus, wenn für ein Produkt nichts mehr zu bündeln ist.

Konfiguriere das globale Verhalten unter WooCommerce → Bundle. Verknüpfe Produkte und lege den Rabatt pro Produkt im Tab „Bundle“ des Produkteditors fest. Deaktiviere „Auf Produktseite anzeigen“, um die Box nur dort zu rendern, wo du den Shortcode `[bundle]` einfügst.

Das Plugin wird quelloffen entwickelt. Code, Fehlerberichte und Patches findest du unter https://github.com/wppoland/plogins-bundle.

== Installation ==

1. Lade das Plugin nach `/wp-content/plugins/bundle` hoch oder installiere es über Plugins → Installieren.
2. Aktiviere es. WooCommerce muss aktiv sein.
3. Bearbeite ein Produkt, öffne den Tab „Bundle“, gib die Produkt-IDs des Pakets und einen optionalen Rabatt ein und speichere.
4. Passe die globalen Optionen unter WooCommerce → Bundle an.

== Frequently Asked Questions ==

= Documentation and links =

* <strong>Dokumentation</strong> - https://plogins.com/de/plogins-bundle/docs/
* <strong>Plugin-Seite</strong> - https://plogins.com/de/plogins-bundle/
* <strong>Quellcode</strong> - https://github.com/wppoland/plogins-bundle
* <strong>Fehlerberichte und Funktionswünsche</strong> - https://github.com/wppoland/plogins-bundle/issues


= Does it require WooCommerce? =

Ja. WooCommerce muss installiert und aktiv sein.

= How is the discount applied? =

Wähle zwischen einer einzelnen negativen Warenkorbgebühr (eine Zeile im Warenkorb) oder einer Preisanpassung pro Artikel für jedes gebündelte Produkt. Stelle das unter WooCommerce → Bundle ein.

= Can a bundle include a discount? =

Ja. Lege einen optionalen prozentualen Rabatt pro Produktpaket fest. Bundle kann die Paketsumme und die Ersparniszeile vor dem Hinzufügen zum Warenkorb anzeigen.

= Does the bundle add all products to the cart? =

Ja. Der Button „Paket in den Warenkorb“ fügt das Hauptprodukt und die verknüpften Produkte zusammen hinzu.

= Does it create custom database tables? =

Nein. Paketdefinitionen werden als Produktmeta gespeichert.

= Can I place the bundle box somewhere other than under the product summary? =

Ja. Nutze den Shortcode `[bundle]` überall dort, wo das aktuelle Produkt bekannt ist, oder `[bundle id="123"]`, um das Paket eines bestimmten Produkts zu rendern. Deaktiviere „Auf Produktseite anzeigen“ unter WooCommerce → Bundle, um nur den Shortcode zu verwenden.

= Does Bundle use JavaScript on the storefront? =

Nein. Die kostenlose Paketbox wird serverseitig mit einem kleinen Stylesheet und ohne Shop-JavaScript gerendert.


= Does this plugin work on WordPress Multisite? =

Ja. Dieses Plugin ist mit WordPress Multisite kompatibel. Aktiviere es netzwerkweit oder auf einzelnen Websites; jede Website behält ihre eigenen Einstellungen und Daten.

== Screenshots ==

1. Im Shop.
2. Einstellungen im WordPress-Adminbereich.
3. Auf einem mobilen Gerät.
== External Services ==

Bundle stellt keine Verbindung zu externen Diensten her. Es führt keine Remote-API-Aufrufe durch und sendet keine Daten von deiner Website. Das einzige Stylesheet und Admin-Skript werden von deiner eigenen WordPress-Installation ausgeliefert (`assets/css/bundle.css`, `assets/css/admin.css` und `assets/js/admin.js`), ohne Schriftarten, CDNs oder Analysen von Drittanbietern. Alle Daten bleiben in deiner Datenbank: globale Optionen in `bundle_settings` und `bundle_db_version` sowie das Paket jedes Produkts im Post-Meta `_bundle_definition`. Das Plugin sendet keine E-Mails.

== Translations ==

Plogins Bundle enthält polnische, deutsche und spanische Übersetzungen für die Plugin-Oberfläche. Die Textdomain ist `plogins-bundle`, sodass Sprachpakete von WordPress.org diese mitgelieferten Übersetzungen ebenfalls überschreiben oder erweitern können.

== Changelog ==

= 1.0.2 =
* Mitgelieferte polnische, deutsche und spanische Übersetzungen für die Plugin-Oberfläche hinzugefügt.

= 1.0.1 =
* Erste stabile Version.

= 0.2.1 =
* In Plogins Bundle für WooCommerce umbenannt, für einen eindeutigeren Plugin-Namen.

= 0.2.0 =
* Einstellungsseite als Karten angelegt, mit einem „?“-Hilfe-Bubble, der jede Option erklärt.
* Shop-Box neu gestaltet: fluide Größe, Dark-Mode-Unterstützung, reservierter Bildplatz ohne Layout-Verschiebung und eine Ersparniszeile mit dem gesparten Betrag.
* Barrierefreiheit: per Tastatur bedienbare Hilfe-Bubbles, sichtbare Fokus-Stile und Unterstützung für reduzierte Bewegung.
* Gelöschte oder fehlende gebündelte Produkte werden übersprungen, und die Box blendet sich aus, wenn nichts mehr zu bündeln ist.
* Neu: Shortcode `[bundle]` zum Rendern der Paketbox überall, mit optionalem `id`-Attribut für ein bestimmtes Produkt.
* Neu: Option „Ersparnisse anzeigen“, die die Paketsumme und den gesparten Betrag auf der Box anzeigt.
* Neu: Der im Admin gespeicherte Boxtitel, die Button-Beschriftung und die Rabattzeilen-Beschriftung werden jetzt von der Paketbox verwendet (zuvor ignoriert).
* Neu: Saubere Deinstallation entfernt die Plugin-Optionen und alle gespeicherten Paketdefinitionen.
* I18n: Übersetzungsvorlage mit den neuen Zeichenketten neu generiert.

= 0.1.0 =
* Erstveröffentlichung.
