<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ReviewRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
#[ApiResource(
    collectionOperations: [],
    itemOperations: [
        "get" => ["security" => "is_granted('ROLE_ADMIN')"],
        ]
)]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    #[
        Assert\NotBlank([
            'message'=> 'La description du produit doit être renseignée',
        ]),
        Assert\Length([
            'min' => 2,
            'max' => 200,
            'minMessage' => 'La description du produit doit faire au moins 2 caractères',
            'maxMessage' => 'La description du produit doit faire au maximum 200 caractères',
        ])
    ]
    private ?string $comment = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[
        Assert\NotBlank([
            'message'=> 'La date de publication du produit doit être renseignée',
        ]),
        Assert\DateTime([
            'message'=> 'La date de publication du produit doit être une date valide',
        ])
    ]
    private ?\DateTimeInterface $issuedAt = null;

    #[ORM\Column(nullable: true)]
    #[
        Assert\NotBlank([
            'message'=> 'La note du produit doit être renseignée',
        ]),
        Assert\Range([
            'min' => 0,
            'max' => 5,
            'minMessage' => 'La note du produit doit être supérieure à 0',
            'maxMessage' => 'La note du produit doit être inférieure à 5',
        ])
    ]
    private ?int $rating = null;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getIssuedAt(): ?\DateTimeInterface
    {
        return $this->issuedAt;
    }

    public function setIssuedAt(\DateTimeInterface $issuedAt): self
    {
        $this->issuedAt = $issuedAt;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): self
    {
        $this->rating = $rating;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
