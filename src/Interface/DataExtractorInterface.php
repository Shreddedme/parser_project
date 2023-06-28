<?php

namespace App\Interface;

interface DataExtractorInterface
{
    public function parserXmlFileFromDirectory(string $newTempDirectory): void;
    public function extractXml(string $archiveUrl): void;
}