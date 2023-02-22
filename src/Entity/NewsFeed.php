<?php

namespace App\Entity;

use App\Repository\NewsFeedRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NewsFeedRepository::class)
 */
class NewsFeed
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
    private $title;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $short_description;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $date_added;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $last_modified;

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

    public function getShortDescription(): ?string
    {
        return $this->short_description;
    }

    public function setShortDescription(string $short_description): self
    {
        $this->short_description = $short_description;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getDateAdded(): ?string
    {
        return $this->date_added;
    }

    public function setDateAdded(string $date_added): self
    {
        $this->date_added = $date_added;

        return $this;
    }

    public function getLastModified(): ?string
    {
        return $this->last_modified;
    }

    public function setLastModified(string $last_modified): self
    {
        $this->last_modified = $last_modified;

        return $this;
    }
}
