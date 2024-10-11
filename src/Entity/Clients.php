<?php

namespace App\Entity;

use App\Repository\ClientsRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientsRepository::class)]
class Clients
{
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

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $birthday = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;


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

    public function __construct()
    {
        $this->sinistres = new ArrayCollection();
        $this->contractTypes = new ArrayCollection();
        $this->setCreatedAt(new DateTimeImmutable());
        $this->setupdatedAt(new DateTimeImmutable());
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

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTimeInterface $birthday): static
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

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
}
