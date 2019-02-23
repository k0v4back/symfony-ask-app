<?php

namespace App\Event;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\HttpKernel;
use App\Entity\User;
use Symfony\Component\Security\Http\Firewall\ContextListener;

class ActivityListener
{
    protected $context;
    protected $em;

    public function __construct(ContextListener $context, EntityManager $manager)
    {
        $this->context = $context;
        $this->em = $manager;
    }

    public function onCoreController(FilterControllerEvent $event)
    {
        if ($event->getRequestType() !== HttpKernel::MASTER_REQUEST) {
            return;
        }

        if ($this->context->getToken()) {
            $user = $this->context->getToken()->getUser();

            $delay = time() + 120;

            if ($user instanceof User && $user->getLastActivity() < $delay) {
                $user->setLastActivity($delay);
                $this->em->flush($user);
            }
        }
    }
}