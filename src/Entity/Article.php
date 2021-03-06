<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 * 
 */
class Article
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
    private $title;

    /**
     * @ORM\Column(type="text", length=2000)
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="article", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity=PictureArticle::class, mappedBy="articles", orphanRemoval=true, cascade={"persist"})
     */
    private $pictureArticles;


    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->pictureArticles = new ArrayCollection();
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setArticle($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getArticle() === $this) {
                $comment->setArticle(null);
            }
        }

        return $this;
    }



    /**
     * @return Collection|PictureArticle[]
     */
    public function getPictureArticles(): Collection
    {
        return $this->pictureArticles;
    }

    public function addPictureArticle(PictureArticle $pictureArticle): self
    {
        if (!$this->pictureArticles->contains($pictureArticle)) {
            $this->pictureArticles[] = $pictureArticle;
            $pictureArticle->setArticles($this);
        }

        return $this;
    }

    public function removePictureArticle(PictureArticle $pictureArticle): self
    {
        if ($this->pictureArticles->removeElement($pictureArticle)) {
            // set the owning side to null (unless already changed)
            if ($pictureArticle->getArticles() === $this) {
                $pictureArticle->setArticles(null);
            }
        }

        return $this;
    }
}
