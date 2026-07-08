=== Plogins Bundle - Product Bundles for WooCommerce ===
Contributors: motylanogha
Tags: woocommerce, product bundles, frequently bought together, bundle discount, upsell
Requires at least: 6.5
Tested up to: 7.0
Requires PHP: 8.1
Stable tag: 1.0.1
Wymaga wtyczek: woocommerce
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Sprzedawaj pakiety produktów i często kupowane razem oferty z opcjonalnym rabatem na pakiet WooCommerce.

== Description ==

Pakiet dodaje pole pakietu produktów „często kupowane razem” do stron produktów WooCommerce. Połącz dowolną liczbę produktów z produktem, ustaw opcjonalny rabat na pakiet i pozwól klientom dodać cały zestaw produktów do koszyka jednym kliknięciem.

* Pole pakietu pod podsumowaniem produktu zawierające listę produktów w pakiecie.
* Opcja „Dodaj pakiet do koszyka” dodaje jednocześnie główny produkt i wszystkie powiązane pozycje.
* Opcjonalny rabat na pakiet, stosowany albo jako opłata za pojedynczy koszyk, albo jako korekta ceny za sztukę.
* Opcjonalny wiersz oszczędności, który pokazuje sumę pakietu i zaoszczędzoną kwotę.
* Krótki kod `[bundle]` umożliwiający umieszczenie pakietu w dowolnym miejscu. Użyj `[bundle id="123"]`, aby kierować reklamy na konkretny produkt.
* Edytowalny tytuł pudełka, etykieta przycisku i etykieta linii rabatowej, wszystko można przetłumaczyć.
* Definicje pakietów są przechowywane jako meta produktu, bez niestandardowych tabel bazy danych.
* Czysta dezinstalacja: po usunięciu usuwa opcje i definicje pakietów.
* Jeden mały arkusz stylów, brak JavaScript w witrynie sklepu i brak jQuery. Obrazy rezerwują swoje miejsce, dzięki czemu pudełko nie zmienia układu podczas ładowania i dostosowuje się do preferencji trybu ciemnego odwiedzającego.
* A "?" dymek pomocy przy każdym ustawieniu, dostępny za pomocą klawiatury, a pudełko chowa się, gdy dla produktu nie ma już pakietu do pokazania.

Skonfiguruj zachowanie globalne w WooCommerce → Pakiet. Połącz produkty i ustaw rabat na produkt w zakładce „Pakiet” w edytorze produktów. Wyłącz opcję „Pokaż na stronie produktu”, aby wyświetlić okno tylko po upuszczeniu krótkiego kodu `[bundle]`.

Wtyczka jest rozwijana w sposób otwarty. Kod, raporty o błędach i poprawki są dostępne na https://github.com/wppoland/plogins-bundle.

== Installation ==

1. Prześlij wtyczkę do `/wp-content/plugins/bundle` lub zainstaluj poprzez Wtyczki → Dodaj nową.
2. Aktywuj. WooCommerce musi być aktywny.
3. Edytuj produkt, otwórz zakładkę „Pakiet”, wprowadź identyfikatory produktów objętych pakietem oraz opcjonalny rabat, a następnie zapisz.
4. Dostosuj opcje globalne w WooCommerce → Pakiet.

== Frequently Asked Questions ==

= Documentation and links =

* <strong>Dokumentacja</strong> - https://plogins.com/pl/plogins-bundle/docs/
* <strong>Strona wtyczki</strong> - https://plogins.com/pl/plogins-bundle/
* <strong>Kod źródłowy</strong> - https://github.com/wppoland/plogins-bundle
* <strong>Raporty o błędach i prośby o nowe funkcje</strong> - https://github.com/wppoland/plogins-bundle/issues


= Does it require WooCommerce? =

Tak. WooCommerce musi być zainstalowany i aktywny.

= How is the discount applied? =

Wybierz pomiędzy pojedynczą ujemną opłatą za koszyk (jedna linia w koszyku) lub korektą ceny za sztukę w przypadku każdego produktu w pakiecie. Ustaw to w WooCommerce → Pakiet.

