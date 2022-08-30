<?php

namespace App\DataFixtures;

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

    public function __construct(UserRepository $userRepository,
                                NotificationRepository $notificationRepository) {
        $this->userRepository = $userRepository;
        $this->notificationRepository = $notificationRepository;
    }

    public function load(ObjectManager $manager): void {
        $user = $this->createNotification(
            NotificationType::new_single,
            null,
            DateTime::createFromFormat('Y-m-d H:i:s', '2022-07-29 15:16:17'),
            null,
            "Découvrez le nouveau single de Madeon, le petit prince de l'électro 👑",
            $this->userRepository->findAll()
        );
        $manager->persist($user);
        $this->notificationRepository->add($user);
        $user = $this->createNotification(
            NotificationType::shared_content,
            $this->userRepository->findOneBy(['lastname' => 'Hamilton']),
            DateTime::createFromFormat('Y-m-d H:i:s', '2022-08-31 12:16:00'),
            DateTime::createFromFormat('Y-m-d H:i:s', '2022-09-07 15:16:17'),
            null,
            $this->userRepository->findBy(['lastname' => 'Vettel'])
        );
        $manager->persist($user);
        $this->notificationRepository->add($user);
        $manager->flush();

    }

    private function createNotification(NotificationType $type,
                                        ?User $author,
                                        DateTime $emissionDate,
                                        ?DateTime $expirationDate,
                                        ?string $description,
                                        array $recipients): Notification {
        $notification = new Notification();
        $notification->setType($type->value);
        $notification->setAuthor($author);
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
