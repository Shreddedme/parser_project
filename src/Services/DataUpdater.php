<?php

namespace App\Services;

use App\Entity\DataUpdateDates;
use App\Interface\DataUpdaterInterface;
use App\Interface\HtmlParserInterface;
use Doctrine\ORM\EntityManagerInterface;

class DataUpdater implements DataUpdaterInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private HtmlParserInterface $htmlParser,
    )
    {}

    public function getLasDataUpdate(): \DateTime
    {
        $dateLink = $this->htmlParser->getArchiveLinkFromHtmlParse();
        if (empty($dateLink)) {
            throw new \Exception('Empty archive link');
        }

        $dataPosition = strpos($dateLink, 'data-');
        if ($dataPosition === false) {
            throw new \Exception('Invalid archive link format');
        }

        $dataLength =  strlen('data-');
        $startPosition = $dataPosition + $dataLength;
        $date = substr($dateLink, $startPosition, 8);

        return \DateTime::createFromFormat('Ymd', $date);
    }

    public function saveLastDataUpdate(\DateTime $dateTime): void
    {
        $dataDate = new DataUpdateDates($dateTime);
        $this->entityManager->persist($dataDate);
        $this->entityManager->flush();
    }
}