<?php

namespace App\Controller;

use App\Entity\Projects;
use App\Repository\ProjectsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use DateTimeImmutable;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;




class MainController extends AbstractController
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }
    #[Route('/api/projects', name: 'projects')]
    public function projects(ProjectsRepository $projectsRepository): JsonResponse
    {
        $projects = $projectsRepository->findAll();

        // Serialize using the defined group
        $data = $this->serializer->serialize($projects, 'json', ['groups' => ['projects:read']]);

        return new JsonResponse($data, 200, [], true); // Set true for JSON response
    }

    #[Route('/api/projects/create', name: 'create_project', methods: ['GET', 'POST'])]
    #[isGranted('ROLE_USER')]
    public function createProject(Request $request,EntityManagerInterface $entityManager): Response
    {
        try {
            $data = json_decode($request->getContent(), false);

            if (empty($data->name)) {
                return new JsonResponse(['error' => 'Name is required'], 400);
            }

            $project = new Projects();
            $project->setName($data->name);
            $startedAt = new DateTimeImmutable($data->startedAt);
            $project->setStartedAt($startedAt);

            $entityManager->persist($project);
            $entityManager->flush();

            return new JsonResponse(['id' => $project->getId()], 201);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
    }

    #[Route('/api/projects/edit/{id}', name: 'edit_project')]
    public function editProject(EntityManagerInterface $entityManager, int $id): Response
    {
        $project = $entityManager->getRepository(Projects::class)->find($id);

        if (!$project) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }
        $project->setName('New product name!');
        $entityManager->flush();

        return $this->redirectToRoute('projects', [
            'id' => $project->getId()
        ]);
    }

    #[Route('/api/projects/delete/{id}', name: 'delete_project')]
    public function deleteProject(EntityManagerInterface $entityManager, int $id): Response{
        $project = $entityManager->getRepository(Projects::class)->find($id);
        if (!$project) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }
        $entityManager->remove($project);
        $entityManager->flush();
        return $this->redirectToRoute('projects', [
            'id' => $project->getId()
        ]);
    }


}
