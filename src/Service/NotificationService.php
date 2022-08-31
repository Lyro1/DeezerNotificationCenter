<?php

namespace App\Service;

use Exception;
use DateTime;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

class NotificationService {

    private static int $PAGE_SIZE = 20;
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    /**
     * Retrieve notifications for a given user
     * @param int $userId the unique identifier of the user
     * @param int $pageNumber the page number - optional
     * @throws Exception
     */
    public function getNotificationsForUser(int $userId, int $pageNumber = 1): Collection {
        $user = $this->userRepository->findOneBy(['id' => $userId]);
        if (!$user) {
            throw new Exception("User with id ". $userId ." does not exist");
        }
        $notifications = $user->getUserNotifications()->filter(function($userNotification) {
            return !$userNotification->getNotification()->getExpirationDate() ||
                $userNotification->getNotification()->getExpirationDate() > new DateTime();
        });
        $offset = $this::$PAGE_SIZE * $pageNumber < count($notifications) ? $this::$PAGE_SIZE * ($pageNumber - 1) : 0;
        return new ArrayCollection($notifications->slice($offset, $this::$PAGE_SIZE));
    }

    /**
     * Returns the number of notification the user has received.
     * @param int $userId the unique identifier of the user
     * @return int the number of notification the user received.
     * @throws Exception
     */
    public function getNumberOfNotificationsForUser(int $userId): int {
        $user = $this->userRepository->findOneBy(['id' => $userId]);
        if (!$user) {
            throw new Exception("User with id ". $userId ." does not exist");
        }
        $notifications = $user->getUserNotifications()->filter(function($userNotification) {
            return !$userNotification->getNotification()->getExpirationDate() ||
                $userNotification->getNotification()->getExpirationDate() > new DateTime();
        });
        return count($notifications);
    }

    /**
     * Returns the number of unread notification the user has received.
     * @param int $userId the unique identifier of the user
     * @return int the number of unread notification the user received.
     * @throws Exception
     */
    public function getNumberOfUnreadNotificationsForUser(int $userId): int {
        return $this->getNumberOfNotificationsForUser($userId);
    }
}
