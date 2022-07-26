<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PaymentMethodRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PaymentMethodRepository::class)]
#[ApiResource(
    collectionOperations: [],
    itemOperations: [
        "get" => ["security" => "is_granted('ROLE_ADMIN')"],
        ]
)]
class PaymentMethod
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[
        Assert\NotBlank([
            'message'=> 'Le mode de paiement doit être renseigné',
        ]),
        Assert\Length([
            'min' => 2,
            'max' => 50,
            'minMessage' => 'Le mode de paiement doit faire au moins 2 caractères',
            'maxMessage' => 'Le mode de paiement doit faire au maximum 50 caractères',
        ])

    ]
    private ?string $denomination = null;

    #[ORM\OneToMany(mappedBy: 'paymentMethod', targetEntity: Order::class)]
    private Collection $ordersPayments;

    public function __construct()
    {
        $this->ordersPayments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDenomination(): ?string
    {
        return $this->denomination;
    }

    public function setDenomination(string $denomination): self
    {
        $this->denomination = $denomination;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrdersPayments(): Collection
    {
        return $this->ordersPayments;
    }

    public function addOrdersPayment(Order $ordersPayment): self
    {
        if (!$this->ordersPayments->contains($ordersPayment)) {
            $this->ordersPayments[] = $ordersPayment;
            $ordersPayment->setPaymentMethod($this);
        }

        return $this;
    }

    public function removeOrdersPayment(Order $ordersPayment): self
    {
        if ($this->ordersPayments->removeElement($ordersPayment)) {
            // set the owning side to null (unless already changed)
            if ($ordersPayment->getPaymentMethod() === $this) {
                $ordersPayment->setPaymentMethod(null);
            }
        }

        return $this;
    }
}
