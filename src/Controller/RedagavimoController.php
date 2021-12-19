<?php

namespace App\Controller;

use mysqli;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RedagavimoController extends AbstractController
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
     * @Route("/item/edit/{name}/{id}", methods={"GET", "HEAD"})
     */
    public function edit($name, $id) : Response {
        return $this->redirect("/atlyginimo?name=" . $name. "&id=" . $id);
    }
        /**
     * @Route("/item/delete/{name}/{id}", methods={"GET", "HEAD"})
     */
    public function remove($name, $id) : Response {
        $query = "DELETE FROM buhalteriai WHERE id_Naudotojas=$id AND vartotojo_vardas='$name'";
        $this->conn->query($query);
        $query = "DELETE FROM pardavejai WHERE id_Naudotojas=$id AND vartotojo_vardas='$name'";
        $this->conn->query($query);
        $query = "DELETE FROM sandelininkai WHERE id_Naudotojas=$id AND vartotojo_vardas='$name'";
        $this->conn->query($query);

        $msg = "Sėkmingai atleistas darbuotojas!";
        $error = "";
        return $this->redirect("/redagavimo?msg=" . $msg. "&error=" . $error);
    }

    #[Route('/redagavimo', name: 'redagavimo')]
    public function getDarbuotojai() : Response {

        if (empty($_GET['msg']) && empty($_GET['error']))
        {
            $msg = "";
            $error = "";
        }
        else
        {
            $msg = $_GET['msg'];
            $error = $_GET['error'];
        }

        $results = array();
        $query = "SELECT id_Naudotojas, vardas, pavarde, vartotojo_vardas, banko_saskaita, darbo_laikas, virsvalandziu_skaicius, atlyginimas FROM buhalteriai";
        $res = $this->conn->query($query);

        while ($row = $res->fetch_assoc()) {
            $results[] = $row;
        }

        $query = "SELECT id_Naudotojas, vardas, pavarde, vartotojo_vardas, banko_saskaita, darbo_laikas, virsvalandziu_skaicius, atlyginimas FROM pardavejai";
        $res = $this->conn->query($query);

        while ($row = $res->fetch_assoc()) {
            $results[] = $row;
        }

        $query = "SELECT id_Naudotojas, vardas, pavarde, vartotojo_vardas, banko_saskaita, darbo_laikas, virsvalandziu_skaicius, atlyginimas FROM sandelininkai";
        $res = $this->conn->query($query);

        while ($row = $res->fetch_assoc()) {
            $results[] = $row;
        }

        return $this->render('redagavimo/index.html.twig', [
            'darbuotojai' => $results,
            'msg' => $msg,
            'error' => $error,
        ]);
    }
}
