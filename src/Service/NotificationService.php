<?php

namespace App\Service;

use Exception;
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
        $notifications = $user->getNotifications();
        $offset = $this::$PAGE_SIZE * $pageNumber < count($notifications) ? $this::$PAGE_SIZE * ($pageNumber - 1) : 0;
        return new ArrayCollection($notifications->slice($offset, $this::$PAGE_SIZE));
    }
}
