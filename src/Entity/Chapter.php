<?php

namespace App\Entity;

use App\Repository\ChapterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChapterRepository::class)
 */
class Chapter
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="guid")
     */
    private $uuid;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\GameChapters", mappedBy="chapter")
     */
    private $game;

    public function __construct()
    {
        $this->game = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * @return Collection|GameChapters[]
     */
    public function getGame(): Collection
    {
        return $this->game;
    }

    public function addGame(game $game): self
    {
        if (!$this->game->contains($game)) {
            $this->game[] = $game;
            $game->addChapter($this);
        }

        return $this;
    }

    public function removeGame(game $game): self
    {
        if ($this->game->contains($game)) {
            $this->game->removeElement($game);
            $game->removeChapter($this);
        }

        return $this;
    }
}
