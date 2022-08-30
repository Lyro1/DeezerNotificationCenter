<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotificationController extends AppController
{
    #[Route('/notifications', name: 'notification')]
    public function getNotifications(): Response
    {
        return $this->ok();
    }
}
