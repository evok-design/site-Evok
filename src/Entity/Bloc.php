<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BlocRepository")
 */
class Bloc
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Categorie")
     */
    private $Categorie;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imgHeader;

    /**
     * @ORM\Column(type="text")
     */
    private $description1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imgContent1;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imgContent2;

    /**
     * @Gedmo\Mapping\Annotation\Slug(fields={"label"})
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $meta_description;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Slider", cascade={"persist", "remove"})
     */
    private $Slider;


    public function __construct()
    {
        $this->Categorie = new ArrayCollection();
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|Categorie[]
     */
    public function getCategorie(): Collection
    {
        return $this->Categorie;
    }

    public function addCategorie(Categorie $categorie): self
    {
        if (!$this->Categorie->contains($categorie)) {
            $this->Categorie[] = $categorie;
        }

        return $this;
    }

    public function removeCategorie(Categorie $categorie): self
    {
        if ($this->Categorie->contains($categorie)) {
            $this->Categorie->removeElement($categorie);
        }

        return $this;
    }

    public function getImgHeader(): ?string
    {
        return $this->imgHeader;
    }

    public function setImgHeader(?string $imgHeader): self
    {
        $this->imgHeader = $imgHeader;

        return $this;
    }

    public function getDescription1(): ?string
    {
        return $this->description1;
    }

    public function setDescription1(string $description1): self
    {
        $this->description1 = $description1;

        return $this;
    }

    public function getImgContent1(): ?string
    {
        return $this->imgContent1;
    }

    public function setImgContent1(?string $imgContent1): self
    {
        $this->imgContent1 = $imgContent1;

        return $this;
    }

    public function getDescription2(): ?string
    {
        return $this->description2;
    }

    public function setDescription2(?string $description2): self
    {
        $this->description2 = $description2;

        return $this;
    }

    public function getImgContent2(): ?string
    {
        return $this->imgContent2;
    }

    public function setImgContent2(?string $imgContent2): self
    {
        $this->imgContent2 = $imgContent2;

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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getMetaDescription(): ?string
    {
        return $this->meta_description;
    }

    public function setMetaDescription(string $meta_description): self
    {
        $this->meta_description = $meta_description;

        return $this;
    }
    public function getSlider(): ?Slider
    {
        return $this->Slider;
    }

    public function setSlider(?Slider $Slider): self
    {
        $this->Slider = $Slider;

        return $this;
    }


}
