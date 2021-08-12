<?php

namespace App\Entity;

use App\Repository\ChapterElementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChapterElementRepository::class)
 */
class ChapterElement
{
    const ID_chapter_element_type_lesson = 1;
    const ID_chapter_element_type_stage= 2;
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

    /**
     * @ORM\Column(type="integer")
     */
    private $position;

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

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }
}
