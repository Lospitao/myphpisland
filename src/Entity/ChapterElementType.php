<?php

namespace App\Entity;

use App\Repository\ChapterElementTypeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChapterElementTypeRepository::class)
 */
class ChapterElementType
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
    private $chapterElement;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChapterElement(): ?string
    {
        return $this->chapterElement;
    }

    public function setChapterElement(?string $chapterElement): self
    {
        $this->chapterElement = $chapterElement;

        return $this;
    }
}
