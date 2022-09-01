<?php

namespace App\Controller;

use App\Projection\NotificationProjection;
use App\Projection\NotificationResponseProjection;
use Exception;
use App\Service\NotificationService;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotificationController extends AppController
{

    private NotificationService $notificationService;

    public function __construct(SerializerInterface $serializer,
                                NotificationService $notificationService)
    {
        parent::__construct($serializer);
        $this->notificationService = $notificationService;
    }

    #[Route('/notifications/{userId}', name: 'notification', methods: ['GET'])]
    public function getNotifications(Request $request, int $userId): Response
    {
        try {
            $page = $request->query->get('page') ? $request->query->get('page') : 1;
            $notifications = $this->notificationService->getNotificationsForUser($userId, $page);
            return $this->ok(NotificationResponseProjection::fromNotifications(
                $this->notificationService->getNumberOfNotificationsForUser($userId),
                $this->notificationService->getNumberOfUnreadNotificationsForUser($userId),
                NotificationProjection::fromNotifications($notifications)));
        }
        catch(Exception $err) {
            return $this->internalServerError($err->getMessage());
        }

    }

    #[Route('/notifications/{userId}/read/{notificationId}')]
    public function setNotificationAsRead(Request $request, int $userId, int $notificationId): Response {
        try {
            if ($this->notificationService->markNotificationAsReadByUser($userId, $notificationId)) {
                return $this->ok();
            }
            return $this->notFound('Could not mark the notification as read.');

        }
        catch(Exception $err) {
            return $this->internalServerError($err->getMessage());
        }
    }
}
