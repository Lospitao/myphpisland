<?php

namespace App\Entity;

use App\Repository\LessonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LessonRepository::class)
 */
class Lesson
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
     * @ORM\Column(type="guid", nullable=true)
     */
    private $uuid;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LessonKatas", mappedBy="lesson", fetch="EXTRA_LAZY")
     */
    private $kata;

    public function __construct()
    {
        $this->kata = new ArrayCollection();
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
    public function getKatas(): Collection
    {
        return $this->kata;
    }

    public function addKatum(Kata $katum): self
    {
        if (!$this->kata->contains($katum)) {
            $this->kata[] = $katum;
            $katum->addLesson($this);
        }

        return $this;
    }

    public function removeKatum(Kata $katum): self
    {
        if ($this->kata->contains($katum)) {
            $this->kata->removeElement($katum);
            $katum->removeLesson($this);
        }

        return $this;
    }
}
