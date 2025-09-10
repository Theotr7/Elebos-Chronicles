<?php

namespace App\Entity;

use App\Repository\UserBoosterRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserBoosterRepository::class)]
class UserBooster
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $isOpened = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $obtainedAt = null;

    #[ORM\ManyToOne(inversedBy: 'userBoosters')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'userBoosters')]
    #[ORM\JoinColumn(name: 'booster_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private ?Booster $booster = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isOpened(): ?bool
    {
        return $this->isOpened;
    }

    public function setIsOpened(bool $isOpened): static
    {
        $this->isOpened = $isOpened;

        return $this;
    }

    public function getObtainedAt(): ?\DateTimeImmutable
    {
        return $this->obtainedAt;
    }

    public function setObtainedAt(\DateTimeImmutable $obtainedAt): static
    {
        $this->obtainedAt = $obtainedAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getBooster(): ?Booster
    {
        return $this->booster;
    }

    public function setBooster(?Booster $booster): static
    {
        $this->booster = $booster;

        return $this;
    }
}
