<?php
/**
 * PRO upsell content, generated from the plogins.com registry by
 * scripts/gen-pro-upsell.mjs. The admin upsell renders this; curate the
 * feature list to fit this plugin's settings screen (do not invent features).
 *
 * @package plogins-bundle-pro
 */

defined('ABSPATH') || exit;

return [
    'name'       => 'Bundle Pro',
    'url'        => 'https://plogins.com/plogins-bundle-pro/pricing/',
    'sellable'   => true,
    'price_from' => 49,
    'currency'   => 'EUR',
    'price_pln'  => 215,
    'lead'       => [
        'en' => 'The features below ship in the current PRO release.',
        'pl' => 'Poniższe funkcje są dostępne w bieżącym wydaniu PRO.',
    ],
    'features'   => [
        [
            'en' => ['title' => 'Product-search picker', 'desc' => 'Build bundles with WooCommerce\'s native product search, pick from the catalogue instead of typing IDs.'],
            'pl' => ['title' => 'Wyszukiwarka produktów', 'desc' => 'Buduj pakiet przez natywną wyszukiwarkę WooCommerce, wybieraj produkty z katalogu zamiast wpisywać identyfikatory.'],
        ],
        [
            'en' => ['title' => 'Fixed bundle price', 'desc' => 'Set one total price for the bundle, the cart adjusts automatically regardless of the sum of line items.'],
            'pl' => ['title' => 'Stała cena pakietu', 'desc' => 'Ustaw jedną cenę końcową pakietu, koszyk dostosowuje się automatycznie, niezależnie od sumy pozycji.'],
        ],
        [
            'en' => ['title' => 'Order-history suggestions', 'desc' => 'Suggest products frequently bought together with current bundle items from the last 90 days of orders.'],
            'pl' => ['title' => 'Podpowiedzi z historii zamówień', 'desc' => 'Sugeruj produkty często kupowane razem z pozycjami pakietu na podstawie ostatnich 90 dni zamówień.'],
        ],
        [
            'en' => ['title' => 'Tiered quantity pricing', 'desc' => 'Increase the discount as customers buy more complete bundle sets, rules in the product editor, tier table on the product page.'],
            'pl' => ['title' => 'Ceny stopniowane', 'desc' => 'Rabaty rosną wraz z liczbą kompletnych zestawów pakietu, reguły w panelu produktu, tabela na karcie produktu.'],
        ],
        [
            'en' => ['title' => 'Mix-and-match', 'desc' => 'Let customers pick a set number of products from a curated pool, the main product is always included.'],
            'pl' => ['title' => 'Mix-and-match', 'desc' => 'Klient wybiera określoną liczbę produktów z puli, główny produkt zawsze w zestawie, reszta do wyboru na karcie produktu.'],
        ],
        [
            'en' => ['title' => 'Bundle analytics', 'desc' => 'Track views, add-to-cart, conversions and attributed revenue per bundle, WooCommerce → Bundle Analytics.'],
            'pl' => ['title' => 'Analityka pakietów', 'desc' => 'Wyświetlenia, dodania do koszyka, konwersje i przychód per produkt-pakiet, panel WooCommerce → Bundle Analytics.'],
        ],
        [
            'en' => ['title' => 'Scheduled deals', 'desc' => 'Optional deal start/end dates per bundle, outside the window the box and discounts are off.'],
            'pl' => ['title' => 'Zaplanowane promocje', 'desc' => 'Opcjonalne daty startu i końca oferty pakietowej, poza oknem pudełko i rabaty są wyłączone.'],
        ],
    ],
];
