<?php

namespace App\Entity;

use App\Repository\QuackCommentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuackCommentRepository::class)
 */
class QuackComment
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
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity=Quack::class, inversedBy="quackComments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $quack;

    /**
     * @ORM\ManyToOne(targetEntity=Duck::class, inversedBy="quackComments")
     * @ORM\JoinColumn(nullable=true)
     */
    private $author;

    /**
     * @ORM\OneToOne(targetEntity=QuackComment::class, inversedBy="quackComment", cascade={"persist", "remove"})
     */
    private $DeleteComment;

    /**
     * @ORM\OneToOne(targetEntity=QuackComment::class, mappedBy="DeleteComment", cascade={"persist", "remove"})
     */
    private $quackComment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getQuack(): ?Quack
    {
        return $this->quack;
    }

    public function setQuack(?Quack $quack): self
    {
        $this->quack = $quack;

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

    public function getDeleteComment(): ?self
    {
        return $this->DeleteComment;
    }

    public function setDeleteComment(?self $DeleteComment): self
    {
        $this->DeleteComment = $DeleteComment;

        return $this;
    }

    public function getQuackComment(): ?self
    {
        return $this->quackComment;
    }

    public function setQuackComment(?self $quackComment): self
    {
        // unset the owning side of the relation if necessary
        if ($quackComment === null && $this->quackComment !== null) {
            $this->quackComment->setDeleteComment(null);
        }

        // set the owning side of the relation if necessary
        if ($quackComment !== null && $quackComment->getDeleteComment() !== $this) {
            $quackComment->setDeleteComment($this);
        }

        $this->quackComment = $quackComment;

        return $this;
    }
}
