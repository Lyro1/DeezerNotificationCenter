<?php

namespace App\Tests\Service;

use App\Entity\NotificationType;
use App\Service\NotificationService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class NotificationServiceTests extends KernelTestCase {

    public function testGetNotificationsForUser() {
        self::bootKernel();
        $container = NotificationServiceTests::getContainer();
        $notificationService = $container->get(NotificationService::class);
        $notifications = $notificationService->getNotificationsForUser(1);
        $this->assertNotEmpty($notifications);
        $this->assertCount(1, $notifications);
        $this->assertEquals(NotificationType::new_single->value, $notifications[0]->type);
        $this->assertEquals("Découvrez le nouveau single de Madeon, le petit prince de l'électro 👑", $notifications[0]->description);
    }

    public function testGetNotificationsForUserWithPage() {
        self::bootKernel();
        $container = NotificationServiceTests::getContainer();
        $notificationService = $container->get(NotificationService::class);
        $notifications = $notificationService->getNotificationsForUser(1, 1);
        $this->assertNotEmpty($notifications);
        $this->assertCount(1, $notifications);
        $this->assertEquals(NotificationType::new_single->value, $notifications[0]->type);
        $this->assertEquals("Découvrez le nouveau single de Madeon, le petit prince de l'électro 👑", $notifications[0]->description);
    }

}
