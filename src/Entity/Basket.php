<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BasketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BasketRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get' => ['security' => 'is_granted("ROLE_STATS")'],
        'post' => ['security' => 'is_granted("ROLE_ADMIN")'],
    ],
    itemOperations: [
        'get' => ['security' => 'is_granted("ROLE_STATS")' ],
        'put' => ['security' => 'is_granted("ROLE_ADMIN")' ],
        'delete' => ['security' => 'is_granted("ROLE_ADMIN")' ],
        'patch' => ['security' => 'is_granted("ROLE_ADMIN")' ],
    ],
)]
class Basket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[
        Assert\NotBlank([
            "message" => "La date de la commande est obligatoire",
        ]),
        Assert\LessThanOrEqual([
            "value" => "now",
            "message" => "La date de la commande doit être inférieure ou égale à la date du jour",
        ]),
    ]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column]
    #[
        Assert\NotBlank([
            "message" => "Le statut de la commande est obligatoire",
        ]),
        Assert\Choice([
            "choices"=>[
                "100" => "En cours",
                "200" => "Terminé",
                "300" => "Annulé",
            ]
        ])
        
    ]
    private ?int $basketStatus = null;

    #[ORM\OneToOne(mappedBy: 'basket', cascade: ['persist', 'remove'])]
    private ?Order $relateOrder = null;

    #[ORM\ManyToOne(inversedBy: 'baskets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'basket', targetEntity: Contain::class)]
    private Collection $contains;

    public function __construct()
    {
        $this->contains = new ArrayCollection();
         // faire un dump de $this->contains pour voir ce que contient la collection
        dump($this->contains);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getBasketStatus(): ?int
    {
        return $this->basketStatus;
    }

    public function setBasketStatus(int $basketStatus): self
    {
        $this->basketStatus = $basketStatus;

        return $this;
    }

    public function getRelateOrder(): ?Order
    {
        return $this->relateOrder;
    }

    public function setRelateOrder(Order $relateOrder): self
    {
        // set the owning side of the relation if necessary
        if ($relateOrder->getBasket() !== $this) {
            $relateOrder->setBasket($this);
        }

        $this->relateOrder = $relateOrder;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Contain>
     */
    public function getContains(): Collection
    {
        return $this->contains;
    }

    public function addContain(Contain $contain): self
    {
        if (!$this->contains->contains($contain)) {
            $this->contains[] = $contain;
            $contain->setBasket($this);
        }

        return $this;
    }

    public function removeContain(Contain $contain): self
    {
        if ($this->contains->removeElement($contain)) {
            // set the owning side to null (unless already changed)
            if ($contain->getBasket() === $this) {
                $contain->setBasket(null);
            }
        }

        return $this;
    }
}
