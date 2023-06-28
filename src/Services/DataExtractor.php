<?php

namespace App\Services;

use App\Interface\DataExtractorInterface;
use App\Interface\DataSaverInterface;

class DataExtractor implements DataExtractorInterface
{
    public function __construct(
        private DataSaverInterface $dataSaver,
    )
    {}

    public function parserXmlFileFromDirectory(string $newTempDirectory): void
    {
        $fileNames = scandir($newTempDirectory);
        foreach ($fileNames as $file) {
            if ($file === '.' || $file ==='..') {
                continue;
            }
            $xmlFolder = $newTempDirectory . '/' . $file;
            $xmlFiles = scandir($xmlFolder);
            foreach ($xmlFiles as $xmlFile) {
                if ($xmlFile === '.' || $xmlFile === '..') {
                    continue;
                }
                $xmlFilePath = $xmlFolder . '/'. $xmlFile;
                $this->dataSaver->saveData($xmlFilePath);
            }
        }
    }

    public function extractXml(string $archiveUrl): void
    {
        $tempDir = sys_get_temp_dir();
        $newTempDirectory = $tempDir . '/' . uniqid(true, false);
        $archiveName = uniqid('archive', true) . '.zip';
        $archivePath = $tempDir. '/' .$archiveName;

        $archiveContent = file_get_contents($archiveUrl);
        if ($archiveContent === false) {
            echo 'Failed to retrieve the archive';
            return;
        }

        if (file_put_contents($archivePath, $archiveContent) === false) {
            echo 'Failed to save the archive';
            return;
        }
        $zip = new \ZipArchive();
        if ($zip->open($archivePath, \ZipArchive::CREATE)) {
            $zip->extractTo($newTempDirectory);
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $this->parserXmlFileFromDirectory($newTempDirectory);
            }
            $zip->close();
        }
        else {
            echo 'Failed to open the archive';
        }

        unlink($archivePath);
    }
}