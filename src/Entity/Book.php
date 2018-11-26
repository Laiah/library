<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * The book available in the library.
 * @ORM\Entity(repositoryClass="App\Repository\BookRepository")
 */
class Book
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=false)
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\Url()
     */
    private $cover;

    /**
     * @ORM\Column(type="string", length=13, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Isbn(
     *   type = "isbn13",
     *   message = "This value ({{ value }}) is not a valid ISBN-13."
     * )
     */
    private $ISBN;

    /**
     * Many books can only have one owner.
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="books")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    /**
     * Many books can have many categories
     * @ORM\ManyToMany(targetEntity="App\Entity\Category", inversedBy="books", cascade={"persist"})
     * @ORM\JoinTable(name="category_book")
     */
    private $categories;

    /**
     * A book can be borrowed multiple times.
     * @ORM\OneToMany(targetEntity="App\Entity\BorrowedBook", mappedBy="book", orphanRemoval=true)
     */
    private $borrowedBooks;

    /**
     * @ORM\Column(type="array")
     * @Assert\NotBlank()
     */
    private $authors = [];

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comments;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $location = "Bordeaux";

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->borrowedBooks = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(string $cover): self
    {
        $this->cover = $cover;

        return $this;
    }

    public function getISBN(): ?int
    {
        return $this->ISBN;
    }

    public function setISBN(int $ISBN): self
    {
        $this->ISBN = $ISBN;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
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
            $borrowedBook->setBook($this);
        }

        return $this;
    }

    public function getAuthors(): ?array
    {
        return $this->authors;
    }

    public function setAuthors(array $authors): self
    {
        $this->authors = $authors;

        return $this;
    }

    public function getComments(): ?string
    {
        return $this->comments;
    }

    public function setComments(?string $comments): self
    {
        $this->comments = $comments;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }
}
