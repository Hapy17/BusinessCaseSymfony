<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ContainRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContainRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get' => ['security' => 'is_granted("ROLE_ADMIN")'],
    ],
    itemOperations: [
        'get' => ['security' => 'is_granted("ROLE_ADMIN")' ],
    ],
)]
class Contain
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: '0')]
    private ?string $unitPriceHt = null;

    #[ORM\ManyToOne(inversedBy: 'contains')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[ORM\ManyToOne(inversedBy: 'contains')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Basket $basket = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getUnitPriceHt(): ?string
    {
        return $this->unitPriceHt;
    }

    public function setUnitPriceHt(string $unitPriceHt): self
    {
        $this->unitPriceHt = $unitPriceHt;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getBasket(): ?Basket
    {
        return $this->basket;
    }

    public function setBasket(?Basket $basket): self
    {
        $this->basket = $basket;

        return $this;
    }
}
