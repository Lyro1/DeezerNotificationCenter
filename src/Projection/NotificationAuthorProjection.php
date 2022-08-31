<?php

namespace App\Projection;

use App\Entity\User;

class NotificationAuthorProjection {
    public int $id;
    public string $firstname;
    public string $lastname;

    public static function fromAuthor(User $author): NotificationAuthorProjection {
        $authorProjection = new NotificationAuthorProjection();
        $authorProjection->id = $author->getId();
        $authorProjection->firstname = $author->getFirstname();
        $authorProjection->lastname = $author->getLastname();
        return $authorProjection;
    }
}
