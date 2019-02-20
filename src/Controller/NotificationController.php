<?php

namespace App\Controller;

use App\Entity\Notification;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        foreach ($listNotifications as $key => $notification){
            if ($notification->getCount() != null){
                $notification->setSeen(true);
                $em->flush();
            } else {
                $notification->setCount(1);
                $notification->setSeen(false);
                $em->flush();
            }

        }

        return $this->render(
            'notification/main-page-notification.html.twig',
            [
                'notifications' => $listNotifications
            ]
        );
    }


    /**
     * @Route("/unread-count", name="notification_unread")
     */
    public function unreadCount()
    {
        $em = $this->getDoctrine()->getManager();
        $unread_count = $em->getRepository(Notification::class)->findUnseenByUser($this->getUser());

        return new JsonResponse([
            'count' => $unread_count
        ]);
    }
}