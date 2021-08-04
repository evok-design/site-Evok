<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Boolean;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActualitesRepository")
 */
class Actualites
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
    private $titre;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="text")
     */
    private $contenu;

    /**
     * @Gedmo\Mapping\Annotation\Slug(fields={"titre"})
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imgPrev;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imgHeader;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imgContent;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Slider", cascade={"persist", "remove"})
     */
    private $Slider;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $meta_description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $video;

    /**
     * @ORM\Column(type="boolean")
     */
    private $newsletter_publish;

    /**
     * @ORM\Column(type="text")
     */
    private $newsletter_text_preview;


    public function __construct(){
        $this->date = new \DateTime();
        $this->newsletter_publish = 0;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

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

    public function getImgPrev(): ?string
    {
        return $this->imgPrev;
    }

    public function setImgPrev(?string $imgPrev): self
    {
        $this->imgPrev = $imgPrev;

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

    public function getImgContent(): ?string
    {
        return $this->imgContent;
    }

    public function setImgContent(?string $imgContent): self
    {
        $this->imgContent = $imgContent;

        return $this;
    }

    public function getSlider(): ?slider
    {
        return $this->Slider;
    }

    public function setSlider(?slider $Slider): self
    {
        $this->Slider = $Slider;

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


    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(?string $video): self
    {
        $this->title = $video;

        return $this;
    }

    public function getNewsletterPublish(): ?bool
    {
        return $this->newsletter_publish;
    }

    public function setNewsletterPublish(?bool $newsletter_publish): self
    {
        $this->title = $newsletter_publish;

        return $this;
    }

    public function getNewsletterTextPreview(): ?string
    {
        return $this->newsletter_text_preview;
    }

    public function setNewsletterTextPreview(?string $newsletter_text_preview): self
    {
        $this->newsletter_text_preview = $newsletter_text_preview;

        return $this;
    }



}
