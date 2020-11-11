<?php

namespace App\Entity;

use App\Repository\StageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StageRepository::class)
 */
class Stage
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ambient_sound;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dialog;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $background_image;

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

    public function getAmbientSound(): ?string
    {
        return $this->ambient_sound;
    }

    public function setAmbientSound(?string $ambient_sound): self
    {
        $this->ambient_sound = $ambient_sound;

        return $this;
    }

    public function getDialog(): ?string
    {
        return $this->dialog;
    }

    public function setDialog(?string $dialog): self
    {
        $this->dialog = $dialog;

        return $this;
    }

    public function getBackgroundImage(): ?string
    {
        return $this->background_image;
    }

    public function setBackgroundImage(?string $background_image): self
    {
        $this->background_image = $background_image;

        return $this;
    }
}
