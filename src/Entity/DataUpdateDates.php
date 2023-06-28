<?php

namespace App\Entity;

use App\Repository\DataUpdateDatesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DataUpdateDatesRepository::class)]
class DataUpdateDates
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $lastUpdate;


    public function __construct(?\DateTimeInterface $lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastUpdate(): ?\DateTimeInterface
    {
        return $this->lastUpdate;
    }

    public function setLastUpdate(\DateTimeInterface $lastUpdate): static
    {
        $this->lastUpdate = $lastUpdate;

        return $this;
    }
}
