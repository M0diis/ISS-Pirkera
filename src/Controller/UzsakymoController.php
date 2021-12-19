<?php

namespace App\Controller;

use mysqli;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UzsakymoController extends AbstractController
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
     * @Route("/uzsakymo", methods={"POST"})
     */
    public function sukurti(Request $request): Response
    {
        $data = $request->request->get("data");
        $tdata = $request->request->get("tdata");
        $apimtis = $request->request->get("apimtis");
        $busena = $request->request->get("busenos");
        $sandelis = $request->request->get("sandeliai");
        $preke = $request->request->get("prekes");

        $vadovas = 1;
        $error = "";
        $msg = "";

        if (!empty($data) && !empty($tdata) && !empty($apimtis) && !empty($busena) && is_numeric($sandelis))
        {
            $query = "INSERT INTO sandelio_uzsakymai (uzsakymo_data, apimtis, terminas, busena, fk_Vadovasid_Naudotojas, fk_Sandelisid_Sandelis)
                    VALUES ('$data', '$apimtis', '$tdata', '$busena', '$vadovas', '$sandelis')";
            
            if ($this->conn->query($query))
            {
                $last_id = $this->conn->insert_id;

                $query = "INSERT INTO sandelio_uzsakymo_prekes (fk_Prekebarkodas, fk_Sandelio_uzsakymasnumeris)
                        VALUES ('$preke', '$last_id')";

                if ($this->conn->query($query))
                {
                    $msg = "Sandėlio užsakymas sėkmingai sukurtas!";
                }
                else
                {
                    $error = $this->conn->error;
                }
            }
            else
            {
                $error = $this->conn->error;
            } 
        }
        else
        {
            $error = "Trūksta duomenų!";
        }

        return $this->redirect("/uzsakymo?msg=" . $msg. "&error=" . $error);
    }

    #[Route('/uzsakymo', name: 'uzsakymo')]
    public function index(): Response
    {
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

        $q = "SELECT * FROM uzsakymo_busena";
        $res = $this->conn->query($q);
        $bus = [];
        while ($row = $res->fetch_assoc()) {
            $bus[] = $row;
        }

        $q = "SELECT * FROM sandeliai";
        $res = $this->conn->query($q);
        $san = [];
        while ($row = $res->fetch_assoc()) {
            $san[] = $row;
        }

        $q = "SELECT * FROM dydis";
        $res = $this->conn->query($q);
        $dyd = [];
        while ($row = $res->fetch_assoc()) {
            $dyd[] = $row;
        }

        $q = "SELECT * FROM prekes";
        $res = $this->conn->query($q);
        $prek = [];
        while ($row = $res->fetch_assoc()) {
            $prek[] = $row;
        }

        return $this->render('uzsakymo/index.html.twig', [
            'controller_name' => 'UzsakymoController',
            'busenos' => $bus,
            'sandeliai' => $san,
            'dydziai' => $dyd,
            'prekes' => $prek,
            'msg' => $msg,
            'error' => $error,
        ]);
    }
}
