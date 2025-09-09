<?php

namespace App\Entity;

use App\Repository\CardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CardRepository::class)]
class Card
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $hp = null;

    #[ORM\Column]
    private ?int $cost = null;

    #[ORM\Column(length: 255)]
    private ?string $imageUrl = null;

    #[ORM\Column(length: 255)]
    private ?string $category = null;

    #[ORM\Column(length: 100)]
private ?string $ability1Name = null;

    #[ORM\Column(type: 'text')]
    private ?string $ability1Description = null;

    #[ORM\Column(length: 50)]
    private ?string $ability1Type = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $ability2Name = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $ability2Description = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $ability2Type = null;

    #[ORM\Column(length: 255)]
    private ?string $quote = null;

    #[ORM\Column(length: 255)]
    private ?string $rarity = null;

    /**
     * @var Collection<int, UserCard>
     */
    #[ORM\OneToMany(targetEntity: UserCard::class, mappedBy: 'card')]
    private Collection $userCards;

    public function __construct()
    {
        $this->userCards = new ArrayCollection();
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

    public function getHp(): ?int
    {
        return $this->hp;
    }

    public function setHp(int $hp): static
    {
        $this->hp = $hp;

        return $this;
    }

    public function getCost(): ?int
    {
        return $this->cost;
    }

    public function setCost(int $cost): static
    {
        $this->cost = $cost;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): static
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getQuote(): ?string
    {
        return $this->quote;
    }

    public function setQuote(string $quote): static
    {
        $this->quote = $quote;

        return $this;
    }

    public function getRarity(): ?string
    {
        return $this->rarity;
    }

    public function setRarity(string $rarity): static
    {
        $this->rarity = $rarity;

        return $this;
    }

    /**
     * @return Collection<int, UserCard>
     */
    public function getUserCards(): Collection
    {
        return $this->userCards;
    }

    public function addUserCard(UserCard $userCard): static
    {
        if (!$this->userCards->contains($userCard)) {
            $this->userCards->add($userCard);
            $userCard->setCard($this);
        }

        return $this;
    }

    public function removeUserCard(UserCard $userCard): static
    {
        if ($this->userCards->removeElement($userCard)) {
            // set the owning side to null (unless already changed)
            if ($userCard->getCard() === $this) {
                $userCard->setCard(null);
            }
        }

        return $this;
    }

    public function getAbility1Name(): ?string
    {
        return $this->ability1Name;
    }

    public function setAbility1Name(string $ability1Name): static
    {
        $this->ability1Name = $ability1Name;

        return $this;
    }

    public function getAbility1Description(): ?string
    {
        return $this->ability1Description;
    }

    public function setAbility1Description(string $ability1Description): static
    {
        $this->ability1Description = $ability1Description;

        return $this;
    }

    public function getAbility1Type(): ?string
    {
        return $this->ability1Type;
    }

    public function setAbility1Type(string $ability1Type): static
    {
        $this->ability1Type = $ability1Type;

        return $this;
    }

    public function getAbility2Name(): ?string
    {
        return $this->ability2Name;
    }

    public function setAbility2Name(?string $ability2Name): static
    {
        $this->ability2Name = $ability2Name;

        return $this;
    }

    public function getAbility2Description(): ?string
    {
        return $this->ability2Description;
    }

    public function setAbility2Description(?string $ability2Description): static
    {
        $this->ability2Description = $ability2Description;

        return $this;
    }

    public function getAbility2Type(): ?string
    {
        return $this->ability2Type;
    }

    public function setAbility2Type(?string $ability2Type): static
    {
        $this->ability2Type = $ability2Type;

        return $this;
    }
}
