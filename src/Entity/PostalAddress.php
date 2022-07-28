<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PostalAddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostalAddressRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get' => ['security' => 'is_granted("ROLE_ADMIN")'],
    ],
    itemOperations: [
        'get' => ['security' => 'is_granted("ROLE_ADMIN")' ],
    ],
)]
class PostalAddress
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 75)]
    private ?string $line1 = null;

    #[ORM\Column(length: 75, nullable: true)]
    private ?string $line2 = null;

    #[ORM\Column(length: 75, nullable: true)]
    private ?string $line3 = null;

    #[ORM\Column(length: 5)]
    private ?string $postalCode = null;

    #[ORM\Column(length: 75)]
    private ?string $city = null;

    #[ORM\OneToMany(mappedBy: 'postalAddress', targetEntity: User::class)]
    private Collection $users;

    #[ORM\OneToMany(mappedBy: 'postalAddress', targetEntity: Order::class)]
    private Collection $orders;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLine1(): ?string
    {
        return $this->line1;
    }

    public function setLine1(string $line1): self
    {
        $this->line1 = $line1;

        return $this;
    }

    public function getLine2(): ?string
    {
        return $this->line2;
    }

    public function setLine2(?string $line2): self
    {
        $this->line2 = $line2;

        return $this;
    }

    public function getLine3(): ?string
    {
        return $this->line3;
    }

    public function setLine3(?string $line3): self
    {
        $this->line3 = $line3;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

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
            $user->setPostalAddress($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getPostalAddress() === $this) {
                $user->setPostalAddress(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setPostalAddress($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getPostalAddress() === $this) {
                $order->setPostalAddress(null);
            }
        }

        return $this;
    }
}
