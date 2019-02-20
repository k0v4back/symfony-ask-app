<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NotificationRepository")
 */
class Notification
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $user;

    /**
     * @ORM\Column(type="boolean")
     */
    private $seen;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $creator;

    /**
     * @ORM\Column(type="integer", length=5, nullable=true)
     */
    private $count;

    /**
     * @ORM\Column(type="integer", length=11, nullable=true)
     */
    private $time;

    public function __construct()
    {
        $this->seen = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSeen(): ?bool
    {
        return $this->seen;
    }

    public function setSeen(bool $seen): self
    {
        $this->seen = $seen;

        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user): void
    {
        $this->user = $user;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($text): void
    {
        $this->text = $text;
    }

    public function getCreator()
    {
        return $this->creator;
    }

    public function setCreator($creator): void
    {
        $this->creator = $creator;
    }

    public function getCount()
    {
        return $this->count;
    }

    public function setCount($count): void
    {
        $this->count = $count;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function setTime($time): void
    {
        $this->time = $time;
    }
}
