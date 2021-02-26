<?php

namespace App\Entity;

use App\Repository\GameSessionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GameSessionRepository::class)
 */
class GameSession
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="guid")
     */
    private $uuid;

    /**
     * @ORM\Column(type="integer")
     */
    private $idUser;

    /**
     * @ORM\Column(type="integer")
     */
    private $idGame;

    /**
     * @ORM\Column(type="integer")
     */
    private $idChapter;

    /**
     * @ORM\Column(type="integer")
     */
    private $idChapterElement;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $idKata;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function setIdUser(int $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getIdGame(): ?int
    {
        return $this->idGame;
    }

    public function setIdGame(int $idGame): self
    {
        $this->idGame = $idGame;

        return $this;
    }

    public function getIdChapter(): ?int
    {
        return $this->idChapter;
    }

    public function setIdChapter(int $idChapter): self
    {
        $this->idChapter = $idChapter;

        return $this;
    }

    public function getIdChapterElement(): ?int
    {
        return $this->idChapterElement;
    }

    public function setIdChapterElement(int $idChapterElement): self
    {
        $this->idChapterElement = $idChapterElement;

        return $this;
    }

    public function getIdKata(): ?int
    {
        return $this->idKata;
    }

    public function setIdKata(?int $idKata): self
    {
        $this->idKata = $idKata;

        return $this;
    }
}
