<?php

declare(strict_types=1);

namespace Bundle\Service;

defined('ABSPATH') || exit;

/**
 * The customer-facing strings a merchant may override, in the language of the
 * site.
 *
 * They used to be English sentences in config/defaults.php. A string in a
 * config array is never wrapped in a gettext call, so it never reaches the
 * .pot and no translator can translate it. Because the key was always present
 * in the merged settings, the `__()` fallbacks that sat next to those keys in
 * BundleService could never fire, and the moment a merchant pressed Save the
 * English wording was frozen into `bundle_settings`, out of reach of any
 * language pack.
 *
 * The packaged default is now empty, meaning "use the string below". A merchant
 * who types their own still wins, and what they typed is stored as typed.
 */
final class Texts
{
    /**
     * Setting key => the translated default.
     *
     * @return array<string, string>
     */
    public static function defaults(): array
    {
        return [
            'box_title'       => __('Frequently bought together', 'plogins-bundle'),
            'add_label'       => __('Add bundle to cart', 'plogins-bundle'),
            'fee_label'       => __('Bundle discount', 'plogins-bundle'),
            'add_failed_text' => __('Some bundled products could not be added to the cart.', 'plogins-bundle'),
        ];
    }

    /**
     * Fill every empty text key with its translated default.
     *
     * Applied on the way OUT, where the string is about to be shown, and never
     * on the way in: writing the resolved text back to the option would freeze
     * one language into the database, which is the bug this class exists to fix.
     *
     * @param array<string, mixed> $settings
     * @return array<string, mixed>
     */
    public static function apply(array $settings): array
    {
        foreach (self::defaults() as $key => $text) {
            if (trim((string) ($settings[$key] ?? '')) === '') {
                $settings[$key] = $text;
            }
        }

        return $settings;
    }
}
