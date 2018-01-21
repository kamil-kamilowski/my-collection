<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ItemGenreRepository")
 */
class ItemGenre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="ItemCategory")
     * @JoinColumn(name="item_category_id", referencedColumnName="id", nullable=false)
     */
    private $category;

    /**
     * String $name
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ItemCategory
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param ItemCategory $category
     * @return ItemGenre
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
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
     * @return ItemGenre
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
}
