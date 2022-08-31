<?php

namespace App\DataFixtures;

use App\Entity\NotifiableContent;
use App\Repository\DeezerContent\TrackRepository;
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
    private NotificationRepository $notificationRepository;
    private TrackRepository $trackRepository;

    public function __construct(UserRepository $userRepository,
                                NotificationRepository $notificationRepository,
                                TrackRepository $trackRepository
    ) {
        $this->userRepository = $userRepository;
        $this->notificationRepository = $notificationRepository;
        $this->trackRepository = $trackRepository;
    }

    public function load(ObjectManager $manager): void {
        ini_set('memory_limit','512M');
        for ($i = 0; $i < 10000; $i++) {
            $notification = $this->createNotification(
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
//        $notification = $this->createNotification(
//            NotificationType::shared_content,
//            $this->userRepository->findOneBy(['lastname' => 'Hamilton']),
//            $this->trackRepository->findOneBy(['name' => 'Love You Back']),
//            DateTime::createFromFormat('Y-m-d H:i:s', '2022-08-31 12:16:00'),
//            DateTime::createFromFormat('Y-m-d H:i:s', '2022-09-07 15:16:17'),
//            null,
//            $this->userRepository->findBy(['lastname' => 'Vettel'])
//        );
//        $manager->persist($notification);
//        $this->notificationRepository->add($notification);
        $manager->flush();

    }

    private function createNotification(NotificationType $type,
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
            $notification->addRecipient($recipient);
        }
        return $notification;
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class
        ];
    }
}
