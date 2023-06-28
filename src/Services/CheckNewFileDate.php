<?php

namespace App\Services;

use App\Interface\DataExtractorInterface;
use App\Interface\DataUpdaterInterface;
use App\Interface\HtmlParserInterface;
use App\Repository\DataUpdateDatesRepository;

class CheckNewFileDate
{
    public function __construct(
        private DataUpdateDatesRepository $dataUpdateDatesRepository,
        private DataUpdaterInterface $dataUpdater,
        private DataExtractorInterface $dataExtractor,
        private HtmlParserInterface $htmlParser,
    )
    {}

    public function checkNewDateAndUpdate(): void
    {
        $lastFileUpdated = $this->dataUpdateDatesRepository->findOneBy([], ['lastTimeUpdate' => 'DESC']);
        if ($lastFileUpdated) {
            $lastUpdated = $lastFileUpdated->getLastUpdate();
            $newLastFileUpdated = $this->dataUpdater->getLasDataUpdate();
            if ($newLastFileUpdated > $lastUpdated) {
                $archiveLink = $this->htmlParser->getArchiveLinkFromHtmlParse();
                if ($archiveLink) {
                    $this->dataExtractor->extractXml($archiveLink);
                    $this->dataUpdater->saveLastDataUpdate($newLastFileUpdated);
                    echo 'New data extracted and updated successfully';
                } else {
                    echo 'Failed to check archive link';
                }
            } else {
                echo 'New data not found';
            }
        } else {
            echo 'No previous update records found';
        }
    }

}