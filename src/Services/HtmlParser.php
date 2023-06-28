<?php

namespace App\Services;

use App\Interface\HtmlParserInterface;
use Symfony\Component\DomCrawler\Crawler;

class HtmlParser implements HtmlParserInterface
{
    public function getArchiveLinkFromHtmlParse(): string
    {
        $url = 'https://www.nalog.gov.ru/opendata/7707329152-debtam/';
        $crawler = new Crawler(file_get_contents($url));
        $linkElement = $crawler->filter('[href*=data-20221201-structure]')->first();

        return $linkElement->attr('href');
    }
}