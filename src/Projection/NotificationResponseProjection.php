<?php

namespace App\Projection;

use Doctrine\Common\Collections\Collection;

class NotificationResponseProjection {
    public int $numberOfNotifications;
    public int $numberOfUnreadNotifications;
    public Collection $notifications;

    public static function fromNotifications(int $numberOfNotifications,
                                             int $numberOfUnReadNotifications,
                                             Collection $notifications): NotificationResponseProjection {
        $projection = new NotificationResponseProjection();
        $projection->numberOfNotifications = $numberOfNotifications;
        $projection->numberOfUnreadNotifications = $numberOfUnReadNotifications;
        $projection->notifications = $notifications;
        return $projection;
    }
}
