<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GenderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GenderRepository::class)]
#[ApiResource(
    collectionOperations: [],
    itemOperations: [
        "get" => ["security" => "is_granted('ROLE_ADMIN')"],
        ]
)]
class Gender
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[
        Assert\NotBlank([
            'message'=> 'Le genre doit être renseigné',
        ]),
        Assert\Length([
            'min' => 2,
            'max' => 50,
            'minMessage' => 'Le genre doit faire au moins 2 caractères',
            'maxMessage' => 'Le genre doit faire au maximum 50 caractères',
        ])

    ]
    private ?string $type = null;

    #[ORM\OneToMany(mappedBy: 'gender', targetEntity: User::class)]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setGender($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getGender() === $this) {
                $user->setGender(null);
            }
        }

        return $this;
    }
}
