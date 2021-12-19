<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VadovoController extends AbstractController
{
    #[Route('/vadovo', name: 'vadovo')]
    public function index(): Response
    {
        return $this->render('vadovo/index.html.twig', [
            'controller_name' => 'VadovoController',
        ]);
    }
}
