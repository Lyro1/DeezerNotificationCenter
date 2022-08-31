<?php

namespace App\Entity;

use App\Repository\UserNotificationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserNotificationRepository::class)]
class UserNotification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'userNotifications')]
    #[ORM\JoinColumn('user', 'id')]
    private User $user;

    #[ORM\ManyToOne(targetEntity: Notification::class, inversedBy: 'userNotifications')]
    #[ORM\JoinColumn('notification', 'id')]
    private Notification $notification;

    #[ORM\Column]
    private ?bool $readStatus = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User {
        return $this->user;
    }

    public function setUser(User $user): self {
        $this->user = $user;

        return $this;
    }

    public function getNotification(): ?Notification {
        return  $this->notification;
    }

    public function setNotification(Notification $notification): self {
        $this->notification = $notification;

        return $this;
    }

    public function isReadStatus(): ?bool
    {
        return $this->readStatus;
    }

    public function setReadStatus(bool $readStatus): self
    {
        $this->readStatus = $readStatus;

        return $this;
    }
}
