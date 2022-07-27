<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $convertedAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $billedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConvertedAt(): ?\DateTimeInterface
    {
        return $this->convertedAt;
    }

    public function setConvertedAt(\DateTimeInterface $convertedAt): self
    {
        $this->convertedAt = $convertedAt;

        return $this;
    }

    public function getBilledAt(): ?\DateTimeInterface
    {
        return $this->billedAt;
    }

    public function setBilledAt(\DateTimeInterface $billedAt): self
    {
        $this->billedAt = $billedAt;

        return $this;
    }
}
