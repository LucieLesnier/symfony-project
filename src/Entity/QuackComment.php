<?php

namespace App\Entity;

use App\Repository\QuackCommentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=QuackCommentRepository::class)
 */
class QuackComment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({ "duck", "quack"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({ "duck", "quack"})
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
     * @Groups({"quack"})
     */
    private $author;

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

}
