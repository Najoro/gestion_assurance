<?php

namespace App\Entity;

use App\Repository\ContractsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContractsRepository::class)]
class Contracts
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $number = null;

    #[ORM\Column(nullable: true)]
    private ?float $amountInsured = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $DateStart = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateEnd = null;

    #[ORM\OneToOne(mappedBy: 'contract', cascade: ['persist', 'remove'])]
    private ?ContractType $contractType = null;

    /**
     * @var Collection<int, Sinistre>
     */
    #[ORM\OneToMany(targetEntity: Sinistre::class, mappedBy: 'contract')]
    private Collection $sinistres;

    public function __construct()
    {
        $this->sinistres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getAmountInsured(): ?float
    {
        return $this->amountInsured;
    }

    public function setAmountInsured(?float $amountInsured): static
    {
        $this->amountInsured = $amountInsured;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->DateStart;
    }

    public function setDateStart(\DateTimeInterface $DateStart): static
    {
        $this->DateStart = $DateStart;

        return $this;
    }

    public function getDateEnd(): ?string
    {
        return $this->dateEnd;
    }

    public function setDateEnd(string $dateEnd): static
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    public function getContractType(): ?ContractType
    {
        return $this->contractType;
    }

    public function setContractType(?ContractType $contractType): static
    {
        // unset the owning side of the relation if necessary
        if ($contractType === null && $this->contractType !== null) {
            $this->contractType->setContract(null);
        }

        // set the owning side of the relation if necessary
        if ($contractType !== null && $contractType->getContract() !== $this) {
            $contractType->setContract($this);
        }

        $this->contractType = $contractType;

        return $this;
    }

    /**
     * @return Collection<int, Sinistre>
     */
    public function getSinistres(): Collection
    {
        return $this->sinistres;
    }

    public function addSinistre(Sinistre $sinistre): static
    {
        if (!$this->sinistres->contains($sinistre)) {
            $this->sinistres->add($sinistre);
            $sinistre->setContract($this);
        }

        return $this;
    }

    public function removeSinistre(Sinistre $sinistre): static
    {
        if ($this->sinistres->removeElement($sinistre)) {
            // set the owning side to null (unless already changed)
            if ($sinistre->getContract() === $this) {
                $sinistre->setContract(null);
            }
        }

        return $this;
    }
}
