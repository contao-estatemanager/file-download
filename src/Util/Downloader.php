<?php

/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/project
 * @copyright Copyright (c) 2024  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

namespace ContaoEstateManager\FileDownload\Util;

use Contao\Config;
use Contao\Database;
use Contao\File;
use Contao\FilesModel;
use Contao\System;
use ContaoEstateManager\FilesHelper;

class Downloader extends System
{
    /**
     * Import the Config instance
     */
    protected function __construct()
    {
        $this->import(Database::class, 'Database');

        parent::__construct();
    }

    public function downloadFile($objFilesFolder, &$value, $tmpGroup, &$values, &$skip, $context): void
    {
        if ($context->interfaceMapping->downloadFileFromURL)
        {
            $check = next($tmpGroup->check);

            $fileName = $this->getValueFromStringUrl($value);

            if (!strlen(pathinfo($fileName, PATHINFO_EXTENSION)))
            {
                $format = current($tmpGroup->format);
                $extension = $this->getExtension($format);

                // Skip document or image if no file extension could be determined
                if ($extension === false)
                {
                    $skip = true;
                    return;
                }

                $fileName .= $extension;
            }

            $existingFile = FilesModel::findByPath($objFilesFolder->path . '/' . $context->uniqueProviderValue . '/' . $context->uniqueValue . '/' . $fileName);

            if ($existingFile !== null && $existingFile->hash === $check)
            {
                $values[] = $existingFile->uuid;
                $skip = true;
                return;
            }

            $this->download($value, $context->importFolder, $fileName);

            $fileSize = FilesHelper::fileSize($context->importFolder->path . '/tmp/' . $fileName);
            $maxUpload = Config::get('estateManagerMaxFileSize') ?? 3000000;

            if ($fileSize > $maxUpload || $fileSize === 0)
            {
                $skip = true;
                return;
            }

            $value = $fileName;
        }
    }

    protected function getValueFromStringUrl($url)
    {
        $parts = parse_url($url);

        if (isset($parts['query']))
        {
            parse_str($parts['query'], $query);
        }

        if (isset($parts['path']))
        {
            $arrPathFragments = explode('/', $parts['path']);

            if (count($arrPathFragments))
            {
                return end($arrPathFragments);
            }
        }

        return null;
    }

    protected function getExtension($format)
    {
        switch ($format)
        {
            case 'image/jpeg':
            case 'image/jpg':
                $extension = '.jpg';
                break;

            case 'image/png':
                $extension = '.png';
                break;

            case 'image/gif':
                $extension = '.gif';
                break;

            case 'application/pdf':
                $extension = '.pdf';
                break;

            case 'application/octet-stream':
                return false;

            default:
                if (strpos('/', $format) === false)
                {
                    $extension = '.' . strtolower($format);
                }
                else
                {
                    return false;
                }
        }

        return $extension;
    }

    protected function download($path, $targetDirectory, $fileName, $tmpFolder=true): void
    {
        $content = $this->getFileContent($path);

        File::putContent($targetDirectory->path . '/' . ($tmpFolder ? 'tmp/' : '') . $fileName, $content);
    }

    protected function getFileContent($path)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $path);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }
}
