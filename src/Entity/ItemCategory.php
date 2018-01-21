<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ItemCategoryRepository")
 */
class ItemCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=false, unique=true)
     */
    private $name;

    /**
     * @OneToMany(targetEntity="ItemGenre", mappedBy="category")
     */
    private $genres;

    /**
     * ItemCategory constructor.
     */
    public function __construct()
    {
        $this->genres = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return ItemCategory
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getGenres()
    {
        return $this->genres;
    }

    /**
     * @param ArrayCollection $genres
     * @return ItemCategory
     */
    public function setGenres($genres)
    {
        $this->genres = $genres;
        return $this;
    }
}
