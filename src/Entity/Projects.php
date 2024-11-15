<?php

namespace App\Entity;

use App\Repository\ProjectsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProjectsRepository::class)]
class Projects
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['projects:read', 'user_project_hours:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['projects:read', 'user_project_hours:read'])]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(['projects:read', 'user_project_hours:read'])]
    private ?\DateTimeImmutable $startedAt = null;



    #[ORM\OneToMany(mappedBy: 'project', targetEntity: UserProjectHours::class, orphanRemoval: true)]
    private Collection $userProjectHours;

    public function __construct()
    {
        $this->userProjectHours = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getStartedAt(): ?\DateTimeImmutable
    {
        return $this->startedAt;
    }

    public function setStartedAt(\DateTimeImmutable $startedAt): static
    {
        $this->startedAt = $startedAt;
        return $this;
    }





    /**
     * @return Collection<int, UserProjectHours>
     */
    public function getUserProjectHours(): Collection
    {
        return $this->userProjectHours;
    }

    public function addUserProjectHours(UserProjectHours $userProjectHours): static
    {
        if (!$this->userProjectHours->contains($userProjectHours)) {
            $this->userProjectHours->add($userProjectHours);
            $userProjectHours->setProject($this);
        }
        return $this;
    }

    public function removeUserProjectHours(UserProjectHours $userProjectHours): static
    {
        if ($this->userProjectHours->removeElement($userProjectHours)) {
            // set the owning side to null (unless already changed)
            if ($userProjectHours->getProject() === $this) {
                $userProjectHours->setProject(null);
            }
        }
        return $this;
    }
}
