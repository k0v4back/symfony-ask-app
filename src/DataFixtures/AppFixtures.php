<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private const USERS = [
        [
            'full_name' => 'Косолапов Вадим',
            'nick' => 'k0v4',
            'email' => 'vadkos33@outlook.com',
            'password' => '111111',
            'sex' => 'male',
            'age' => '17',
            'country' => 'Russia',
            'city' => 'Kaliningrad',
            'avatar' => 'default.jpg',
            'confirm_token' => 12121212,
            'role' => User::ROLE_ADMIN
        ]

    ];


    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager)
    {
        $this->addUsers($manager);
    }

    public function addUsers(ObjectManager $manager)
    {
        foreach (self::USERS as $userData){
            $user = new User();

            $user->setFullName($userData['full_name']);
            $user->setNick($userData['nick']);
            $user->setEmail($userData['email']);
            $user->setPassword($this->encoder->encodePassword($user, $userData['password']));
            $user->setSex($userData['sex']);
            $user->setAge($userData['age']);
            $user->setCountry($userData['country']);
            $user->setCity($userData['city']);
            $user->setConfirmToken($userData['confirm_token']);
            $user->setRoles($userData['role']);

            $manager->persist($user);
        }
        $manager->flush();
    }
}