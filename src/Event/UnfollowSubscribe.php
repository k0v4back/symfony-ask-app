<?php

namespace App\Event;

use App\Entity\Notification;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UnfollowSubscribe implements EventSubscriberInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getSubscribedEvents()
    {
        return [
            UnfollowEvent::NAME => 'unfollowOnUser'
        ];
    }

    public function unfollowOnUser(UnfollowEvent $event)
    {
        $user = $event->getUser();

        $notification = new Notification();
        $notification->setUser($user);
        $notification->setSeen(false);

        $this->entityManager->persist($notification);
        $this->entityManager->flush();
    }

}