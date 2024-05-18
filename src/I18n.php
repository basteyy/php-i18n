<?php declare(strict_types=1);
/**
 * basteyy/php-i18n
 *
 * Simplest i18n function for php ever?
 * Contributions are appreciated.
 *
 * @author basteyy <sebastian@xzit.email>
 * @website https://github.com/basteyy/php-i18n
 * @license CC0 1.0 Universal
 */

namespace basteyy\I18n;

class i18n
{
    /** @var array where the language is stored */
    private static array $translation_folder;

    /** @var string Translation File Name */
    private static string $translation_language;

    /** @var array Storage for the translations */
    private static array $translations = [];

    /** @var int $apcu_cache_ttl The ttl of the apcu cache in seconds */
    private static int $apcu_cache_ttl = 360;

    /** @var bool $use_apcu If true, apcu will be used for caching */
    private static bool $use_apcu = false;

    /**
     * Try to translate $string
     * @param string $string
     * @return string
     */
    public static function getTranslation(
        string $string, ...$args) : string
    {
        // Count just once
        $arg = count($args) !== 0;

        if(
            !isset(self::$translation_folder) ||
            !isset(self::$translation_language) ||
            count(self::$translation_folder) === 0
        ) {
            if ($arg) {
                return vsprintf($string, $args);
            }

            return $string;
        }

        $cur_lang = self::$translation_language;

        if(0 === count(self::$translations) || !isset(self::$translations[$cur_lang])) {

            $is_apc_installed = self::$use_apcu && function_exists('apcu_enabled') && apcu_enabled();

            if (!isset(self::$translations[$cur_lang])) {
                self::$translations[$cur_lang] = [];
            }

            foreach(self::$translation_folder as $folder) {

                $cache_name = '_translation_' . self::$translation_language;

                if($is_apc_installed && apcu_exists($cache_name) && is_array(apcu_fetch($cache_name))) {
                    self::$translations[$cur_lang] += apcu_fetch($cache_name);
                } elseif(file_exists($folder . DIRECTORY_SEPARATOR . self::$translation_language . '.ini')) {

                    $parsed_ini = parse_ini_file(
                        $folder . DIRECTORY_SEPARATOR . self::$translation_language . '.ini',
                        false,
                        INI_SCANNER_RAW
                    );

                    /** Only on valid array */
                    if(is_array($parsed_ini)) {

                        if($is_apc_installed) {
                            apcu_store($cache_name, $parsed_ini, self::$apcu_cache_ttl);
                        }

                        self::$translations[$cur_lang] += $parsed_ini;
                    }
                }
            }
        }

        if ($arg) {
            return vsprintf(self::$translations[$cur_lang][hash('xxh3', $string)] ?? $string, $args);
        }

        return self::$translations[$cur_lang][hash('xxh3', $string)] ?? $string;
    }

    /**
     * Define the current language
     * @param string $language
     * @return void
     */
    public static function setTranslationLanguage(string $language) : void {
        self::$translation_language = $language;
    }

    /**
     * Define, where the language files are stored
     * @param string $folder
     * @return void
     */
    public static function addTranslationFolder(string $folder) : void {
        self::$translation_folder[] = str_ends_with($folder, '/') ? substr($folder, 0, -1) : $folder;
    }

    /**
     * Define, if apcu should be used for caching
     * @param bool $use_apcu
     * @return void
     */
    public function useApcuCache(bool $use_apcu) : void {
        $this->use_apcu = $use_apcu;
    }

    /**
     * Define the ttl of the apcu cache
     * @param int $ttl
     * @return void
     */
    public function setApcuCacheTtl(int $ttl) : void {
        self::$apcu_cache_ttl = $ttl;
    }
}