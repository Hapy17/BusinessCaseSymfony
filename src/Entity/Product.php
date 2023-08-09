<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
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
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[
        Assert\NotBlank([
            'message'=> 'Le nom du produit doit être renseigné',
        ]),
        Assert\Length([
            'min' => 2,
            'max' => 100,
            'minMessage' => 'Le nom du produit doit faire au moins 2 caractères',
            'maxMessage' => 'Le nom du produit doit faire au maximum 100 caractères',
        ])
    ]
    private ?string $name = null;

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
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 2)]
    #[
        Assert\NotBlank([
            'message'=> 'Le prix du produit doit être renseigné',
        ]),
        Assert\Range([
            'min' => 0,
            'max' => 9999.99,
            'minMessage' => 'Le prix du produit doit être supérieur ou égal à 0',
            'maxMessage' => 'Le prix du produit doit être inférieur ou égal à 9999.99',
        ])
    ]
    private ?string $priceHt = null;

    #[ORM\Column]
    #[
        Assert\NotBlank([
            'message'=> 'La date de création du produit doit être renseignée',
        ]),
        Assert\Type([
            'type'=>'bool',
            'message' => 'Le produit ne peut être ou ne pas être '

        ])
    ]
    private ?bool $isActive = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Review::class)]
    private Collection $reviews;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Contain::class)]
    private Collection $contains;

    #[ORM\ManyToMany(targetEntity: Animal::class, inversedBy: 'products')]
    private Collection $animals;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'products')]
    private Collection $user;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Brand $brand = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Category $category = null;

    // #[ORM\Column(length: 255 , nullable: true)]
    // private ?string $picture = null;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
        $this->contains = new ArrayCollection();
        $this->animals = new ArrayCollection();
        $this->user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPriceHt(): ?string
    {
        return $this->priceHt;
    }

    public function setPriceHt(string $priceHt): self
    {
        $this->priceHt = $priceHt;

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setProduct($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getProduct() === $this) {
                $review->setProduct(null);
            }
        }

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
            $contain->setProduct($this);
        }

        return $this;
    }

    public function removeContain(Contain $contain): self
    {
        if ($this->contains->removeElement($contain)) {
            // set the owning side to null (unless already changed)
            if ($contain->getProduct() === $this) {
                $contain->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Animal>
     */
    public function getAnimals(): Collection
    {
        return $this->animals;
    }

    public function addAnimal(Animal $animal): self
    {
        if (!$this->animals->contains($animal)) {
            $this->animals[] = $animal;
        }

        return $this;
    }

    public function removeAnimal(Animal $animal): self
    {
        $this->animals->removeElement($animal);

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->user->removeElement($user);

        return $this;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    // public function getPicture(): ?string
    // {
    //     return $this->picture;
    // }

    // public function setPicture(?string $picture): self
    // {
    //     $this->picture = $picture;

    //     return $this;
    // }
}