= Can a bundle include a discount? =

Tak. Ustaw opcjonalny rabat procentowy na pakiet produktów. Pakiet może wyświetlać sumę pakietu i linię oszczędności przed dodaniem do koszyka.

= Does the bundle add all products to the cart? =

Tak. Przycisk „Dodaj pakiet do koszyka” powoduje dodanie produktu głównego i produktów powiązanych.

= Does it create custom database tables? =

Nie. Definicje pakietów są przechowywane jako meta produktu.

= Can I place the bundle box somewhere other than under the product summary? =

Tak. Użyj krótkiego kodu `[bundle]` w dowolnym miejscu, w którym znany jest bieżący produkt, lub `[bundle id="123"]`, aby wyrenderować pakiet konkretnego produktu. Wyłącz „Pokaż na stronie produktu” w WooCommerce → Pakiet, aby używać tylko krótkiego kodu.

= Does Bundle use JavaScript on the storefront? =

Nie. Pakiet bezpłatnego pakietu jest renderowany przez serwer z jednym małym arkuszem stylów i bez kodu JavaScript dostępnego w sklepie.


= Does this plugin work on WordPress Multisite? =

Tak. Ta wtyczka jest kompatybilna z WordPress Multisite. Aktywuj go w sieci lub aktywuj na poszczególnych stronach; każda witryna przechowuje własne ustawienia i dane.

== Screenshots ==

1. Na wystawie sklepowej.
2. Ustawienia w panelu administracyjnym WordPress.
3. Na urządzeniu mobilnym.
== External Services ==

Pakiet nie łączy się z żadnymi usługami zewnętrznymi. Nie wykonuje żadnych zdalnych wywołań API i nie wysyła żadnych danych poza Twoją witrynę. Jego jedyny arkusz stylów i skrypt administracyjny są obsługiwane z Twojej własnej instalacji WordPressa (`assets/css/bundle.css`, `assets/css/admin.css` i `assets/js/admin.js`), bez czcionek innych firm, CDN i analiz. Wszystkie dane pozostają w Twojej bazie danych: opcje globalne w `bundle_settings` i `bundle_db_version` oraz pakiet każdego produktu w meta postu `_bundle_definition`. Wtyczka nie wysyła wiadomości e-mail.

== Changelog ==

= 1.0.1 =
* Pierwsza stabilna wersja.

= 0.2.1 =
* Zmieniono nazwę na Plogins Bundle dla WooCommerce, aby uzyskać bardziej charakterystyczną nazwę wtyczki.

= 0.2.0 =
* Strona ustawień ułożona w formie kart z „?” dymek pomocy wyjaśniający każdą opcję.
* Zmieniona stylistyka pudełka sklepowego: płynne dopasowywanie rozmiaru, obsługa trybu ciemnego, zarezerwowane miejsce na obraz, aby nie zmieniało układu, oraz wiersz oszczędności określający zaoszczędzoną kwotę.
* Dostępność: dymki pomocy obsługiwane za pomocą klawiatury, widoczne style fokusu i obsługa ograniczonego ruchu.
* Usunięte lub brakujące produkty w pakiecie są pomijane, a pudełko chowa się, gdy nie ma już nic do spakowania.
* Nowość: krótki kod `[bundle]` umożliwiający renderowanie pakietu w dowolnym miejscu, z opcjonalnym atrybutem `id` umożliwiającym kierowanie na konkretny produkt.
* Nowość: opcja „Pokaż oszczędności”, która wyświetla sumę pakietu i kwotę zaoszczędzoną na pudełku.
* Nowość: tytuł pudełka zapisany przez administratora, etykieta przycisku i etykieta linii rabatowej są teraz używane przez pudełko pakietu (poprzednio pudełko je ignorowało).
* Nowość: czysta dezinstalacja usuwa opcje wtyczki i wszystkie zapisane definicje pakietów.
* I18n: zregenerowano szablon tłumaczenia z nowymi ciągami znaków.

= 0.1.0 =
* Pierwsze wydanie.
