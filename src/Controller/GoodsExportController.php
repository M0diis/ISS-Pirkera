<?php

namespace App\Controller;

use mysqli;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GoodsExportController extends AbstractController
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
     * @Route("/warehouse/export", name="goods_export")
     */
    public function goodsExport(): Response
    {
        $session = $this->requestStack->getSession();

        $pending = array();

        $curr_pending = $session->get('pending');

        if ($curr_pending == null)
        {
            $curr_pending = array();

            $session->set('pending', $curr_pending);
        }

        for($p = 0; $p < count($curr_pending); $p++)
        {
            $id = $curr_pending[$p]['id'];
            $required = $curr_pending[$p]['kiekis'];

            $stmt = $this->conn->prepare("SELECT * FROM prekes WHERE barkodas = ?");
            $stmt->bind_param("s", $id);
            $stmt->execute();

            $result = $stmt->get_result();

            $arr = $result->fetch_assoc();

            $pavadinimas = $arr['pavadinimas'];
            $barkodas = $arr['barkodas'];
            $kaina = $arr['kaina'];
            $kiekis = $arr['kiekis'];

            $pending[] = array(
                'id' => $id,
                'yra' => $kiekis,
                'reikia' => $required,
                'pavadinimas' => $pavadinimas,
                'barkodas' => $barkodas,
                'kaina' => $kaina,
            );
        }

        return $this->render('warehouse/goods_export.html.twig', [
            'errors' => array(),
            'pending' => $pending,
            'exported' => null
        ]);
    }

    /**
     * @Route("/warehouse/export/send/{id}/{amount}", methods={"GET", "HEAD"})
     */
    public function goodsExported(int $id, int $amount): Response
    {
        $session = $this->requestStack->getSession();

        $pending = $session->get('pending');

        $res = $this->conn->query("UPDATE prekes SET kiekis = kiekis - $amount WHERE id = $id");

        $exported = null;

        for($p = 0; $p < count($pending); $p++)
        {
            if($pending[$p]['id'] == $id)
            {
                $exported = $pending[$p];

                unset($pending[$p]);
            }
        }

        $session->set('pending', $pending);

        return $this->render('warehouse/goods_export.html.twig', [
            'errors' => array(),
            'pending' => $pending,
            'exported' => $exported
        ]);
    }
}
