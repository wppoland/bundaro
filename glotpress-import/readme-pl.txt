=== Plogins Bundle - Product Bundles for WooCommerce ===
Contributors: motylanogha
Tags: woocommerce, product bundles, frequently bought together, bundle discount, upsell
Requires at least: 6.5
Tested up to: 7.0
Requires PHP: 8.1
Stable tag: 1.0.2
Wymaga wtyczek: woocommerce
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Sprzedawaj pakiety produktów i oferty „często kupowane razem” z opcjonalnym rabatem pakietowym WooCommerce.

== Description ==

Bundle dodaje do stron produktów WooCommerce pole pakietu „często kupowane razem”. Połącz dowolną liczbę produktów z produktem, ustaw opcjonalny rabat pakietowy i pozwól klientom dodać cały zestaw do koszyka jednym kliknięciem.

* Pole pakietu pod podsumowaniem produktu z listą produktów w pakiecie.
* „Dodaj pakiet do koszyka” dodaje jednocześnie produkt główny i wszystkie powiązane pozycje.
* Opcjonalny rabat pakietowy — jako pojedyncza opłata w koszyku albo korekta ceny dla każdej pozycji.
* Opcjonalny wiersz oszczędności pokazujący sumę pakietu i zaoszczędzoną kwotę.
* Shortcode `[bundle]` do umieszczenia pola pakietu w dowolnym miejscu; użyj `[bundle id="123"]`, aby wskazać konkretny produkt.
* Edytowalny tytuł pola, etykieta przycisku i etykieta wiersza rabatu — wszystko przetłumaczalne.
* Definicje pakietów są przechowywane jako meta produktu, bez niestandardowych tabel w bazie danych.
* Czysta dezinstalacja: po usunięciu usuwa swoje opcje i definicje pakietów.
* Jeden mały arkusz stylów, bez JavaScriptu w sklepie i bez jQuery. Obrazy rezerwują miejsce, więc pole nie powoduje przeskoku układu podczas ładowania i dostosowuje się do preferencji trybu ciemnego odwiedzającego.
* Dymek pomocy „?” przy każdym ustawieniu, dostępny z klawiatury; pole ukrywa się, gdy dla produktu nie ma już nic do pokazania w pakiecie.

Skonfiguruj zachowanie globalne w WooCommerce → Bundle. Połącz produkty i ustaw rabat w zakładce „Bundle” w edytorze produktów. Wyłącz „Pokaż na stronie produktu”, aby wyświetlać pole tylko tam, gdzie umieścisz shortcode `[bundle]`.

Wtyczka jest rozwijana otwarcie (open source). Kod, zgłoszenia błędów i poprawki znajdziesz na https://github.com/wppoland/plogins-bundle.

== Installation ==

1. Wgraj wtyczkę do `/wp-content/plugins/bundle` lub zainstaluj przez Wtyczki → Dodaj nową.
2. Włącz ją. WooCommerce musi być aktywne.
3. Edytuj produkt, otwórz zakładkę „Bundle”, wprowadź identyfikatory produktów w pakiecie i opcjonalny rabat, a następnie zapisz.
4. Dostosuj opcje globalne w WooCommerce → Bundle.

== Frequently Asked Questions ==

= Documentation and links =

* <strong>Dokumentacja</strong> - https://plogins.com/pl/plogins-bundle/docs/
* <strong>Strona wtyczki</strong> - https://plogins.com/pl/plogins-bundle/
* <strong>Kod źródłowy</strong> - https://github.com/wppoland/plogins-bundle
* <strong>Zgłoszenia błędów i propozycje funkcji</strong> - https://github.com/wppoland/plogins-bundle/issues


= Does it require WooCommerce? =

Tak. WooCommerce musi być zainstalowane i aktywne.

= How is the discount applied? =

Wybierz między pojedynczą ujemną opłatą w koszyku (jedna linia w koszyku) a korektą ceny dla każdego produktu w pakiecie. Ustaw to w WooCommerce → Bundle.

= Can a bundle include a discount? =

Tak. Ustaw opcjonalny rabat procentowy dla pakietu produktów. Bundle może pokazać sumę pakietu i wiersz oszczędności przed dodaniem do koszyka.

