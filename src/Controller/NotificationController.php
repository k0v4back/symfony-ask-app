<?php

namespace App\Controller;

use App\Entity\Notification;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NotificationController extends AbstractController
{
    /**
     * @Security("is_granted('ROLE_USER')")
     * @Route("/notification/{nick}", name="main_notification_page")
     */
    public function mainNotification($nick)
    {
        $em = $this->getDoctrine()->getManager();
        $listNotifications = $em->getRepository(Notification::class)->findAllNotificationForUser($this->getUser());

        $em = $this->getDoctrine()->getManager();

        foreach ($listNotifications as $key => $notification){
            $notification->setSeen(true);
            $em->flush();
        }

        return $this->render(
            'notification/main-page-notification.html.twig',
            [
                'notifications' => $listNotifications
            ]
        );
    }
}