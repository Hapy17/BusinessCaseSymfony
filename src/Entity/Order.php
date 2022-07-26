<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OrderRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Controller\Stats\MontantTotalController;
use App\Controller\Stats\TotalOrdersController;


#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
#[ApiResource(
    collectionOperations: [
        'get' => ['security' => 'is_granted("ROLE_STATS")'],
        'post' => ['security' => 'is_granted("ROLE_ADMIN")'],

        'getTotalSales' => [
            'security' => 'is_granted("ROLE_STATS")',
            'method' => 'GET',
            'path' => '/total-sales',
            'controller' => MontantTotalController::class,
            
        ],

        'getTotalOrders' => [
            'security' => 'is_granted("ROLE_STATS")',
            'method' => 'GET',
            'path' => '/total-orders',
            'controller' => TotalOrdersController::class,
            
        ],
    ],
    itemOperations: [
        'get' => ['security' => 'is_granted("ROLE_STATS")' ],
        'put' => ['security' => 'is_granted("ROLE_ADMIN")' ],
        'delete' => ['security' => 'is_granted("ROLE_ADMIN")' ],
        'patch' => ['security' => 'is_granted("ROLE_ADMIN")' ],
    ],
)]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[
        Assert\NotBlank([
            'message'=> 'La date de la conversion en commande doit être renseignée',
        ]),
        Assert\DateTime([
            'value' => 'now',
            'message'=> 'La date de la conversion en commande doit être une date valide',
        ])
    ]
    private ?\DateTimeInterface $convertedAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[
        Assert\NotBlank([
            'message'=> 'La date du paiement de la commande doit être renseignée',
        ]),
        Assert\DateTime([
            'value' => 'now',
            'message'=> 'La date du paiement de la commande doit être une date valide',
        ])
    ]
    private ?\DateTimeInterface $billedAt = null;

    #[ORM\OneToOne(inversedBy: 'relateOrder')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Basket $basket = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PostalAddress $postalAddress = null;

    #[ORM\ManyToOne(inversedBy: 'ordersState')]
    #[ORM\JoinColumn(nullable: false)]
    private ?OrderState $orderState = null;

    #[ORM\ManyToOne(inversedBy: 'ordersPayments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PaymentMethod $paymentMethod = null;

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

    public function getBasket(): ?Basket
    {
        return $this->basket;
    }

    public function setBasket(Basket $basket): self
    {
        $this->basket = $basket;

        return $this;
    }

    public function getPostalAddress(): ?PostalAddress
    {
        return $this->postalAddress;
    }

    public function setPostalAddress(?PostalAddress $postalAddress): self
    {
        $this->postalAddress = $postalAddress;

        return $this;
    }

    public function getOrderState(): ?OrderState
    {
        return $this->orderState;
    }

    public function setOrderState(?OrderState $orderState): self
    {
        $this->orderState = $orderState;

        return $this;
    }

    public function getPaymentMethod(): ?PaymentMethod
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(?PaymentMethod $paymentMethod): self
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }
}
