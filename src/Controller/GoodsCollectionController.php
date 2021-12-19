<?php

namespace App\Controller;

use mysqli;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GoodsCollectionController extends AbstractController
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
     * @Route("/warehouse/collection", name="goods_collection", methods={"GET"})
     */
    public function goodsCollection(): Response
    {
        return $this->render('warehouse/goods_collection.html.twig', [
            'errors' => array(),
            'imported' => null
        ]);
    }

    /**
     * @Route("/warehouse/collection", methods={"POST"})
     */
    public function goodsCollected(Request $request): Response
    {
        $pavadinimas = $request->request->get('pavadinimas');
        $kiekis = $request->request->get('kiekis');

        $session = $this->requestStack->getSession();

        $session->set('pending', array());

        $stmt = $this->conn->prepare("SELECT * FROM prekes WHERE pavadinimas = ?");

        $stmt->bind_param("s", $pavadinimas);
        $stmt->execute();

        $result = $stmt->get_result();

        $errors = [];

        $arr = $result->fetch_assoc();

        if(!isset($arr['pavadinimas']))
        {
            $errors[] = "Tokios prekės nėra.";
        }
        else
        {
            $curr_amt = $arr['kiekis'];
            $id = $arr['id'];

            if($curr_amt < $kiekis)
            {
                $errors[] = "Nepakanka prekių. Sandėlyje yra: " . $curr_amt . ".";
            }
            else if($result->num_rows == 0)
            {
                $errors[] = "Prekės pavadinimas nerastas.";
            }
            else
            {
                $session = $this->requestStack->getSession();

                $pending = $session->get('pending');

                if ($pending === null) {
                    $pending = array();
                }

                $pending[] = array(
                    'id' => $id,
                    'kiekis' => $kiekis
                );

                $session->set('pending', $pending);
            }

            $stmt->close();
        }

        return $this->render('warehouse/goods_collection.html.twig', [
            'errors' => $errors,
            'imported' => $pavadinimas
        ]);
    }
}
