<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $label = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'childrenCategories')]
    private ?self $relatedCategory = null;

    #[ORM\OneToMany(mappedBy: 'relatedCategory', targetEntity: self::class)]
    private Collection $childrenCategories;

    public function __construct()
    {
        $this->childrenCategories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getRelatedCategory(): ?self
    {
        return $this->relatedCategory;
    }

    public function setRelatedCategory(?self $relatedCategory): self
    {
        $this->relatedCategory = $relatedCategory;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getChildrenCategories(): Collection
    {
        return $this->childrenCategories;
    }

    public function addChildrenCategory(self $childrenCategory): self
    {
        if (!$this->childrenCategories->contains($childrenCategory)) {
            $this->childrenCategories[] = $childrenCategory;
            $childrenCategory->setRelatedCategory($this);
        }

        return $this;
    }

    public function removeChildrenCategory(self $childrenCategory): self
    {
        if ($this->childrenCategories->removeElement($childrenCategory)) {
            // set the owning side to null (unless already changed)
            if ($childrenCategory->getRelatedCategory() === $this) {
                $childrenCategory->setRelatedCategory(null);
            }
        }

        return $this;
    }
}
