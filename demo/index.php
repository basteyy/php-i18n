<?php
/**
 * @author Sebastian Eiweleit <sebastian@eiweleit.de>
 * @website https://github.com/basteyy
 * @website https://eiweleit.de
 */

declare(strict_types=1);

// Include autoloader
use basteyy\I18n\I18n;

include dirname(__DIR__) . "/vendor/autoload.php";

echo __('Hello World. Today is the %s', date('d'));

// Add lang folder (in the example is the same folder as the index.php)
I18n::addTranslationFolder(__DIR__);

// Change language
I18n::setTranslationLanguage('de_DE');

echo '<hr />';

// Output translated string
echo __('Hello World. Today is the %s', date('d'));

// Change language
I18n::setTranslationLanguage('fr_FR');

echo '<hr />';

// Output translated string
echo __('Hello World. Today is the %s', date('d'));

/**
 * For this example, used command in the shell:
 *
 * $ php src/bin/I18nBaker demo demo/de_DE.ini
 *
 * Found in /var/www/html/demo/index.php
 * ==> Hello World. Today is the %s
 *
 *
 * 1 Files found with __() Function. 1 Translations found and put into target file demo/de_DE.ini
 */