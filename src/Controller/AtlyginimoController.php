<?php

namespace App\Controller;

use mysqli;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AtlyginimoController extends AbstractController
{
    private mysqli $conn;
    public function __construct()
    {
        $server = "localhost";
        $user = "root";
        $password = "";
        $database= "pirketa";

        $this->conn = new mysqli($server,$user,$password,$database);
    }

    /**
     * @Route("/atlyginimo", methods={"POST"})
     */
    public function pakeisti(Request $request): Response
    {
        $alga = $request->request->get("alga");
        $id = $request->request->get("id");
        $name = $request->request->get("name");

        $error = "";
        $msg = "";

        if (is_numeric($alga) && $alga > 0)
        {
            $query = "UPDATE buhalteriai SET atlyginimas=$alga WHERE id_Naudotojas=$id AND vartotojo_vardas='$name'";
            $this->conn->query($query);
            $query = "UPDATE pardavejai SET atlyginimas=$alga WHERE id_Naudotojas=$id AND vartotojo_vardas='$name'";
            $this->conn->query($query);
            $query = "UPDATE sandelininkai SET atlyginimas=$alga WHERE id_Naudotojas=$id AND vartotojo_vardas='$name'";
            $this->conn->query($query);

            $msg = "Atlyginimas sėkmingai pakeistas!";
        }
        else
        {
            $error = "Nurodykite tinkamą atlyginimą!";
        }

        return $this->redirect("/redagavimo?msg=" . $msg. "&error=" . $error);
    }
    #[Route('/atlyginimo', name: 'atlyginimo')]
    public function index(): Response
    {
        if (empty($_GET['name']) && empty($_GET['id']))
        {
            $name = "";
            $id = "";
            $error = "Vartotojas nerastas!";
        }
        else
        {
            $name = $_GET['name'];
            $id = $_GET['id'];
            $error = "";
        }

        return $this->render('atlyginimo/index.html.twig', [
            'controller_name' => 'AtlyginimoController',
            'name' => $name,
            'id' => $id,
            'error' => $error,
        ]);
    }
}
