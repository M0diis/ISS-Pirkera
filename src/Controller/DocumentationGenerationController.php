<?php

namespace App\Controller;

use mysqli;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DocumentationGenerationController extends AbstractController
{
    private RequestStack $requestStack;
    private mysqli $conn;

    public function __construct(RequestStack $requestStack)
    {
        $hostname = "localhost";
        $username = "root";
        $password = "";
        $database = "pirketa";

        $this->requestStack = $requestStack;

        $this->conn = new mysqli($hostname, $username, $password, $database);

        if ($this->conn->connect_error)
        {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    /**
     * @Route("/warehouse/documentation_gen", name="documentation_gen")
     */
    public function documentationGeneration(): Response
    {
        return $this->render('warehouse/documentation_gen.html.twig', [
            'controller_name' => 'DocumentationGenController',
        ]);
    }
}
