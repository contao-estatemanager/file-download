<?php

/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/file-download
 * @copyright Copyright (c) 2024  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

declare(strict_types=1);

namespace ContaoEstateManager\FileDownload;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class EstateManagerFileDownload extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
