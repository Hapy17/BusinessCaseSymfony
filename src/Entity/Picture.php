<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PictureRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PictureRepository::class)]
#[ApiResource(
    collectionOperations: [],
    itemOperations: [
        "get" => ["security" => "is_granted('ROLE_ADMIN')"],
        ]
)]
class Picture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[
        Assert\NotBlank([
            'message'=> 'Le nom de la photo doit être renseigné',
        ]),
        Assert\Length([
            'min' => 2,
            'max' => 50,
            'minMessage' => 'Le nom de la photo doit faire au moins 2 caractères',
            'maxMessage' => 'Le nom de la photo doit faire au maximum 50 caractères',
        ])

    ]
    private ?string $name = null;

    #[ORM\Column]
    #[
        Assert\NotBlank([
            'message'=> 'La photo doit être renseignée',
        ]),
        Assert\Image([
            'maxSize' => '2M',
            'mimeTypes' => ['image/png', 'image/jpeg'],
            'mimeTypesMessage' => 'Le fichier doit être une image',
        ])
    ]
    private ?bool $isMain = null;

    #[ORM\ManyToOne(inversedBy: 'pictures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[ORM\Column(length: 255)]
    #[
        Assert\NotBlank([
            'message'=> 'Le lien de la photo doit être renseigné',
        ]),
        Assert\Length([
            'min' => 2,
            'max' => 255,
            'minMessage' => 'Le lien de la photo doit faire au moins 2 caractères',
            'maxMessage' => 'Le lien de la photo doit faire au maximum 255 caractères',
        ])
    ]
    private ?string $path = null;

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

    public function isIsMain(): ?bool
    {
        return $this->isMain;
    }

    public function setIsMain(bool $isMain): self
    {
        $this->isMain = $isMain;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

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
}
