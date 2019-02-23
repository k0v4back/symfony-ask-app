<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Orm\Table("`user`")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields="email", message="Такой email уже существует")
 * @UniqueEntity(fields="nick", message="Такой ник уже существует")
 */
class User implements UserInterface, \Serializable
{
    const ROLE_USER = 'ROLE_USER';
    const ROLE_ADMIN = 'ROLE_ADMIN';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\Length(min=2, max=100)
     */
    private $fullName;

    /**
     * @ORM\Column(type="string", length=50, unique=true, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(min=1, max=50)
     */
    private $nick;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     * @Assert\Length(min=5, max=100)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     * @Assert\Length(min=5, max=100)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $sex;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $age;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="following")
     */
    private $followers;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="followers")
     * @ORM\JoinTable(name="following",
     *     joinColumns={
     *      @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *      @ORM\JoinColumn(name="following_user_id", referencedColumnName="id")
     *     }
     *  )
     */
    private $following;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $confirmToken;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $lastActivity;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank()
     */
    private $roles;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @param mixed $fullName
     */
    public function setFullName($fullName): void
    {
        $this->fullName = $fullName;
    }

    /**
     * @return mixed
     */
    public function getNick()
    {
        return $this->nick;
    }

    /**
     * @param mixed $nick
     */
    public function setNick($nick): void
    {
        $this->nick = $nick;
    }

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(string $sex): self
    {
        $this->sex = $sex;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param mixed $age
     */
    public function setAge($age): void
    {
        $this->age = $age;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country): void
    {
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param mixed $avatar
     */
    public function setAvatar($avatar): void
    {
        $this->avatar = $avatar;
    }

    /**
     * @return mixed
     */
    public function getFollowers()
    {
        return $this->followers;
    }

    /**
     * @param mixed $followers
     */
    public function setFollowers($followers): void
    {
        $this->followers = $followers;
    }

    /**
     * @return mixed
     */
    public function getFollowing()
    {
        return $this->following;
    }

    /**
     * @param mixed $following
     */
    public function setFollowing($following): void
    {
        $this->following = $following;
    }


    public function __construct()
    {
        $this->roles = self::ROLE_USER;
        $this->nick = null;
        $this->followers = new ArrayCollection();
        $this->following = new ArrayCollection();
        $this->status = false;
    }

    public function getRoles()
    {
        return array($this->roles);
    }

    /**
     * @param string $roles
     */
    public function setRoles($roles): void
    {
        $this->roles = $roles;
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->getNick();
    }

    /**
     * @return mixed
     */
    public function getConfirmToken()
    {
        return $this->confirmToken;
    }

    /**
     * @param mixed $confirmToken
     */
    public function setConfirmToken($confirmToken): void
    {
        $this->confirmToken = $confirmToken;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getLastActivity()
    {
        return $this->lastActivity;
    }

    /**
     * @param mixed $lastActivity
     */
    public function setLastActivity($lastActivity): void
    {
        $this->lastActivity = $lastActivity;
    }

    public function eraseCredentials()
    {
        return;
    }


    public function serialize()
    {
        return serialize([
            $this->id,
            $this->nick,
            $this->password,
            $this->status
        ]);
    }

    public function unserialize($serialized)
    {
        list($this->id,
            $this->nick,
            $this->password,
            $this->status) = unserialize($serialized);
    }
}
