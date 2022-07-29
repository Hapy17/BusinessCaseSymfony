<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OrderStateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderStateRepository::class)]
#[ApiResource(
    collectionOperations: [],
    itemOperations: [
        "get" => ["security" => "is_granted('ROLE_ADMIN')"],
        ]
)]
class OrderState
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $status = null;

    #[ORM\OneToMany(mappedBy: 'orderState', targetEntity: Order::class)]
    private Collection $ordersState;

    public function __construct()
    {
        $this->ordersState = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrdersState(): Collection
    {
        return $this->ordersState;
    }

    public function addOrdersState(Order $ordersState): self
    {
        if (!$this->ordersState->contains($ordersState)) {
            $this->ordersState[] = $ordersState;
            $ordersState->setOrderState($this);
        }

        return $this;
    }

    public function removeOrdersState(Order $ordersState): self
    {
        if ($this->ordersState->removeElement($ordersState)) {
            // set the owning side to null (unless already changed)
            if ($ordersState->getOrderState() === $this) {
                $ordersState->setOrderState(null);
            }
        }

        return $this;
    }
}
