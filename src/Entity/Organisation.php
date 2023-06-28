<?php

namespace App\Entity;

use App\Repository\OrganisationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrganisationRepository::class)]
class Organisation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $inn = null;

    /**
     * @param string|null $name
     * @param int|null $inn
     */
    public function __construct(?string $name, ?int $inn)
    {
        $this->name = $name;
        $this->inn = $inn;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getInn(): ?int
    {
        return $this->inn;
    }

    public function setInn(int $inn): static
    {
        $this->inn = $inn;

        return $this;
    }
}
