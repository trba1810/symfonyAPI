<?php

namespace App\Entity;

use App\Repository\UserProjectHoursRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: UserProjectHoursRepository::class)]
class UserProjectHours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user_project_hours:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userProjectHours')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['user_project_hours:read'])]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'userProjectHours')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['user_project_hours:read'])]
    private ?Projects $project = null;

    #[ORM\Column]
    #[Groups(['user_project_hours:read'])]
    private ?int $hoursWorked = null;

    #[ORM\Column]
    #[Groups(['user_project_hours:read'])]
    private ?\DateTimeImmutable $workDate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }

    public function getProject(): ?Projects
    {
        return $this->project;
    }

    public function setProject(?Projects $project): static
    {
        $this->project = $project;
        return $this;
    }

    public function getHoursWorked(): ?int
    {
        return $this->hoursWorked;
    }

    public function setHoursWorked(int $hoursWorked): static
    {
        $this->hoursWorked = $hoursWorked;
        return $this;
    }

    public function getWorkDate(): ?\DateTimeImmutable
    {
        return $this->workDate;
    }

    public function setWorkDate(\DateTimeImmutable $workDate): static
    {
        $this->workDate = $workDate;
        return $this;
    }
}
