<?php

namespace App\Projection;

use App\Entity\Notification;
use App\Entity\NotificationType;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class NotificationProjection {

    public int $id;
    public string $type;
    public NotificationContentProjection $content;
    public DateTimeInterface $emissionDate;
    public ?NotificationAuthorProjection $author;
    public ?string $description;
    public bool $readStatus;

    public static function fromNotification(Notification $notification, bool $readStatus): NotificationProjection {
        $notificationProjection = new NotificationProjection();
        $notificationProjection->id = $notification->getId();
        $notificationProjection->type = NotificationType::from($notification->getType())->name;
        $notificationProjection->content = NotificationContentProjection::fromContent($notification->getContent());
        $notificationProjection->emissionDate = $notification->getEmissionDate();
        $notificationProjection->author = $notification->getAuthor() ? NotificationAuthorProjection::fromAuthor($notification->getAuthor()) : null;
        $notificationProjection->description = $notification->getDescription();
        $notificationProjection->readStatus = $readStatus;
        return $notificationProjection;
    }

    public static function fromNotifications(Collection $notifications): Collection {
        $notificationsProjection = new ArrayCollection();
        foreach($notifications as $notification) {
            $notificationsProjection->add(NotificationProjection::fromNotification(
                $notification->getNotification(),
                $notification->getReadStatus()));
        }
        return $notificationsProjection;
    }

}
