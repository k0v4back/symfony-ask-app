<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionsRepository")
 */
class Questions
{
    const NOT_ANSWERED = 0;
    const ANSWERED = 1;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $who_asked;

    /**
     * @ORM\Column(type="integer")
     */
    private $to_asked;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     * @Assert\Length(min=10, max=500)
     */
    private $text;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $time;

    /**
     * @ORM\Column(type="integer")
     */
    private $status = self::NOT_ANSWERED;

    /**
     * @ORM\Column(type="boolean")
     */
    private $anon;


    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Answer")
     * @ORM\JoinColumn(name="question_text_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $answer;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getWhoAsked()
    {
        return $this->who_asked;
    }

    /**
     * @param mixed $who_asked
     */
    public function setWhoAsked($who_asked): void
    {
        $this->who_asked = $who_asked;
    }

    public function getToAsked()
    {
        return $this->to_asked;
    }

    public function setToAsked($to_asked): void
    {
        $this->to_asked = $to_asked;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($text): void
    {
        $this->text = $text;
    }

    public function getTime(): ?string
    {
        return $this->time;
    }

    public function setTime(string $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getAnon(): ?bool
    {
        return $this->anon;
    }

    public function setAnon(bool $anon): self
    {
        $this->anon = $anon;

        return $this;
    }
}
