<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    /**
     * @var Collection<int, UserCard>
     */
    #[ORM\OneToMany(targetEntity: UserCard::class, mappedBy: 'user')]
    private Collection $userCards;

    /**
     * @var Collection<int, UserBooster>
     */
    #[ORM\OneToMany(targetEntity: UserBooster::class, mappedBy: 'user')]
    private Collection $userBoosters;

    public function __construct()
    {
        $this->userCards = new ArrayCollection();
        $this->userBoosters = new ArrayCollection();
        $this->roles = ['ROLE_USER']; // rôle par défaut
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;

        // Garantie que chaque utilisateur a au moins ROLE_USER
        if (!in_array('ROLE_USER', $roles)) {
            $roles[] = 'ROLE_USER';
        }

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->email ?? '';
    }

    public function eraseCredentials(): void
    {
        // Si tu stockes un mot de passe en clair temporairement, efface-le ici
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
            $userCard->setUser($this);
        }

        return $this;
    }

    public function removeUserCard(UserCard $userCard): static
    {
        if ($this->userCards->removeElement($userCard)) {
            if ($userCard->getUser() === $this) {
                $userCard->setUser(null);
            }
        }

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
            $userBooster->setUser($this);
        }

        return $this;
    }

    public function removeUserBooster(UserBooster $userBooster): static
    {
        if ($this->userBoosters->removeElement($userBooster)) {
            if ($userBooster->getUser() === $this) {
                $userBooster->setUser(null);
            }
        }

        return $this;
    }
}