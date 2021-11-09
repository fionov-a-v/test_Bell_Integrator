<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;
//use Gedmo\Translatable\Translatable;
//use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ApiResource(
 *     routePrefix="book",
 *     formats={"json"},
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write"}},
 *     paginationEnabled=false,
 *     collectionOperations={
 *          "GET"={
 *              "path"="/search",
 *          },
 *          "POST"={
 *              "path"="/create",
 *          }
 *     },
 *     itemOperations={
 *          "GET"={
 *              "path"="/{id}",
 *              "requirements"={"id"="\d+"},
 *          },
 *     },
 * ),
 * @ApiFilter(SearchFilter::class, properties={"name"="partial"})
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
class Book
{

    /*
     *  *          "search"={
 *
 *              "path"="/search",
 *              "requirements"={"id"="\d+"},
 *              "defaults"={"color"="brown"},
 *              "options"={"my_option"="my_option_value"},
 *              "read"=false,
 *              "output"=false,
 *              "controller"=SearchController::class,
 *          }
     * */

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read", "write"})
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Author::class, inversedBy="books")
     * @Groups({"read", "write"})
     */
    private $author;

    public function __construct()
    {
        $this->author = new ArrayCollection();
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

    /**
     * @return Collection|Author[]
     */
    public function getAuthor(): Collection
    {
        return $this->author;
    }

    public function addAuthor(Author $author): self
    {
        if (!$this->author->contains($author)) {
            $this->author[] = $author;
        }

        return $this;
    }

    public function removeAuthor(Author $author): self
    {
        $this->author->removeElement($author);

        return $this;
    }

//    /**
//     * @Gedmo\Locale
//     */
//    private $translatableLocale;
//
//    /**
//     * @return $this
//     */
//    public function setTranslatableLocale(string $translatableLocale)
//    {
//        $this->translatableLocale = $translatableLocale;
//
//        return $this;
//    }

}
