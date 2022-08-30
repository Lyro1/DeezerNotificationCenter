<?php

namespace App\Tests;

use App\Service\NotificationService;
use PHPUnit\Framework\TestCase;

final class NotificationServiceTests extends TestCase {

    private NotificationService $notificationService;

    public function __construct(?string $name = null,
                                array $data = [],
                                $dataName = '',
                                NotificationService $notificationService)
    {
        parent::__construct($name, $data, $dataName);
        $this->notificationService = $notificationService;
    }

    public function testGetNotificationsForUser() {
        $notifications = $this->notificationService->getNotificationsForUser(1);
        $this->assertNotEmpty($notifications);
    }

    public function testGetNotificationsForUserWithPage() {
        $notifications = $this->notificationService->getNotificationsForUser(1, 1);
        $this->assertNotEmpty($notifications);
    }

}
