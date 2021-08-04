<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SlideRepository")
 */
class Slide
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
    private $url_image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

//    /**
//     * @ORM\ManyToOne(targetEntity="App\Entity\Slider")
//     * @ORM\JoinColumn(nullable=false)
//     */
//    private $Slider;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Slider", inversedBy="Slide")
     */
    private $slider;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tabindex;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrlImage(): ?string
    {
        return $this->url_image;
    }

    public function setUrlImage(?string $url_image): self
    {
        $this->url_image = $url_image;

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

    public function getSlider(): ?Slider
    {
        return $this->slider;
    }

    public function setSlider(?Slider $slider): self
    {
        $this->slider = $slider;

        return $this;
    }

    public function getTabindex(): ?int
    {
        return $this->tabindex;
    }

    public function setTabindex(?int $tabindex): self
    {
        $this->tabindex = $tabindex;

        return $this;
    }
}
