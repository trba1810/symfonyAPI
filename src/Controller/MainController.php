<?php

namespace App\Controller;

use App\Entity\Projects;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/')]
    public function homepage(): Response
    {
//        // Creating instances and storing them in an array
//        $array = [];
//
//// Assuming today's date for simplicity
//        $today = new \DateTimeImmutable();
//
//// Creating three projects
//        $project1 = new Projects();
//        $project1->setName('Project One');
//        $project1->setStartedAt($today);
//        $project1->setTotalHours(10);
//
//        $project2 = new Projects();
//        $project2->setName('Project Two');
//        $project2->setStartedAt($today);
//        $project2->setTotalHours(20);
//
//        $project3 = new Projects();
//        $project3->setName('Project Three');
//        $project3->setStartedAt($today);
//        $project3->setTotalHours(30);
//
//// Adding projects to the array
//        $array[] = $project1;
//        $array[] = $project2;
//        $array[] = $project3;
//
//// At this point, $array contains three instances of Projects
        return $this->json('$array');
    }
}
