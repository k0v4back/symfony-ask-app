<?php

namespace App\Event;

use App\Entity\Notification;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class FollowSubscriber implements EventSubscriberInterface
{
    private $entityManager;
    private $currentUser;
    private $userRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        AuthenticationUtils $currentUser,
        UserRepository $userRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->currentUser = $currentUser;
        $this->userRepository = $userRepository;
    }

    public static function getSubscribedEvents()
    {
        return [
            FollowEvent::NAME => 'followOnUser'
        ];
    }

    public function followOnUser(FollowEvent $event)
    {
        $user = $event->getUser();

        $userId = $this->userRepository->findOneBy([
            'email' => $this->currentUser->getLastUsername()
        ]);

        $notification = new Notification();
        $notification->setUser($user);
        $notification->setSeen(false);
        $notification->setText('Пользователь '. $userId->getNick() .' подписался на вас');
        $notification->setCreator($userId);

        $this->entityManager->persist($notification);
        $this->entityManager->flush();
    }

}