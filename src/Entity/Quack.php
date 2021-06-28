<?php

namespace App\Entity;

use App\Repository\QuackRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuackRepository::class)
 */
class Quack
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
    private $message;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $picture;

    /**
     * @ORM\Column(type="datetime", length=255)
     */
    private $datetime;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tags;

    /**
     * @ORM\ManyToOne(targetEntity=Duck::class, inversedBy="quacks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity=QuackComment::class, mappedBy="quack")
     */
    private $quackComments;

    public function __construct()
    {
        $this->quackComments = new ArrayCollection();
        $this->datetime = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }



    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getDatetime(): ?\DateTime
    {
        return $this->datetime;
    }

    public function setDatetime(\DateTime $datetime): self
    {
        $this->datetime = $datetime;

        return $this;
    }

    public function getTags(): ?string
    {
        return $this->tags;
    }

    public function setTags(string $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    public function getAuthor(): ?Duck
    {
        return $this->author;
    }

    public function setAuthor(?Duck $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection|QuackComment[]
     */
    public function getQuackComments(): Collection
    {
        return $this->quackComments;
    }

    public function addQuackComment(QuackComment $quackComment): self
    {
        if (!$this->quackComments->contains($quackComment)) {
            $this->quackComments[] = $quackComment;
            $quackComment->setQuack($this);
        }

        return $this;
    }

    public function removeQuackComment(QuackComment $quackComment): self
    {
        if ($this->quackComments->removeElement($quackComment)) {
            // set the owning side to null (unless already changed)
            if ($quackComment->getQuack() === $this) {
                $quackComment->setQuack(null);
            }
        }

        return $this;
    }
}
