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
     */
    private $borrowingDate;

    /**
     * @ORM\Column(type="date")
     * @Assert\Date()
     */
    private $returnDate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasBeenReturned;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isBenchReservation;

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

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getBorrowingDate(): \DateTimeInterface
    {
        return $this->borrowingDate;
    }

    public function setBorrowingDate(\DateTimeInterface $borrowingDate): self
    {
        $this->borrowingDate = $borrowingDate;

        return $this;
    }

    public function getReturnDate(): \DateTimeInterface
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

    public function getIsBenchReservation(): bool
    {
        return $this->isBenchReservation;
    }

    public function setIsBenchReservation(bool $isBenchReservation): self
    {
        $this->isBenchReservation = $isBenchReservation;

        return $this;
    }

    public function getIsBenchReservationString(): string
    {
        if ($this->getIsBenchReservation()) {
            return 'Bench';
        }

        return 'Maison';
    }

    public function getBorrowingDateString(): string
    {
        return date_format($this->borrowingDate, 'd-m-Y');
    }

    public function getReturnDateString(): string
    {
        return date_format($this->returnDate, 'd-m-Y');
    }
}
