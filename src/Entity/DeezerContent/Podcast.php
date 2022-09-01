<?php

namespace App\Entity\DeezerContent;

use App\Entity\NotifiableContent;
use App\Repository\DeezerContent\PodcastRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PodcastRepository::class)]
class Podcast extends NotifiableContent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $artist = null;

    #[ORM\Column(length: 2048)]
    private ?string $cover = null;

    #[ORM\Column(length: 2048)]
    private ?string $link = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getArtist(): string
    {
        return $this->artist;
    }

    public function setArtist(string $artist): self
    {
        $this->artist = $artist;

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(string $cover): self
    {
        $this->cover = $cover;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getNotificationImage(): string
    {
        return $this->cover;
    }

    public function getNotificationLink(): string
    {
        return $this->link;
    }

    public function getContentType(): string
    {
        return 'podcast';
    }
}
