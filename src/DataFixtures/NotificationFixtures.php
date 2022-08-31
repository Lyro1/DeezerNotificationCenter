<?php

namespace App\DataFixtures;

use App\Entity\NotifiableContent;
use App\Entity\UserNotification;
use App\Repository\DeezerContent\TrackRepository;
use App\Repository\UserNotificationRepository;
use DateTime;
use App\Entity\User;
use App\Entity\Notification;
use App\Entity\NotificationType;
use App\Repository\UserRepository;
use App\Repository\NotificationRepository;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class NotificationFixtures extends AppFixtures implements DependentFixtureInterface {

    private UserRepository $userRepository;
    private UserNotificationRepository $userNotificationRepository;
    private NotificationRepository $notificationRepository;
    private TrackRepository $trackRepository;

    public function __construct(UserRepository $userRepository,
                                UserNotificationRepository $userNotificationRepository,
                                NotificationRepository $notificationRepository,
                                TrackRepository $trackRepository
    ) {
        $this->userRepository = $userRepository;
        $this->userNotificationRepository = $userNotificationRepository;
        $this->notificationRepository = $notificationRepository;
        $this->trackRepository = $trackRepository;
    }

    public function load(ObjectManager $manager): void {
        ini_set('memory_limit','512M');
        for ($i = 0; $i < 1; $i++) {
            $notification = $this->createNotification(
                $manager,
                NotificationType::new,
                null,
                $this->trackRepository->findOneBy(['name' => 'Love You Back']),
                DateTime::createFromFormat('Y-m-d H:i:s', '2022-07-29 15:16:17'),
                null,
                "Découvrez le nouveau single de Madeon, le petit prince de l'électro 👑",
                $this->userRepository->findAll()
            );
            $manager->persist($notification);
            $this->notificationRepository->add($notification);
        }
        $notification = $this->createNotification(
            $manager,
            NotificationType::new,
            null,
            $this->trackRepository->findOneBy(['name' => 'Love You Back']),
            DateTime::createFromFormat('Y-m-d H:i:s', '2022-07-29 15:16:17'),
            DateTime::createFromFormat('Y-m-d H:i:s', '2022-07-30 15:16:17'),
            "Découvrez le nouveau single de Madeon, le petit prince de l'électro 👑",
            $this->userRepository->findAll()
        );
        $manager->persist($notification);
        $this->notificationRepository->add($notification);
        $manager->flush();

    }

    private function createNotification(ObjectManager $manager,
                                        NotificationType $type,
                                        ?User $author,
                                        NotifiableContent $content,
                                        DateTime $emissionDate,
                                        ?DateTime $expirationDate,
                                        ?string $description,
                                        array $recipients): Notification {
        $notification = new Notification();
        $notification->setType($type->value);
        $notification->setAuthor($author);
        $notification->setContent($content);
        $notification->setEmissionDate($emissionDate);
        $notification->setExpirationDate($expirationDate);
        $notification->setDescription($description);
        foreach($recipients as $recipient) {
            $userNotification = $this->createUserNotification($notification, $recipient);
            $notification->addUserNotification($userNotification);
            $manager->persist($userNotification);
            $this->userNotificationRepository->add($userNotification);
        }
        return $notification;
    }

    private function createUserNotification(Notification $notification, User $recipient): UserNotification {
        $userNotification = new UserNotification();
        $userNotification->setUser($recipient);
        $userNotification->setNotification($notification);
        $userNotification->setReadStatus(false);
        return $userNotification;
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class
        ];
    }
}
