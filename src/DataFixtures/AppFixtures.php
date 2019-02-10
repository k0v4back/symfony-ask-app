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
            'name' => 'Test1 test1',
            'email' => 'test@1.com',
            'password' => '111111',
            'sex' => 'male',
            'age' => '10',
            'country' => 'Russia',
            'city' => 'Moscow',
            'role' => User::ROLE_USER
        ],
        [
            'name' => 'Test2 test2',
            'email' => 'test@2.com',
            'password' => '111111',
            'sex' => 'male',
            'age' => '31',
            'country' => 'Russia',
            'city' => 'Moscow',
            'role' => User::ROLE_USER
        ],
        [
            'name' => 'Test3 test3',
            'email' => 'test@3.com',
            'password' => 'test3',
            'sex' => 'woman',
            'age' => '52',
            'country' => 'Америка',
            'city' => 'Moscow',
            'role' => User::ROLE_USER
        ],
        [
            'name' => 'Test1 test1',
            'email' => 'test@1.com',
            'password' => 'test1',
            'sex' => 'woman',
            'age' => '50',
            'country' => 'Украина',
            'city' => 'Киев',
            'role' => User::ROLE_USER
        ],
        [
            'name' => 'Косолапов Вадим',
            'email' => 'vadkos33@outlook.com',
            'password' => '111111',
            'sex' => 'male',
            'age' => '17',
            'country' => 'Russia',
            'city' => 'Kaliningrad',
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

            $user->setName($userData['name']);
            $user->setEmail($userData['email']);
            $user->setPassword($this->encoder->encodePassword($user, $userData['password']));
            $user->setSex($userData['sex']);
            $user->setAge($userData['age']);
            $user->setCountry($userData['country']);
            $user->setCity($userData['city']);
            $user->setRole($userData['role']);

            $manager->persist($user);
        }
        $manager->flush();
    }
}