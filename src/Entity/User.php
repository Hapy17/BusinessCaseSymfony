<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: UserRepoSsitory::class)]
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
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[
        Assert\NotBlank([
            'message'=> 'L\'email doit être renseigné',
        ]),
        Assert\Email([
            'message'=> 'L\'email doit être valide',
        ]),
        Assert\Length([
            'min' => 2,
            'max' => 180,
            'minMessage' => 'L\'email doit faire au moins 2 caractères',
            'maxMessage' => 'L\'email doit faire au maximum 180 caractères',
        ])
    ]
    private ?string $email = null;

    #[ORM\Column(length: 180, unique: true)]
    #[
        Assert\NotBlank([
            'message'=> 'Le pseudo doit être renseigné',
        ]),
        Assert\Length([
            'min' => 2,
            'max' => 180,
            'minMessage' => 'Le pseudo doit faire au moins 2 caractères',
            'maxMessage' => 'Le pseudo doit faire au maximum 180 caractères',
        ])
    ]
    private ?string $username = null;

    #[ORM\Column]
    
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[
        
        Assert\Length([
            'min' => 8,
            'max' => 255,
            'minMessage' => 'Le mot de passe doit faire au moins 8 caractères',
            'maxMessage' => 'Le mot de passe doit faire au maximum 255 caractères',
        ])
    ]
    private ?string $password = null;

    #[ORM\Column(length: 50)]
    #[
        Assert\NotBlank([
            'message'=> 'Le nom doit être renseigné',
        ]),
        Assert\Length([
            'min' => 2,
            'max' => 50,
            'minMessage' => 'Le nom doit faire au moins 2 caractères',
            'maxMessage' => 'Le nom doit faire au maximum 50 caractères',
        ])
    ]
    private ?string $firstName = null;

    #[ORM\Column(length: 50)]
    #[
        Assert\NotBlank([
            'message'=> 'Le prénom doit être renseigné',
        ]),
        Assert\Length([
            'min' => 2,
            'max' => 50,
            'minMessage' => 'Le prénom doit faire au moins 2 caractères',
            'maxMessage' => 'Le prénom doit faire au maximum 50 caractères',
        ])
    ]
    private ?string $lastName = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[
        Assert\NotBlank([
            'message'=> 'La date de naissance doit être renseignée',
        ]),
        Assert\LessThan([
            'value' => '-18 years',
            'message' => 'Vous devez être majeur pour vous inscrire',
        ])
    ]
    private ?\DateTimeInterface $birthAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[
        Assert\LessThan([
            'value' => 'now',
            'message' => 'La date d\'inscription doit être antérieure à la date actuelle',
        ])
    ]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?PostalAddress $postalAddress = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Gender $gender = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Basket::class)]
    private Collection $baskets;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Review::class)]
    private Collection $reviews;

    #[ORM\ManyToMany(targetEntity: Product::class, mappedBy: 'user')]
    private Collection $products;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    public function __construct()
    {
        $this->baskets = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * 
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBirthAt(): ?\DateTimeInterface
    {
        return $this->birthAt;
    }

    public function setBirthAt(\DateTimeInterface $birthAt): self
    {
        $this->birthAt = $birthAt;

        return $this;
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

    public function getPostalAddress(): ?PostalAddress
    {
        return $this->postalAddress;
    }

    public function setPostalAddress(?PostalAddress $postalAddress): self
    {
        $this->postalAddress = $postalAddress;

        return $this;
    }

    public function getGender(): ?Gender
    {
        return $this->gender;
    }

    public function setGender(?Gender $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return Collection<int, Basket>
     */
    public function getBaskets(): Collection
    {
        return $this->baskets;
    }

    public function addBasket(Basket $basket): self
    {
        if (!$this->baskets->contains($basket)) {
            $this->baskets[] = $basket;
            $basket->setUser($this);
        }

        return $this;
    }

    public function removeBasket(Basket $basket): self
    {
        if ($this->baskets->removeElement($basket)) {
            // set the owning side to null (unless already changed)
            if ($basket->getUser() === $this) {
                $basket->setUser(null);
            }
        }

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
            $review->setUser($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getUser() === $this) {
                $review->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->addUser($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            $product->removeUser($this);
        }

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}
