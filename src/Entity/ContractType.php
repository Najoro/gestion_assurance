<?php

namespace App\Entity;

use App\Repository\ContractTypeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContractTypeRepository::class)]
class ContractType
{ 
    CONST TYPE_LIFE = 1;
    CONST TYPE_NO_LIFE = 2;

    CONST LIST_TYPE_CONTRAT = [
        self::TYPE_LIFE => "vie",
        self::TYPE_NO_LIFE => "non Vie",
    ];

    

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $typeContract = null;


    #[ORM\OneToOne(inversedBy: 'contractType', cascade: ['persist', 'remove'])]
    private ?Contract $contract = null;

    #[ORM\Column]
    private ?\DateTime $createdAt = null;

    #[ORM\Column]
    private ?\DateTime $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'contractTypes')]
    private ?Client $client = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeContract(): ?string
    {
        return $this->typeContract;
    }

    public function setTypeContract(string $type): static
    {
        $this->typeContract = $type;

        return $this;
    }

    public function getContract(): ?Contract
    {
        return $this->contract;
    }

    public function setContract(?Contract $contract): static
    {
        $this->contract = $contract;

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

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }
}
