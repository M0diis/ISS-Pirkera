<?php

namespace App\Controller;

use mysqli;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatistikosController extends AbstractController
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
     * @Route("/statistikos", methods={"POST"})
     */
    public function ieskoti(Request $request): Response
    {
        $pradzia = $request->request->get("data");
        $pabaiga = $request->request->get("gdata");

        $error = "";
        $msg = "";

        if (empty($pradzia) || empty($pabaiga))
        {
            $error = "Įveskite termino datą!";
        }
        else
        {
            $msg = "Rodoma pagal terminą";
        }
        return $this->redirect("/statistikos?msg=" . $msg. "&error=" . $error . "&data=" . $pradzia . "&gdata=" . $pabaiga);
    }

    #[Route('/statistikos', name: 'statistikos')]
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

        $most = array();

        $prekes = [];
        $query = "SELECT * FROM prekes";
        $res = $this->conn->query($query);

        while ($row = $res->fetch_assoc()) {
            $prekes[] = $row;
            $most[$row["barkodas"]] = 0;
        }

        $query = "SELECT * FROM uzsakymo_prekes";
        $res = $this->conn->query($query);
        if (empty($_GET['data']) && empty($_GET['gdata']))
        {
            # Nenurodyta data
            while ($row = $res->fetch_assoc()) {
                $prekesId = $row["fk_Prekebarkodas"];
                $uzsakymoId = $row["fk_Uzsakymasuzsakymo_numeris"];

                $most[$prekesId] += 1;
            }
        }
        else
        {
            # Nurodytas terminas
            $pradzia = $_GET['data'];
            $pabaiga = $_GET['gdata'];
            while ($row = $res->fetch_assoc()) {
                $prekesId = $row["fk_Prekebarkodas"];
                $uzsakymoId = $row["fk_Uzsakymasuzsakymo_numeris"];

                $q = "SELECT * FROM uzsakymai WHERE uzsakymo_numeris=$uzsakymoId";
                $r = $this->conn->query($q);

                $data = $r->fetch_assoc()["ivykdymo_data"];
                
                if ($data > $pradzia && $data < $pabaiga)
                {
                    $most[$prekesId] += 1;
                }
            }
        }

        $maxid = 0;
        $m = 0;
        foreach($most as $id => $count)
        {
            if ($count > $m)
            {
                $m = $count;
                $maxid = $id;
            }
        }

        $query = "SELECT * FROM sandelio_uzsakymo_prekes WHERE fk_Prekebarkodas=$maxid";
        $res = $this->conn->query($query);

        $udata = "";
        $sid = 0;
        $rusis = "";
        $pav = "";
        $tel = "";
        while ($row = $res->fetch_assoc()) {
            $uzs = $row["fk_Sandelio_uzsakymasnumeris"];
            $q = "SELECT * FROM sandelio_uzsakymai WHERE numeris=$uzs";
            $r = $this->conn->query($q);

            while ($ro = $r->fetch_assoc()) {
                $udata = $ro["uzsakymo_data"];
                break;
            }
        }

        $query = "SELECT * FROM prekes_rusys WHERE fk_Prekebarkodas=$maxid";
        $res = $this->conn->query($query);
        while ($row = $res->fetch_assoc()) {
            $rusis = $row["pavadinimas"];
        }

        $query = "SELECT * FROM prekes WHERE barkodas=$maxid";
        $res = $this->conn->query($query);
        while ($row = $res->fetch_assoc()) {
            $pav = $row["pavadinimas"];
            $sid = $row["fk_Sandelisid_Sandelis"];
        }

        $query = "SELECT * FROM sandeliai WHERE id_Sandelis=$sid";
        $res = $this->conn->query($query);
        while ($row = $res->fetch_assoc()) {
            $tel = $row["kontaktinis_telefonas"];
        }

        return $this->render('statistikos/index.html.twig', [
            'controller_name' => 'StatistikosController',
            'msg' => $msg,
            'error' => $error,
            'prekes' => $prekes,
            'most' => $most,
            'rusis' => $rusis,
            'pav' => $pav,
            'sid' => $sid,
            'tel' => $tel,
            'uzsakymoData' => $udata,
            'maxid' => $maxid,
        ]);
    }
}
