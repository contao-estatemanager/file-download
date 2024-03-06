<?php

/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/file-download
 * @copyright Copyright (c) 2024  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

use ContaoEstateManager\FileDownload\Util\AddonManager;
use Contao\CoreBundle\DataContainer\PaletteManipulator;

if (AddonManager::valid())
{
    $GLOBALS['TL_DCA']['tl_interface_mapping']['fields']['downloadFileFromURL'] = [
        'exclude'   => true,
        'filter'    => true,
        'inputType' => 'checkbox',
        'eval'      => ['tl_class'=>'w50'],
        'sql'       => "char(1) NOT NULL default ''"
    ];

    PaletteManipulator::create()
        ->addField('downloadFileFromURL', 'saveImage')
        ->applyToPalette('tl_real_estate', 'tl_interface_mapping')
        ->applyToPalette('tl_contact_person', 'tl_interface_mapping')
    ;
}
