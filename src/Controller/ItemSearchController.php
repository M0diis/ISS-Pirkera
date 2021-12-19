<?php

namespace App\Controller;

use mysqli;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ItemSearchController extends AbstractController
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
     * @Route("/warehouse/item_search", name="item_search", methods={"GET"})
     */
    public function itemSearch(): Response
    {
        return $this->render('warehouse/item_search.html.twig', [
            'errors' => array(),
            'found' => array()
        ]);
    }

    /**
     * @Route("/warehouse/item_search", methods={"POST"})
     */
    public function itemSearchResults(Request $request): Response
    {
        $pavadinimas = $request->request->get('pavadinimas');

        $stmt = $this->conn->prepare("SELECT * FROM prekes WHERE pavadinimas = ?");

        $stmt->bind_param("s", $pavadinimas);
        $stmt->execute();

        $res = $stmt->get_result();
        $stmt->close();

        $errors = array();
        $found = array();

        if ($res->num_rows > 0)
        {
            while ($row = $res->fetch_assoc())
            {
                $found[] = $row;
            }
        }
        else {
            $errors[] = "Nerasta prekių su tokiu pavadinimu.";
            $found = null;
        }

        return $this->render('warehouse/item_search.html.twig', [
            'errors' => $errors,
            'found' => $found
        ]);
    }
}
