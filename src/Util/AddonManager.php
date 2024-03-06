<?php

/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/file-download
 * @copyright Copyright (c) 2024  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

namespace ContaoEstateManager\FileDownload\Util;

use Contao\Config;
use Contao\Environment;
use ContaoEstateManager\EstateManager;

class AddonManager
{
    /**
     * Bundle name
     */
    public static string $bundle = 'EstateManagerFileDownload';

    /**
     * Package
     */
    public static string $package = 'contao-estatemanager/file-download';

    /**
     * Addon config key
     */
    public static string $key = 'addon_file_download_license';

    /**
     * Is initialized
     */
    public static bool $initialized = false;

    /**
     * Is valid
     */
    public static bool $valid = false;

    /**
     * Licenses
     */
    private static array $licenses = [
        'f52fb600f466fe4cba33300c739fb78b',
        '56c76644ee1e7ca69df813ca26818a01',
        'c3e8bc034d709a1bca32497850625cf6',
        'c0dccf4be5fb4049093bc4997ce05d35',
        '6f41bfa2af4849e12713c6e59c862267',
        'd66794e6723d4f40cb29c18385128d68',
        'ceabf043261a1ea71187e53536252b3b',
        'dc451bbe6466bc8cdbea8f204ddd1af9',
        '9be36e356a79695b2368dfce05181260',
        '47f124d7bb6d5bc3aa15dd3317549f3a',
        '0f624ad8d903a23f6e9b90c8690ab2b1',
        'f8bd6fa4d634cf6d44ec818e8a84aafd',
        '7a690aafeb33b6763eec3d2444f51dec',
        '611cc25ec868675938fc6ea4e3a5d77d',
        'c7938f0ab53ead1b84e3abf0b3dcd6c3',
        '6b03a16fcaf9a15155723f35b6e1d82d',
        '02067ea4994194cc9d67e6a1df9be160',
        '34d0f35f8761bd8f42b059658d9b204c',
        '5a6c2812cc7d971d07d50ffc5036f0c1',
        '3a161cb25b33f1d6f323e993b932a980',
        '619cc367a579649668867309834e421f',
        'e897faf063ad5101510d700048b01a07',
        '2302bbeb173a1003220850f975ab6d54',
        'fab72a4cb41598d51cc93f9fd114d853',
        '25d09cf6ce00bee3c17e69b4204c54bf',
        '32da3ca30209a4e001e0c5c04431d8d0',
        'b326bb74b7e7003c5d97891010680f06',
        '8091314066ae2bfbf0f8ba917c306e9e',
        '3fd729ecef2054faa147cf119750db50',
        '2687d7e09309f46ac9020c586d083b7b',
        '6ff590a9e62d3188570359dbb2cb5c00',
        '1df1eff690221707ad0f6bddbafdfce4',
        'eef177fe63db485aa5db60c9d8592397',
        '0e1e1c78d888c35882ca35633e3c3b3d',
        '3dbfdafd7db8a9a992b777b794ed54c0',
        'fa83f5e87b028852dccbc626f1879e83',
        'cae21b8778d9ee5586715d7b8f146b67',
        '492fd8ae10aa0430449f3b1a82329887',
        '09ef01697d8da70941d2d3ee5612a997',
        'e90cbef89c74115b2bc1c3be1d88fced',
        '734885deda5e66eadd025e543938d613',
        '42010ac868a44e15af936862d9f9723b',
        '08578572419640b0904c44535bb14e3a',
        'fde173c9c6fbd2ba636f22c341485439',
        '1275999ef122513ba437e69b03013bee',
        '3c74535ae96620ef246d49d084db6658',
        '2f144c520054fd961436485ddbbb1631',
        '705a9eee48788d9b58fe0314a8dc3d58',
        'cc4156f6d301ed220e1e1329210a8fe3'
    ];

    public static function getLicenses(): array
    {
        return static::$licenses;
    }

    public static function valid(): bool
    {
        if (str_contains(Environment::get('requestUri'), '/contao/install'))
        {
            return true;
        }

        if (static::$initialized === false)
        {
            static::$valid = EstateManager::checkLicenses(Config::get(static::$key), static::$licenses, static::$key);
            static::$initialized = true;
        }

        return static::$valid;
    }
}
