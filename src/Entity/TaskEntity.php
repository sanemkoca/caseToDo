<?php

namespace App\Entity;

use App\Repository\TaskEntityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'task')]
#[ORM\Entity(repositoryClass: TaskEntityRepository::class)]
class TaskEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id', type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(name: 'title', length: 255)]
    private ?string $title = null;

    #[ORM\Column(name: 'duration', type: 'integer')]
    private ?int $duration = null;

    #[ORM\Column(name: 'difficulty', type: 'integer')]
    private ?int $difficulty = null;

    #[ORM\ManyToOne(inversedBy: 'taskEntities')]
    #[ORM\JoinColumn(name: "developer_id", referencedColumnName: "id", nullable: true)]
    private ?DeveloperEntity $developer = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getDifficulty(): ?int
    {
        return $this->difficulty;
    }

    public function setDifficulty(int $difficulty): static
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    public function getDeveloper(): ?DeveloperEntity
    {
        return $this->developer;
    }

    public function setDeveloper(?DeveloperEntity $developer): static
    {
        $this->developer = $developer;

        return $this;
    }
}
