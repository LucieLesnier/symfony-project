<?php

namespace App\Entity;

use App\Repository\DuckRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=DuckRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class Duck implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"quack", "duck"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"quack", "duck"})
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"quack", "duck"})
     */
    private $duckname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"duck"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({ "duck"})
     */
    private $lastname;

    /**
     * @ORM\OneToMany(targetEntity=Quack::class, mappedBy="author", orphanRemoval=true)
     * @Groups({ "duck"})
     */
    private $quacks;

    /**
     * @ORM\OneToMany(targetEntity=QuackComment::class, mappedBy="author", orphanRemoval=true)
     * @Groups({ "duck"})
     */
    private $quackComments;


    public function __construct()
    {
        $this->quacks = new ArrayCollection();
        $this->quackComments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getDuckname(): ?string
    {
        return $this->duckname;
    }

    public function setDuckname(string $duckname): self
    {
        $this->duckname = $duckname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return Collection|Quack[]
     */
    public function getQuacks(): Collection
    {
        return $this->quacks;
    }

    public function addQuack(Quack $quack): self
    {
        if (!$this->quacks->contains($quack)) {
            $this->quacks[] = $quack;
            $quack->setAuthor($this);
        }

        return $this;
    }

    public function removeQuack(Quack $quack): self
    {
        if ($this->quacks->removeElement($quack)) {
            // set the owning side to null (unless already changed)
            if ($quack->getAuthor() === $this) {
                $quack->setAuthor(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->duckname;
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
            $quackComment->setAuthor($this);
        }

        return $this;
    }

    public function removeQuackComment(QuackComment $quackComment): self
    {
        if ($this->quackComments->removeElement($quackComment)) {
            // set the owning side to null (unless already changed)
            if ($quackComment->getAuthor() === $this) {
                $quackComment->setAuthor(null);
            }
        }

        return $this;
    }


}
