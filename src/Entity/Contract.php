<?php

namespace App\Entity;

use App\Repository\ContractRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContractRepository::class)]
class Contract
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
    private ?\DateTime $createdAt = null;

    #[ORM\Column]
    private ?\DateTime $updatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $dateStart = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $dateEnd = null;

    #[ORM\OneToOne(mappedBy: 'contract', cascade: ['persist', 'remove'])]
    private ?ContractType $contractType = null;

    /**
     * @var Collection<int, Sinistre>
     */
    #[ORM\OneToMany(targetEntity: Sinistre::class, mappedBy: 'contract')]
    private Collection $sinistres;

    /**
     * @var Collection<int, Client>
     */
    #[ORM\ManyToMany(targetEntity: Client::class, mappedBy: 'contracts')]
    private Collection $clients;

    public function __construct()
    {
        $this->sinistres = new ArrayCollection();
        $this->clients = new ArrayCollection();
        $this->setCreatedAt(new DateTime());
        $this->setupdatedAt(new DateTime());    }

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

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDateStart(): ?DateTime
    {
        return $this->dateStart;
    }

    public function setDateStart(\DateTime $dateStart): static
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDateEnd(): ?DateTime
    {
        return $this->dateEnd;
    }

    public function setDateEnd(DateTime $dateEnd): static
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

    /**
     * @return Collection<int, Client>
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(Client $client): static
    {
        if (!$this->clients->contains($client)) {
            $this->clients->add($client);
            $client->addContract($this);
        }

        return $this;
    }

    public function removeClient(Client $client): static
    {
        if ($this->clients->removeElement($client)) {
            $client->removeContract($this);
        }

        return $this;
    }
}
