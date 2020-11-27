<?php

namespace App\Entity;

use App\Repository\ChapterElementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChapterElementRepository::class)
 */
class ChapterElement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $chapterId;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $chapterElementType;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $stageOrLessonId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChapterId(): ?int
    {
        return $this->chapterId;
    }

    public function setChapterId(?int $chapterId): self
    {
        $this->chapterId = $chapterId;

        return $this;
    }

    public function getChapterElementType(): ?int
    {
        return $this->chapterElementType;
    }

    public function setChapterElementType(?int $chapterElementType): self
    {
        $this->chapterElementType = $chapterElementType;

        return $this;
    }

    public function getStageOrLessonId(): ?int
    {
        return $this->stageOrLessonId;
    }

    public function setStageOrLessonId(?int $stageOrLessonId): self
    {
        $this->stageOrLessonId = $stageOrLessonId;

        return $this;
    }
}
