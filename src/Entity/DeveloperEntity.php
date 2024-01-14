<?php

namespace App\Entity;

use App\Repository\DeveloperEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'developer')]
#[ORM\Entity(repositoryClass: DeveloperEntityRepository::class)]
class DeveloperEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id', type: 'integer')]
    private int $id;

    #[ORM\Column(name: 'developer', type: 'string', length: 255)]
    private string $developer;

    #[ORM\Column(name: 'level', type: 'integer', length: 255)]
    private int $level;

    #[ORM\OneToMany(mappedBy: 'developer_id', targetEntity: TaskEntity::class)]
    private Collection $taskEntities;

    public function __construct()
    {
        $this->taskEntities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDeveloper(): ?string
    {
        return $this->developer;
    }

    public function setDeveloper(string $developer): self
    {
        $this->developer = $developer;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return Collection<int, TaskEntity>
     */
    public function getTaskEntities(): Collection
    {
        return $this->taskEntities;
    }

    public function addTaskEntity(TaskEntity $taskEntity): static
    {
        if (!$this->taskEntities->contains($taskEntity)) {
            $this->taskEntities->add($taskEntity);
            $taskEntity->setDeveloper($this);
        }

        return $this;
    }

    public function removeTaskEntity(TaskEntity $taskEntity): static
    {
        if ($this->taskEntities->removeElement($taskEntity)) {
            // set the owning side to null (unless already changed)
            if ($taskEntity->getDeveloper() === $this) {
                $taskEntity->setDeveloper(null);
            }
        }

        return $this;
    }

    public function taskEffort(TaskEntity $taskEntity): float
    {
        return ($taskEntity->getDuration() * $taskEntity->getDifficulty()) / $this->getLevel();
    }
}
