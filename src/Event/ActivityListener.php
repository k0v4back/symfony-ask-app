<?php

namespace App\Event;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\HttpKernel;
use App\Entity\User;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Firewall\ContextListener;

class ActivityListener
{
    private $em;
    private $security;

    public function __construct(EntityManagerInterface $em, Security $security)
    {
        $this->em = $em;
        $this->security = $security;
    }

    public function onCoreController(FilterControllerEvent $event)
    {
        if ($event->getRequestType() !== HttpKernel::MASTER_REQUEST) {
            return;
        }

        if ($this->security->getToken()) {
            $user = $this->security->getToken()->getUser();

            $delay = time() + 120;

            if ($user instanceof User && $user->getLastActivity() < $delay) {
                $user->setLastActivity($delay);
                $this->em->flush($user);
            }
        }
    }
}