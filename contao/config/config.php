<?php

/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/file-download
 * @copyright Copyright (c) 2024  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

// ESTATEMANAGER
$GLOBALS['TL_ESTATEMANAGER_ADDONS'][] = ['ContaoEstateManager\FileDownload\Util', 'AddonManager'];

use ContaoEstateManager\FileDownload\Util\AddonManager;
use ContaoEstateManager\FileDownload\Util\Downloader;

if (AddonManager::valid())
{
    // HOOKS
    $GLOBALS['TL_HOOKS']['realEstateImportSaveImage'][] = [Downloader::class, 'downloadFile'];
}
