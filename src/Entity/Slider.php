<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SliderRepository")
 */
class Slider
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Slide", mappedBy="slider", cascade="remove")
     */
    private $Slide;

    public function __construct()
    {
        $this->Slide = new ArrayCollection();
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
     * @return Collection|Slide[]
     */
    public function getSlide(): Collection
    {
        return $this->Slide;
    }

    public function addSlide(Slide $slide): self
    {
        if (!$this->Slide->contains($slide)) {
            $this->Slide[] = $slide;
            $slide->setSlider($this);
        }

        return $this;
    }

    public function removeSlide(Slide $slide): self
    {
        if ($this->Slide->contains($slide)) {
            $this->Slide->removeElement($slide);
            // set the owning side to null (unless already changed)
            if ($slide->getSlider() === $this) {
                $slide->setSlider(null);
            }
        }

        return $this;
    }

}
