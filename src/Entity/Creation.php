<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CreationRepository")
 */
class Creation
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
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

//    /**
//     * @ORM\OneToMany(targetEntity="App\Entity\Categorie", cascade={"persist"}, mappedBy="creation")
//     */
//    private $categories;

    /**
     * @Gedmo\Mapping\Annotation\Slug(fields={"title"})
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Categorie", inversedBy="Categorie")
     */
    private $Categorie;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image2;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image_header;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image_content;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="creations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Client;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image_corps_2;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $img_big_nb;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $img_small_nb;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Slider", cascade={"persist", "remove"})
     */
    private $Slider;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $html_title;

    /**
     * @ORM\Column(type="text")
     */
    private $meta_description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ordre;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->Categorie = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Categorie[]
     */
//    public function getCategories(): Collection
//    {
//        return $this->categories;
//    }
//
//    public function addCategory(Categorie $category): self
//    {
//        if (!$this->categories->contains($category)) {
//            $this->categories[] = $category;
//            $category->setCreation($this);
//        }
//
//        return $this;
//    }
//
//    public function removeCategory(Categorie $category): self
//    {
//        if ($this->categories->contains($category)) {
//            $this->categories->removeElement($category);
//            // set the owning side to null (unless already changed)
//            if ($category->getCreation() === $this) {
//                $category->setCreation(null);
//            }
//        }
//
//        return $this;
//    }

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

    public function getImage1(): ?string
    {
        return $this->image1;
    }

    public function setImage1(?string $image1): self
    {
        $this->image1 = $image1;

        return $this;
    }

    public function getImage2(): ?string
    {
        return $this->image2;
    }

    public function setImage2(?string $image2): self
    {
        $this->image2 = $image2;

        return $this;
    }

    public function getImageHeader(): ?string
    {
        return $this->image_header;
    }

    public function setImageHeader(?string $image_header): self
    {
        $this->image_header = $image_header;

        return $this;
    }

    public function getImageContent(): ?string
    {
        return $this->image_content;
    }

    public function setImageContent(?string $image_content): self
    {
        $this->image_content = $image_content;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->Client;
    }

    public function setClient(?Client $Client): self
    {
        $this->Client = $Client;

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

    public function getImageCorps2(): ?string
    {
        return $this->image_corps_2;
    }

    public function setImageCorps2(?string $image_corps_2): self
    {
        $this->image_corps_2 = $image_corps_2;

        return $this;
    }

    public function getImageMini(): ?string
    {
        return $this->image_mini;
    }

    public function setImageMini(?string $image_mini): self
    {
        $this->image_mini = $image_mini;

        return $this;
    }

    public function getImgBigNb(): ?string
    {
        return $this->img_big_nb;
    }

    public function setImgBigNb(?string $img_big_nb): self
    {
        $this->img_big_nb = $img_big_nb;

        return $this;
    }

    public function getImgSmallNb(): ?string
    {
        return $this->img_small_nb;
    }

    public function setImgSmallNb(?string $img_small_nb): self
    {
        $this->img_small_nb = $img_small_nb;

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

    public function getHtmlTitle(): ?string
    {
        return $this->html_title;
    }

    public function setHtmlTitle(string $html_title): self
    {
        $this->html_title = $html_title;

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

    public function getOrdre(): ?int
    {
        return $this->ordre;
    }

    public function setOrdre(?int $ordre): self
    {
        $this->ordre = $ordre;

        return $this;
    }
}
