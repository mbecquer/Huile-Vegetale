<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\HuilesRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=HuilesRepository::class)
 * @Vich\Uploadable()
 */
class Huiles
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    private $slug;
    /**
     * @ORM\Column(type="text", length=1000)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $capacity;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantity;

    /**
     * @ORM\OneToMany(targetEntity=Picture::class, mappedBy="huiles", orphanRemoval=true, cascade={"persist"})
     */
    private $pictures;

    /**
     * @Assert\All({
     *      @Assert\Image(
     *          mimeTypes = {"image/jpeg", "image/png"},
     *          mimeTypesMessage = "le fichier {{ name }} n'est pas de type {{ types }}"
     * )
     * })
     */
    private $pictureFiles;

    /**
     * @ORM\ManyToOne(targetEntity=Family::class, inversedBy="huile",cascade={"persist"})
     */
    private $family;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;


    public function __construct()
    {
        $this->pictures = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }



    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get the value of slug
     */
    public function getSlug()
    {
        return (new Slugify())->slugify($this->name);
    }

    /**
     * @return Collection|Picture[]
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(Picture $picture): self
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures[] = $picture;
            $picture->setHuiles($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): self
    {
        if ($this->pictures->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getHuiles() === $this) {
                $picture->setHuiles(null);
            }
        }

        return $this;
    }

    /**
     * Get )
     *
     * @return  arrayCollection|null
     */
    public function getPictureFiles()
    {
        return $this->pictureFiles;
    }

    /**
     * Set )
     *
     * @param  mixed $pictureFiles
     *
     * @return  Huiles
     */
    public function setPictureFiles($pictureFiles)
    {
        foreach ($pictureFiles as $pictureFile) {

            $picture = new Picture();
            $picture->setImageFile($pictureFile);
            $this->addPicture($picture);
        }

        $this->pictureFiles = $pictureFiles;
        return $this;
    }

    public function getFamily(): ?Family
    {
        return $this->family;
    }

    public function setFamily(?Family $family): self
    {
        $this->family = $family;

        return $this;
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
