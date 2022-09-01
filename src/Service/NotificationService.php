<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\UserNotification;
use App\Repository\UserNotificationRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use DateTime;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

class NotificationService {

    private static int $PAGE_SIZE = 20;
    private ManagerRegistry $doctrine;
    private UserRepository $userRepository;
    private UserNotificationRepository $userNotificationRepository;

    public function __construct(ManagerRegistry $doctrine,
                                UserRepository $userRepository,
                                UserNotificationRepository $userNotificationRepository) {
        $this->doctrine = $doctrine;
        $this->userRepository = $userRepository;
        $this->userNotificationRepository = $userNotificationRepository;
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
        $notifications = $this->getFilteredNotificationsForUser($user);
        $offset = $this::$PAGE_SIZE * $pageNumber < count($notifications) ? $this::$PAGE_SIZE * ($pageNumber - 1) : 0;
        return new ArrayCollection($notifications->slice($offset, $this::$PAGE_SIZE));
    }

    /**
     * Get filtered notifications for user
     * @param User $user the user to retrieve notifications for
     * @return Collection the list of notifications
     */
    private function getFilteredNotificationsForUser(User $user): Collection {
        return $user->getUserNotifications()->filter(function($userNotification) {
            return !$userNotification->getNotification()->getExpirationDate() ||
                $userNotification->getNotification()->getExpirationDate() > new DateTime();
        });
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
        $notifications = $this->getFilteredNotificationsForUser($user);
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

    /**
     * Set the notification with given id to read by user with given id
     * @param int $notificationId the notification id
     * @param int $userId the user id
     * @return bool true if the notification has been marked as read, false otherwise
     * @throws Exception
     */
    public function markNotificationAsReadByUser(int $notificationId, int $userId): bool {
        $user = $this->userRepository->findOneBy(['id' => $userId]);
        if (!$user) {
            throw new Exception("User with id ". $userId ." does not exist");
        }
        try {
            $userNotification = $this->getUserNotificationForUserAndNotification($notificationId, $user);
            $userNotification->setReadStatus(true);
            $this->userNotificationRepository->add($userNotification);
            $this->doctrine->getManager()->flush();
            return true;
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * Get the UserNotification with the correct userid and notificationid
     * @param int $notificationId the notification id
     * @param User $user the user
     * @throws Exception
     */
    private function getUserNotificationForUserAndNotification(int $notificationId, User $user): UserNotification {
        $userNotifications = $this->getFilteredNotificationsForUser($user);
        $userNotifications->filter(function($userNotification) use ($notificationId) {
            return $userNotification->getNotification()->getId() === $notificationId;
        });
        if (count($userNotifications) != 1) {
            throw new Exception("Could not find a valid entry of UserNotification");
        }
        return $userNotifications->first();
    }
}
