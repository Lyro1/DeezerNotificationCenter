<?php

namespace App\Projection;

use App\Entity\NotifiableContent;

class NotificationContentProjection {
    public string $title;
    public string $artist;
    public string $image;
    public string $link;
    public string $type;

    public static function fromContent(NotifiableContent $content): NotificationContentProjection {
        $projection = new NotificationContentProjection();
        $projection->title = $content->getTitle();
        $projection->artist = $content->getArtist();
        $projection->image = $content->getNotificationImage();
        $projection->link = $content->getNotificationLink();
        $projection->type = $content->getContentType();
        return $projection;
    }
}
