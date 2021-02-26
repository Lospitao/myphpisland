<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=GameRepository::class)
 */
class Game
{
    const ID_MYPHPISLAND = 1;
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
     * @ORM\Column(type="guid", nullable=true)
     */
    private $uuid;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\GameChapters", mappedBy="game", fetch="EXTRA_LAZY")
     */
    private $chapter;

    public function __construct()
    {
        $this->chapter = new ArrayCollection();
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

    public function setUuid(?string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * @return Collection|LessonKatas[]
     */
    public function getChapter(): Collection
    {
        return $this->chapter;
    }

    public function addChapter(chapter $chapter): self
    {
        if (!$this->chapter->contains($chapter)) {
            $this->chapter[] = $chapter;
        }

        return $this;
    }

    public function removeChapter(chapter $chapter): self
    {
        if ($this->chapter->contains($chapter)) {
            $this->chapter->removeElement($chapter);
        }

        return $this;
    }

}
