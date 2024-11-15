<?php

namespace App\Controller;


use App\Entity\UserProjectHours;
use App\Repository\UserProjectHoursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\UserRepository;
use App\Repository\ProjectsRepository;
use Symfony\Component\Serializer\SerializerInterface;




class WorkController extends AbstractController
{
//    #[Route('/api/work', name: 'work')]
//    public function work(UserProjectHoursRepository $userProjectHoursRepository): JsonResponse
//    {
//        $work = $userProjectHoursRepository->findAll();
//
//        return $this->json($work);
//
//    }

    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    #[Route('/api/work', name: 'work')]
    public function work(UserProjectHoursRepository $userProjectHoursRepository): JsonResponse
    {
        $work = $userProjectHoursRepository->findAll();

        // Serialize using the defined group
        $data = $this->serializer->serialize($work, 'json', ['groups' => ['user_project_hours:read']]);

        return new JsonResponse($data, 200, [], true); // Set true for JSON response
    }

    #[Route('/api/work/create', 'work_create', methods: ['POST'])]
    public function createWork(Request $request,UserRepository $userRepository,
                               ProjectsRepository $projectRepository,EntityManagerInterface $entityManager): Response
    {
        try {
            $content = $request->getContent();

            // Decode JSON content
            $data = json_decode($content, true);

            // Validate required fields
            if ( !isset($data['projectId']) ) {
                return new JsonResponse([
                    $data,
                    'error' => 'All fields (userId, projectId, hoursWorked, workDate) are required'
                ], 400);
            }

            // Find the User
            $user = $userRepository->find($data['userId']);
            if (!$user) {
                return new JsonResponse(['error' => 'User not found'], 404);
            }

            // Find the Project
            $project = $projectRepository->find($data['projectId']);
            if (!$project) {
                return new JsonResponse(['error' => 'Project not found'], 404);
            }

            // Create new UserProjectHours
            $work = new UserProjectHours();
            $work->setUser($user);
            $work->setProject($project);
            $work->setHoursWorked($data['hoursWorked']);
            $workDate = new \DateTimeImmutable($data['workDate']);
            $work->setWorkDate($workDate);

            $entityManager->persist($work);
            $entityManager->flush();

            return new JsonResponse([
                'id' => $work->getId(),
                'userId' => $user->getId(),
                'projectId' => $project->getId(),
                'hoursWorked' => $work->getHoursWorked(),
                'workDate' => $work->getWorkDate()->format('Y-m-d H:i:s')
            ], 201);

        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
    }
}
