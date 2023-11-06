<?php declare(strict_types=1);
/**
 * basteyy/php-i18n
 *
 * Simplest i18n function for php ever?
 * Contributions are appreciated.
 *
 * @author Sebastian Eiweleit <sebastian@eiweleit.de>
 * @website https://github.com/basteyy/php-i18n
 * @license CC0 1.0 Universal
 */

if (!function_exists('__')) {
    function __(string $string, ...$args) : string {
        return \basteyy\I18n\I18n::getTranslation($string, ...$args);
    }
}
