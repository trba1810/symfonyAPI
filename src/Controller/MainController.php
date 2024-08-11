<?php

namespace App\Controller;

use App\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/')]
    public function homepage(): Response
    {
        $testarray = [new Project(
            'projekat 1',
        ), new Project('projekat 2')];
        return $this->json($testarray);
    }
}
