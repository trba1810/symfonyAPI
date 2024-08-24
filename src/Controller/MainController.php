<?php

namespace App\Controller;

use App\Entity\Projects;
use App\Repository\ProjectsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use DateTimeImmutable;


class MainController extends AbstractController
{
    #[Route('/projects', name: 'projects')]
    public function projects(ProjectsRepository $projectsRepository): Response
    {
        $projects = $projectsRepository->findAll();

        return $this->json($projects);
    }

    #[Route('/projects/create', name: 'create_project', methods: ['GET', 'POST'])]
    public function createProject(EntityManagerInterface $entityManager): Response
    {
        $project = new Projects();
        $project->setName('Test1');
        $startedAt = new DateTimeImmutable();
        $project->setStartedAt($startedAt);
        $project->setTotalHours(3);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($project);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id ' . $project->getId());
    }
}
