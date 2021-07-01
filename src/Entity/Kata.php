<?php

namespace App\Entity;

use App\Repository\ChallengeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
/**
 * @ORM\Entity(repositoryClass=ChallengeRepository::class)
 */
class Kata
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $editorCode;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $examples;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $kata_title;

    /**
     * @ORM\Column(type="guid")
     */
    private $uuid;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LessonKatas", mappedBy="kata")
     */
    private $lesson;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $kata_test_code;

    public function __construct()
    {
        $this->lesson = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getEditorCode(): ?string
    {
        return $this->editorCode;
    }

    public function setEditorCode(string $editorCode): self
    {
        $this->editorCode = $editorCode;

        return $this;
    }

    public function getExamples(): ?string
    {
        return $this->examples;
    }

    public function setExamples(string $examples): self
    {
        $this->examples = $examples;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getKataTitle(): ?string
    {
        return $this->kata_title;
    }

    public function setKataTitle(string $kata_title): self
    {
        $this->kata_title = $kata_title;

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
     * @return Collection|LessonKatas[]
     */
    public function getLesson(): Collection
    {
        return $this->lesson;
    }

    public function addLesson(Lesson $lesson): self
    {
        if (!$this->lesson->contains($lesson)) {
            $this->lesson[] = $lesson;
            $lesson->addKatum($this);
        }

        return $this;
    }

    public function removeLesson(Lesson $lesson): self
    {
        if ($this->lesson->contains($lesson)) {
            $this->lesson->removeElement($lesson);
            $lesson->removeKatum($this);
        }

        return $this;
    }

    public function getKataTestCode(): ?string
    {
        return $this->kata_test_code;
    }

    public function setKataTestCode(?string $kata_test_code): self
    {
        $this->kata_test_code = $kata_test_code;

        return $this;
    }

}
