<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    CONST TYPE_CLIENT_UNIQUE = 1;
    CONST TYPE_CLIENT_GROUP = 2;


    CONST LIST_TYPE_CLIENT = [
        self::TYPE_CLIENT_UNIQUE => "Unique",
        self::TYPE_CLIENT_GROUP => "Groupe",
    ];


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $Adress = null;

    #[ORM\Column]
    private ?\DateTime $birthday = null;

    #[ORM\Column(length: 255)]
    private ?string $typeClient = null;

    #[ORM\Column]
    private ?\DateTime $createdAt = null;

    #[ORM\Column]
    private ?\DateTime $updatedAt = null;


    /**
     * @var Collection<int, Sinistre>
     */
    #[ORM\OneToMany(targetEntity: Sinistre::class, mappedBy: 'client')]
    private Collection $sinistres;

    #[ORM\Column(nullable: true)]
    private ?bool $sex = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $phoneNumber = null;

    /**
     * @var Collection<int, ContractType>
     */
    #[ORM\OneToMany(targetEntity: ContractType::class, mappedBy: 'client')]
    private Collection $contractTypes;

    /**
     * @var Collection<int, Contract>
     */
    #[ORM\ManyToMany(targetEntity: Contract::class, inversedBy: 'clients')]
    private Collection $contracts;

    public function __construct()
    {
        $this->sinistres = new ArrayCollection();
        $this->contractTypes = new ArrayCollection();
        $this->setCreatedAt(new DateTime());
        $this->setupdatedAt(new DateTime());
        $this->contracts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->Adress;
    }

    public function setAdress(string $Adress): static
    {
        $this->Adress = $Adress;

        return $this;
    }

    public function getBirthday(): ?\DateTime
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTime $birthday): static
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getTypeClient(): ?string
    {
        return $this->typeClient;
    }

    public function setTypeClient(string $type): static
    {
        $this->typeClient = $type;

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
            $sinistre->setClient($this);
        }

        return $this;
    }

    public function removeSinistre(Sinistre $sinistre): static
    {
        if ($this->sinistres->removeElement($sinistre)) {
            // set the owning side to null (unless already changed)
            if ($sinistre->getClient() === $this) {
                $sinistre->setClient(null);
            }
        }

        return $this;
    }

    public function isSex(): ?bool
    {
        return $this->sex;
    }

    public function setSex(?bool $sex): static
    {
        $this->sex = $sex;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return Collection<int, ContractType>
     */
    public function getContractTypes(): Collection
    {
        return $this->contractTypes;
    }

    public function addContractType(ContractType $contractType): static
    {
        if (!$this->contractTypes->contains($contractType)) {
            $this->contractTypes->add($contractType);
            $contractType->setClient($this);
        }

        return $this;
    }

    public function removeContractType(ContractType $contractType): static
    {
        if ($this->contractTypes->removeElement($contractType)) {
            // set the owning side to null (unless already changed)
            if ($contractType->getClient() === $this) {
                $contractType->setClient(null);
            }
        }

        return $this;
    }

    public function getFullName() {
        return $this->firstName.' '. $this->lastName;;
    }

    /**
     * @return Collection<int, Contract>
     */
    public function getContracts(): Collection
    {
        return $this->contracts;
    }

    public function addContract(Contract $contract): static
    {
        if (!$this->contracts->contains($contract)) {
            $this->contracts->add($contract);
        }

        return $this;
    }

    public function removeContract(Contract $contract): static
    {
        $this->contracts->removeElement($contract);

        return $this;
    }
}
