<?php

namespace App\Entity;

use App\Repository\NotificationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotificationRepository::class)]
class Notification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $type = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $emissionDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $expirationDate = null;

    #[ORM\ManyToOne]
    private ?User $author = null;

    #[ORM\Column(length: 1024, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'notifications')]
    private Collection $recipients;

    public function __construct()
    {
        $this->recipients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getEmissionDate(): ?\DateTimeInterface
    {
        return $this->emissionDate;
    }

    public function setEmissionDate(\DateTimeInterface $emissionDate): self
    {
        $this->emissionDate = $emissionDate;

        return $this;
    }

    public function getExpirationDate(): ?\DateTimeInterface
    {
        return $this->expirationDate;
    }

    public function setExpirationDate(?\DateTimeInterface $expirationDate): self
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getRecipients(): Collection
    {
        return $this->recipients;
    }

    public function addRecipient(User $recipient): self
    {
        if (!$this->recipients->contains($recipient)) {
            $this->recipients->add($recipient);
            $recipient->addNotification($this);
        }

        return $this;
    }

    public function removeRecipient(User $recipient): self
    {
        if ($this->recipients->removeElement($recipient)) {
            $recipient->removeNotification($this);
        }

        return $this;
    }
}
