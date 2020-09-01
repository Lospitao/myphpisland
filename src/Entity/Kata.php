<?php

namespace App\Entity;

use App\Repository\ChallengeRepository;
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
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $editorCode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $testCode;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $kata_title;

    /**
     * @ORM\Column(type="guid")
     */
    private $uuid;



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

    public function getTestCode(): ?string
    {
        return $this->testCode;
    }

    public function setTestCode(string $testCode): self
    {
        $this->testCode = $testCode;

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


}
