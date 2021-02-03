<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Class LessonKatas
 * @ORM\Entity
 * @ORM\Table(name="lesson_kata")
 */
Class LessonKatas {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
    */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lesson", inversedBy="kata")
     * @ORM\JoinColumn(nullable=false)
     */
    private $lesson;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Kata", inversedBy="lesson")
     * @ORM\JoinColumn(nullable=false)
     */
    private $kata;
    /**
     * @ORM\Column(type="integer")
     */
    private $position;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getLesson()
    {
        return $this->lesson;
    }

    /**
     * @param mixed $lesson
     */
    public function setLesson($lesson): void
    {
        $this->lesson = $lesson;
    }

    /**
     * @return mixed
     */
    public function getKata()
    {
        return $this->kata;
    }

    /**
     * @param mixed $kata
     */
    public function setKata($kata): void
    {
        $this->kata = $kata;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position): void
    {
        $this->position = $position;
    }

}