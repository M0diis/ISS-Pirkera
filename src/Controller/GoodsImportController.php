<?php

namespace App\Controller;

use mysqli;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GoodsImportController extends AbstractController
{
    private mysqli $conn;

    public function __construct()
    {
        $hostname = "localhost";
        $username = "root";
        $password = "";
        $database = "pirketa";

        $this->conn = new mysqli($hostname, $username, $password, $database);

        if ($this->conn->connect_error)
        {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    private function getWarehouses(): array
    {
        $sql = "SELECT * FROM sandeliai";
        $result = $this->conn->query($sql);

        $warehouses = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $warehouses[] = $row;
            }
        }

        return $warehouses;
    }

    /**
     * @Route("/warehouse/import", name="goods_import", methods={"GET"})
     */
    public function goodsImport(): Response
    {
        return $this->render('warehouse/goods_import.html.twig', [
            'errors' => array(),
            'imported' => array(),
            'warehouses' => $this->getWarehouses()
        ]);
    }

    /**
     * @Route("/warehouse/import", methods={"POST"})
     */
    public function goodsImported(Request $request): Response
    {
        $barkodas = $request->request->get('barkodas');

        $exists = $this->conn->query("SELECT * FROM prekes WHERE barkodas = '$barkodas'");

        if ($exists->num_rows > 0)
        {
            return $this->render('warehouse/goods_import.html.twig', [
                'imported' => array(),
                'errors' => array('Prekė su tokiu barkodu jau egzistuoja'),
                'warehouses' => $this->getWarehouses()
            ]);
        }

        $kiekis = $request->request->get('kiekis');
        $kaina = $request->request->get('kaina');
        $pavadinimas = $request->request->get('pavadinimas');
        $sandelis = $request->request->get('sandelis');

        $stmt = $this->conn->prepare("INSERT INTO prekes (barkodas, kiekis, kaina, pavadinimas, fk_Sandelisid_Sandelis, fk_Buhalterisid_Naudotojas) VALUES (?, ?, ?, ?, ?, 1)");

        $stmt->bind_param("sssss", $barkodas, $kiekis, $kaina, $pavadinimas, $sandelis);
        $stmt->execute();

        $res = $stmt->get_result();
        $stmt->close();

        $imported = array(
            "barkodas" => $barkodas,
            "kiekis" => $kiekis,
            "kaina" => $kaina,
            "pavadinimas" => $pavadinimas
        );

        return $this->render('warehouse/goods_import.html.twig', [
            'imported' => $imported,
            'errors' => array(),
            'warehouses' => $this->getWarehouses()
        ]);
    }
}
