<?php

declare(strict_types=1);

namespace Bundle;

defined('ABSPATH') || exit;

/**
 * Idempotent schema/version migrations, run on every boot. Compares a stored
 * option against VERSION and applies forward steps as needed.
 */
final class Migrator
{
    private const OPTION   = 'bundle_db_version';
    private const SETTINGS = 'bundle_settings';

    /**
     * The English strings that shipped as packaged defaults up to 1.0.8 and
     * were written into the option the first time a merchant saved the
     * settings form.
     *
     * @var array<string, string>
     */
    private const LEGACY_TEXTS = [
        'box_title'       => 'Frequently bought together',
        'add_label'       => 'Add bundle to cart',
        'fee_label'       => 'Bundle discount',
        'add_failed_text' => 'Some bundled products could not be added to the cart.',
    ];

    public function maybeMigrate(): void
    {
        $current = (string) get_option(self::OPTION, '0');

        if (version_compare($current, VERSION, '>=')) {
            return;
        }

        $this->clearUntranslatableTexts();

        update_option(self::OPTION, VERSION, false);
    }

    /**
     * Clear a stored label that is byte for byte the English default.
     *
     * Those values could never be translated: they came from a config array,
     * not from a gettext call, so a shop running in Polish showed English
     * however complete the translation was. Empty means "use the translated
     * default", which is what the settings screen already promised.
     *
     * Only an exact match is cleared, so a merchant's own wording, including a
     * hand translation of the English one, survives untouched.
     */
    private function clearUntranslatableTexts(): void
    {
        $stored = get_option(self::SETTINGS, null);

        if (! is_array($stored)) {
            return;
        }

        $changed = false;

        foreach (self::LEGACY_TEXTS as $key => $legacy) {
            if (isset($stored[$key]) && (string) $stored[$key] === $legacy) {
                $stored[$key] = '';
                $changed      = true;
            }
        }

        if ($changed) {
            // null keeps the option's existing autoload flag. Passing false here
            // would quietly move the settings out of the autoloaded set on every
            // shop that took this update, which is not a change a text sweep gets
            // to make.
            update_option(self::SETTINGS, $stored, null);
        }
    }
}
