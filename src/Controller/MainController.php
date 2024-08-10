<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/')]
    public function homepage(): Response
    {
        $testarray = [
            [
                'name' => 'pera',
                'prezime' => 'peric'
            ],
            [
                'name' => 'zika',
                'prezime' => 'zikic'
            ]
        ];
        return $this->json($testarray);
    }
}
