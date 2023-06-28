<?php

namespace App\Controller;

use App\Interface\DataExtractorInterface;
use App\Interface\HtmlParserInterface;
use App\Repository\OrganisationRepository;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ParseController extends AbstractController
{
    public function __construct(
        private DataExtractorInterface $dataExtractor,
        private HtmlParserInterface $htmlParser,
        private OrganisationRepository $organisationRepository,
    )
    {}

    #[Route('/startXmlParse', name: 'app_xmlParse', methods: 'GET')]
    public function startXmlParse(): JsonResponse
    {
        $archiveLink = $this->htmlParser->getArchiveLinkFromHtmlParse();
        $this->dataExtractor->extractXml($archiveLink);

        return $this->json('extracted completed');
    }

    #[Route('/findCompaniesByHighestDebtTotal', methods: 'GET')]
    public function findCompaniesByHighestDebtTotal(): JsonResponse
    {
        return $this->json(var_dump($this->organisationRepository->findCompaniesWithHighestDebtTotal()));
    }

    #[Route('/calculateAverageDebtByRegion', methods: 'GET')]
    public function calculateAverageDebtByRegion(): JsonResponse
    {
        return $this->json(var_dump($this->organisationRepository->getAverageDebtByRegion()));
    }

    #[Route('/fetchTotalDebtByTaxName', methods: 'GET')]
    public function fetchTotalDebtByTaxName(): JsonResponse
    {
        return $this->json(var_dump($this->organisationRepository->getTotalDebtByTaxName()));
    }
}
