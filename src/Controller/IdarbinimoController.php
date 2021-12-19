<?php

namespace App\Controller;

use mysqli;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IdarbinimoController extends AbstractController
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
     * @Route("/idarbinimo", methods={"POST"})
     */
    public function kurti(Request $request): Response
    {
        $bvardas = $request->request->get("bvardas");
        $bpavarde = $request->request->get("bpavarde");
        $bvartotojas = $request->request->get("bvvardas");
        $bsaskaita = $request->request->get("bsaskaita");
        $blaikas = $request->request->get("blaikas");
        $bvirs = $request->request->get("bvirs");
        $batl = $request->request->get("batl");
        $ofisas = $request->request->get("ofisai");
        $pastas = $request->request->get("pastas");
        $nr = $request->request->get("nr");
        $knr = $request->request->get("knr");   

        $pvardas = $request->request->get("pvardas");
        $ppavarde = $request->request->get("ppavarde");
        $pvartotojas = $request->request->get("pvvardas");
        $psaskaita = $request->request->get("psaskaita");
        $plaikas = $request->request->get("plaikas");
        $pvirs = $request->request->get("pvirs");
        $patl = $request->request->get("patl");
        $apy = $request->request->get("apy");
        $vt = $request->request->get("vt");
        $kasa = $request->request->get("kasa");

        $svardas = $request->request->get("svardas");
        $spavarde = $request->request->get("spavarde");
        $svartotojas = $request->request->get("svvardas");
        $ssaskaita = $request->request->get("ssaskaita");
        $slaikas = $request->request->get("slaikas");
        $svirs = $request->request->get("svirs");
        $satl = $request->request->get("satl");
        $pareigos = $request->request->get("pareigos");
        $sandelis = $request->request->get("sandeliai");
        $siuntos = $request->request->get("siuntos");

        $error = "";
        $msg = "";
        $count = 0;


        if (!empty($bvardas) && !empty($bpavarde) && !empty($bvartotojas) && !empty($bsaskaita) && !empty($blaikas) && is_numeric($bvirs) && !empty($batl) && !empty($pastas) && !empty($nr) && !empty($knr) && is_numeric($ofisas))
        {
            $query = "INSERT INTO buhalteriai (el_pastas, telefono_numeris, kompiuterio_numeris, vardas, pavarde, vartotojo_vardas, banko_saskaita, darbo_laikas, virsvalandziu_skaicius, fk_Ofisasid_Ofisas, atlyginimas)
                    VALUES ('$pastas', '$nr', '$knr', '$bvardas', '$bpavarde', '$bvartotojas', '$bsaskaita', '$blaikas', '$bvirs', '$ofisas', '$batl')";
            $this->conn->query($query);
            $count++;
        }
        if (!empty($pvardas) && !empty($ppavarde) && !empty($pvartotojas) && !empty($psaskaita) && !empty($plaikas) && is_numeric($pvirs) && !empty($patl) && !empty($apy) && !empty($vt) && !empty($kasa))
        {
            $query = "INSERT INTO pardavejai (menesine_apyvarta, parduotuves_vieta, kasa, vardas, pavarde, vartotojo_vardas, banko_saskaita, darbo_laikas, virsvalandziu_skaicius, atlyginimas)
                    VALUES ('$apy', '$vt', '$kasa', '$pvardas', '$ppavarde', '$pvartotojas', '$psaskaita', '$plaikas', '$pvirs', '$patl')";
            $this->conn->query($query);
            $count++;
        }

        if (!empty($svardas) && !empty($spavarde) && !empty($svartotojas) && !empty($ssaskaita) && !empty($slaikas) && is_numeric($svirs) && !empty($satl) && !empty($pareigos) && is_numeric($sandelis) && is_numeric($siuntos))
        {
            $query = "INSERT INTO sandelininkai (atilktu_siuntu_kiekis, pareigos, vardas, pavarde, vartotojo_vardas, banko_saskaita, darbo_laikas, virsvalandziu_skaicius, fk_Sandelisid_Sandelis, atlyginimas)
                    VALUES ('$siuntos', '$pareigos', '$svardas', '$spavarde', '$svartotojas', '$ssaskaita', '$slaikas', '$svirs', '$sandelis', '$satl')";
            $this->conn->query($query);
            $count++;
        }

        if ($count > 0)
        {
            $msg = strval($count)." nauji darbuotojai sukurti!";
        }
        else
        {
            $error = "Trūksta duomenų!";
        }

        return $this->redirect("/idarbinimo?msg=" . $msg. "&error=" . $error);
    }

    #[Route('/idarbinimo', name: 'idarbinimo')]
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

        $q = "SELECT * FROM ofisai";
        $res = $this->conn->query($q);
        $ofi = [];
        while ($row = $res->fetch_assoc()) {
            $ofi[] = $row;
        }

        $q = "SELECT * FROM sandeliai";
        $res = $this->conn->query($q);
        $san = [];
        while ($row = $res->fetch_assoc()) {
            $san[] = $row;
        }

        $q = "SELECT * FROM pareigos";
        $res = $this->conn->query($q);
        $par = [];
        while ($row = $res->fetch_assoc()) {
            $par[] = $row;
        }

        $q = "SELECT * FROM dydis";
        $res = $this->conn->query($q);
        $dyd = [];
        while ($row = $res->fetch_assoc()) {
            $dyd[] = $row;
        }

        return $this->render('idarbinimo/index.html.twig', [
            'ofisai' => $ofi,
            'sandeliai' => $san,
            'pareigos' => $par,
            'dydziai' => $dyd,
            'msg' => $msg,
            'error' => $error,
        ]);
    }
}
