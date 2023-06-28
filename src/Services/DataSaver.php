<?php

namespace App\Services;

use App\Entity\Debt;
use App\Entity\Organisation;
use App\Entity\Tax;
use App\Interface\DataSaverInterface;
use App\Repository\OrganisationRepository;
use Doctrine\ORM\EntityManagerInterface;

class DataSaver implements DataSaverInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    )
    {}

    public function saveData(string $xmlFile): void
    {
        $xml = file_get_contents($xmlFile);
        $xmlData = simplexml_load_string($xml);
        if ($xmlData) {
            foreach ($xmlData->{'Документ'} as $item) {
                $organisationName = $item->{'СведНП'}['НаимОрг'];
                $inn = intval($item->{'СведНП'}['ИННЮЛ']);

                    $organisation = new Organisation($organisationName, $inn);
                    $this->entityManager->persist($organisation);

                foreach ($item->{'СведНедоим'} as $taxItem) {
                    $taxName = $taxItem['НаимНалог'];
                    $debtAmount = floatval($taxItem['ОбщСумНедоим']);

                    $tax = new Tax($taxName, $organisation);
                    $this->entityManager->persist($tax);

                    $debt = new Debt($debtAmount, $organisation, $tax);
                    $this->entityManager->persist($debt);
                }

                $this->entityManager->flush();
            }
        } else {
            echo "Fail to parse xml file";
        }
    }
}