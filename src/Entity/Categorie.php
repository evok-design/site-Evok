<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategorieRepository")
 */
class Categorie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * @Gedmo\Mapping\Annotation\Slug(fields={"label"})
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Creation", mappedBy="Categorie")
     */
    private $Creation;

    public function __construct()
    {
        $this->Categorie = new ArrayCollection();
    }

//    /**
//     * @ORM\ManyToOne(targetEntity="App\Entity\Creation", inversedBy="categories")
//     */
//    private $creation;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection|Creation[]
     */
    public function getCreation(): Collection
    {
        return $this->Creation;
    }

    public function addCreation(Creation $creation): self
    {
        if (!$this->Creation->contains($creation)) {
            $this->Creation[] = $creation;
            $creation->addCategorie($this);
        }

        return $this;
    }

    public function removeCreation(Creation $creation): self
    {
        if ($this->Creation->contains($creation)) {
            $this->Creation->removeElement($creation);
            $creation->removeCategorie($this);
        }

        return $this;
    }

//    public function getCreation(): ?Creation
//    {
//        return $this->creation;
//    }
//
//    public function setCreation(?Creation $creation): self
//    {
//        $this->creation = $creation;
//
//        return $this;
//    }
}
