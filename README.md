# basteyy PHP I18n

As an old [CakePHP](https://cakephp.org/) user, I started with the `__()` function. I liked the approach for small projects and created this small package for my own projects.

You use the `__()` somewhere in your code. As long, you don't create translations, the argument (string) will be returned. If you create a translation, the translation will be 
returned.

## Installation

```bash
composer require basteyy/php-i18n
```

## Usage

The languages files are in ini format. For supporting all variants of strings, the key is hashed using the xxh3 algorithm (which is the fastest algorithm for php now).

```ini
; Content of /var/www/lang/de_DE.ini

; Original: Add 
2519a9e8bc4544e5 = "Hinzufügen"

; Original: Remove
d93080c2fe513df2 = "Entfernen"

; Original: Remove %s Items
4937f99272d45d21 = "%s Dinge entfernen"
```

```php
// Content of /var/www/index.php

use basteyy\I18n\I18n;

I18n::addTranslationFolder(__DIR__ . '/lang/');
I18n::addTranslationFolder(__DIR__ . '/another_folder/');
I18n::setTranslationLanguage('de_DE');

echo __('Add');
// Result: Hinzufügen

echo __("Remove");
// Result: Entfernen

echo __('Remove %s Item\'s ', 3212);
// Result: 3212 Dinge entfernen

echo __('A new string');
// Result: A new string

echo __('A new string with placeholder %s', 'inside');
// Result: A new string with placeholder inside
```


#### Translate an app/website

You can use the bash script to generate the translation file. Please be aware, that this is a simple solution. It's easy to break it down with using `=`.

To translate an website, you can use the shell command

```bash
php vendor/basteyy/php-i18n/src/bin/I18nBaker source_folder target_file options --no-comments
```

In case you have your files, which shpuld be translated, stored under `/var/www/src/templates/` and you want to store the translation file at `/var/www/src/translations/dk_DK.ini`, you need to perform this:

```bash
php vendor/basteyy/php-i18n/src/bin/I18nBaker /var/www/src/templates/ /var/www/src/translations/dk_DK.ini
```

#### Options

You can append the following options:

`--no-comments` will output a translation file, without any comments.


```bash
php vendor/basteyy/php-i18n/src/bin/I18nBaker /var/www/src/templates/ /var/www/src/translations/dk_DK.ini --no-comments
```


## Todo

* Write tests
* Add more options to the shell command
* Create a solid shell app (maybe with symfony/console)