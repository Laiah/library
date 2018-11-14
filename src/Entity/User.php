<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * An user can borrow or lend books.
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30, nullable=false)
     * @Assert\NotBlank()
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasBorrowed;

    /**
     * An user can own many books.
     * @ORM\OneToMany(targetEntity="App\Entity\Book", mappedBy="owner", orphanRemoval=true)
     */
    private $books;

    /**
     * An user can borrow many books.
     * @ORM\OneToMany(targetEntity="App\Entity\BorrowedBook", mappedBy="user", orphanRemoval=true)
     */
    private $borrowedBooks;

    public function __construct()
    {
        $this->books = new ArrayCollection();
        $this->borrowedBooks = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getHasBorrowed(): bool
    {
        return $this->hasBorrowed;
    }

    public function setHasBorrowed(bool $hasBorrowed): self
    {
        $this->hasBorrowed = $hasBorrowed;

        return $this;
    }

    public function getUser(): string
    {
      return $this->firstname . ' - @' . $this->username;
    }

    /**
     * @return Collection|Book[]
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): self
    {
        if (!$this->books->contains($book)) {
            $this->books[] = $book;
            $book->setOwner($this);
        }

        return $this;
    }

    public function removeBook(Book $book): self
    {
        if ($this->books->contains($book)) {
            $this->books->removeElement($book);
        }

        return $this;
    }

    /**
     * @return Collection|BorrowedBook[]
     */
    public function getBorrowedBooks(): Collection
    {
        return $this->borrowedBooks;
    }

    public function addBorrowedBook(BorrowedBook $borrowedBook): self
    {
        if (!$this->borrowedBooks->contains($borrowedBook)) {
            $this->borrowedBooks[] = $borrowedBook;
            $borrowedBook->setUser($this);
        }

        return $this;
    }

    public function removeBorrowedBook(BorrowedBook $borrowedBook): self
    {
        if ($this->borrowedBooks->contains($borrowedBook)) {
            $this->borrowedBooks->removeElement($borrowedBook);
        }

        return $this;
    }
}
