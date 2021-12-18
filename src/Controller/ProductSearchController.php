<?php

namespace App\Controller;

use mysqli;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ProductSearchController extends AbstractController {

        private mysqli $connection;

        public function __construct()
        {
            $hostname = "localhost";
            $username = "root";
            $password = "Shinjitai99";
            $database = "pirketa";
            $port = 3306;

            $this->connection = new mysqli($hostname, $username, $password, $database, $port);
        }

        /**
         * @Route("/product/search", methods = {"GET"})
         */
        public function getSearchView(Request $request) {
            $productName = $request->query->get('name');

            $data = null;
            if (!$productName) {
                $query = "SELECT id_preke, barkodas, pavadinimas FROM Prekes";
                $res = $this->connection->query($query);
                $results = [];

                while ($row = $res->fetch_assoc()) {
                    $results[] = $row;
                }

                $productName = "";
                $data = $results;

            } else {
                $query = "SELECT id_Preke, barkodas, pavadinimas FROM Prekes WHERE pavadinimas = ?";
                $stmt = $this->connection->prepare($query);
                $stmt->bind_param("s", $productName);
                $stmt->execute();

                $res = $stmt->get_result();
                $results = [];
                while ($row = $res->fetch_assoc()) {
                    $results[] = $row;
                }

                $data = $results;
            }

            return $this->render('productSearch/getSearch.html.twig', [
                'products' => $data,
                'name' => $productName
            ]);
        }
    }

?>