= Does the bundle add all products to the cart? =

Tak. Przycisk „Dodaj pakiet do koszyka” dodaje produkt główny i powiązane produkty razem.

= Does it create custom database tables? =

Nie. Definicje pakietów są przechowywane jako meta produktu.

= Can I place the bundle box somewhere other than under the product summary? =

Tak. Użyj shortcode’u `[bundle]` wszędzie tam, gdzie znany jest bieżący produkt, lub `[bundle id="123"]`, aby wyrenderować pakiet konkretnego produktu. Wyłącz „Pokaż na stronie produktu” w WooCommerce → Bundle, aby używać wyłącznie shortcode’u.

= Does Bundle use JavaScript on the storefront? =

Nie. Darmowe pole pakietu jest renderowane po stronie serwera z jednym małym arkuszem stylów i bez JavaScriptu w sklepie.


= Does this plugin work on WordPress Multisite? =

Tak. Ta wtyczka jest zgodna z WordPress Multisite. Włącz ją dla całej sieci lub w pojedynczych witrynach; każda witryna zachowuje własne ustawienia i dane.

== Screenshots ==

1. W sklepie.
2. Ustawienia w panelu WordPress.
3. Na urządzeniu mobilnym.
== External Services ==

Bundle nie łączy się z żadną usługą zewnętrzną. Nie wykonuje zdalnych wywołań API i nie wysyła żadnych danych poza Twoją witrynę. Jego jedyny arkusz stylów i skrypt panelu są serwowane z Twojej instalacji WordPress (`assets/css/bundle.css`, `assets/css/admin.css` i `assets/js/admin.js`), bez czcionek, CDN ani analityki innych firm. Wszystkie dane pozostają w Twojej bazie danych: opcje globalne w `bundle_settings` i `bundle_db_version` oraz pakiet każdego produktu w meta wpisu `_bundle_definition`. Wtyczka nie wysyła e-maili.

== Translations ==

Plogins Bundle zawiera polskie, niemieckie i hiszpańskie tłumaczenia interfejsu wtyczki. Domena tekstowa to `plogins-bundle`, więc pakiety językowe z WordPress.org mogą również nadpisać lub rozszerzyć te dołączone tłumaczenia.

== Changelog ==

= 1.0.2 =
* Dodano dołączone polskie, niemieckie i hiszpańskie tłumaczenia interfejsu wtyczki.

= 1.0.1 =
* Pierwsza stabilna wersja.

= 0.2.1 =
* Zmieniono nazwę na Plogins Bundle dla WooCommerce, aby nazwa wtyczki była bardziej charakterystyczna.

= 0.2.0 =
* Strona ustawień ułożona w formie kart z dymkiem pomocy „?” wyjaśniającym każdą opcję.
* Przeprojektowane pole w sklepie: płynne dopasowanie rozmiaru, obsługa trybu ciemnego, zarezerwowane miejsce na obraz, aby nie powodować przeskoku układu, oraz wiersz oszczędności pokazujący zaoszczędzoną kwotę.
* Dostępność: dymki pomocy obsługiwane z klawiatury, widoczne style fokusu i obsługa ograniczonego ruchu.
* Usunięte lub brakujące produkty w pakiecie są pomijane, a pole ukrywa się, gdy nie ma już nic do spakowania.
* Nowość: shortcode `[bundle]` do renderowania pola pakietu w dowolnym miejscu, z opcjonalnym atrybutem `id` wskazującym konkretny produkt.
* Nowość: opcja „Pokaż oszczędności” wyświetlająca sumę pakietu i zaoszczędzoną kwotę na polu.
* Nowość: tytuł pola, etykieta przycisku i etykieta wiersza rabatu zapisane w panelu są teraz używane przez pole pakietu (wcześniej były ignorowane).
* Nowość: czysta dezinstalacja usuwa opcje wtyczki i wszystkie zapisane definicje pakietów.
* I18n: zregenerowano szablon tłumaczenia z nowymi ciągami.

= 0.1.0 =
* Pierwsze wydanie.
