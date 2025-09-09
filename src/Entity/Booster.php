<?php

namespace App\Entity;

use App\Repository\BoosterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BoosterRepository::class)]
class Booster
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $gameName = null;

    #[ORM\Column(length: 255)]
    private ?string $boosterName = null;

    #[ORM\Column]
    private ?int $cardCount = null;

    #[ORM\Column(length: 255)]
    private ?string $imageUrl = null;

    #[ORM\Column(length: 255)]
    private ?string $backgroundUrl = null;

    /**
     * @var Collection<int, UserBooster>
     */
    #[ORM\OneToMany(targetEntity: UserBooster::class, mappedBy: 'booster')]
    private Collection $userBoosters;

    public function __construct()
    {
        $this->userBoosters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGameName(): ?string
    {
        return $this->gameName;
    }

    public function setGameName(string $gameName): static
    {
        $this->gameName = $gameName;

        return $this;
    }

    public function getBoosterName(): ?string
    {
        return $this->boosterName;
    }

    public function setBoosterName(string $boosterName): static
    {
        $this->boosterName = $boosterName;

        return $this;
    }

    public function getCardCount(): ?int
    {
        return $this->cardCount;
    }

    public function setCardCount(int $cardCount): static
    {
        $this->cardCount = $cardCount;

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

    public function getBackgroundUrl(): ?string
    {
        return $this->backgroundUrl;
    }

    public function setBackgroundUrl(string $backgroundUrl): static
    {
        $this->backgroundUrl = $backgroundUrl;

        return $this;
    }

    /**
     * @return Collection<int, UserBooster>
     */
    public function getUserBoosters(): Collection
    {
        return $this->userBoosters;
    }

    public function addUserBooster(UserBooster $userBooster): static
    {
        if (!$this->userBoosters->contains($userBooster)) {
            $this->userBoosters->add($userBooster);
            $userBooster->setBooster($this);
        }

        return $this;
    }

    public function removeUserBooster(UserBooster $userBooster): static
    {
        if ($this->userBoosters->removeElement($userBooster)) {
            // set the owning side to null (unless already changed)
            if ($userBooster->getBooster() === $this) {
                $userBooster->setBooster(null);
            }
        }

        return $this;
    }
}
