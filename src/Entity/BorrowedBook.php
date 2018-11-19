<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * The relation between a book and an user.
 * Contain borrowing and returns dates.
 * @ORM\Entity(repositoryClass="App\Repository\BorrowedBookRepository")
 */
class BorrowedBook
{
    const Maison = 'Maison';
    const Bench = 'Bench';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Many borrowing can relate to one book.
     * @ORM\ManyToOne(targetEntity="App\Entity\Book", inversedBy="borrowedBooks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $book;

    /**
     * Many borrowing can relate to one user.
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="borrowedBooks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="date")
     * @Assert\Date()
     * @Assert\NotBlank()
     */
    private $borrowingDate;

    /**
     * @ORM\Column(type="date")
     * @Assert\Date()
     * @Assert\NotBlank()
     */
    private $returnDate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasBeenReturned;

    /**
     * @ORM\Column(type="string")
     * @Assert\Choice({"Maison", "Bench"})
     */
    private $reservation;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasBeenValidated;

    public function __construct()
    {
        $this->setHasBeenReturned(false);
        $this->setHasBeenValidated(false);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getBook(): Book
    {
        return $this->book;
    }

    public function setBook(Book $book): self
    {
        $this->book = $book;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getBorrowingDate(): ?\DateTimeInterface
    {
        return $this->borrowingDate;
    }

    public function setBorrowingDate(\DateTimeInterface $borrowingDate): self
    {
        $this->borrowingDate = $borrowingDate;

        return $this;
    }

    public function getReturnDate(): ?\DateTimeInterface
    {
        return $this->returnDate;
    }

    public function setReturnDate(\DateTimeInterface $returnDate): self
    {
        $this->returnDate = $returnDate;

        return $this;
    }

    public function getHasBeenReturned(): bool
    {
        return $this->hasBeenReturned;
    }

    public function setHasBeenReturned(bool $hasBeenReturned): self
    {
        $this->hasBeenReturned = $hasBeenReturned;

        return $this;
    }

    public function getReservation(): ?string
    {
        return $this->reservation;
    }

    public function setReservation(string $reservation): self
    {
        $this->reservation = $reservation;

        return $this;
    }

    public function getHasBeenValidated(): bool
    {
        return $this->hasBeenValidated;
    }

    public function setHasBeenValidated(bool $hasBeenValidated): self
    {
        $this->hasBeenValidated = $hasBeenValidated;

        return $this;
    }
}
