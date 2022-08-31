<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorColumn('disc', 'string')]
#[ORM\DiscriminatorMap(['notifiablecontent' => 'NotifiableContent', 'track' => 'App\Entity\DeezerContent\Track'])]
abstract class NotifiableContent {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Returns the URL of the image that will appear in the notification
     * @return string the URL of the image to display
     **/
    public abstract function getNotificationImage(): string;

    /**
     * Returns the URL on which the user will be redirected when clicking the notification.
     * @return string the URL to redirect
     **/
    public abstract function getNotificationLink(): string;

    /**
     * Returns the type of the content
     * @return string the type of the content
     **/
    public abstract function getContentType(): string;
}
