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
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Advert::class)]
    private Collection $price;

    public function __construct()
    {
        $this->price = new ArrayCollection();
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

    /**
     * @return Collection<int, Advert>
     */
    public function getPrice(): Collection
    {
        return $this->price;
    }

    public function addPrice(Advert $price): self
    {
        if (!$this->price->contains($price)) {
            $this->price->add($price);
            $price->setCategory($this);
        }

        return $this;
    }

    public function removePrice(Advert $price): self
    {
        if ($this->price->removeElement($price)) {
            // set the owning side to null (unless already changed)
            if ($price->getCategory() === $this) {
                $price->setCategory(null);
            }
        }

        return $this;
    }
}
