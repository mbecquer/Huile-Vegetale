<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\FamilyRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=FamilyRepository::class)
 */
class Family
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex(pattern="/^[A-Z]+$/", match=true, message="Seules les majuscules sont autorisées")
     */
    private $name;

    private $slug;
    /**
     * @ORM\OneToMany(targetEntity=Huiles::class, mappedBy="family",orphanRemoval=true)
     */
    private $huile;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    public function __construct()
    {
        $this->huile = new ArrayCollection();
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
     * @return Collection|Huiles[]
     */
    public function getHuile(): Collection
    {
        return $this->huile;
    }

    public function addHuile(Huiles $huile): self
    {
        if (!$this->huile->contains($huile)) {
            $this->huile[] = $huile;
            $huile->setFamily($this);
        }

        return $this;
    }

    public function removeHuile(Huiles $huile): self
    {
        if ($this->huile->removeElement($huile)) {
            // set the owning side to null (unless already changed)
            if ($huile->getFamily() === $this) {
                $huile->setFamily(null);
            }
        }

        return $this;
    }
    /**
     * Get the value of slug
     */
    public function getSlug()
    {
        return (new Slugify())->slugify($this->name);
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }
}
