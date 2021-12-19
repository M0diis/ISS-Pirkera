<?php

namespace App\Controller;

use mysqli;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ProductRefundController extends AbstractController {

        private mysqli $connection;

        public function __construct()
        {
            $hostname = "localhost";
            $username = "root";
            $password = "";
            $database = "pirketa";
            $port = 3306;

            $this->connection = new mysqli($hostname, $username, $password, $database, $port);
        }

        /**
         * @Route("/product/refund", methods = {"GET"})
         */
        public function getRefundView() {
            return $this->render('productRefund/getRefund.html.twig', [
                'errors' => null
            ]);
        }

        /**
         * @Route("/product/refund", methods = {"POST"})
         */
        public function postRefundView(Request $request) {
            $barcode = $request->request->get('barcode');
            $count = $request->request->get('count');
            settype($count, 'integer');

            if ($count <= 0) {
                return $this->render('productRefund/getRefund.html.twig', [
                    'errors' => ['Refund count must be a positive integer.']
                ]);
            }

            $stmt = $this->connection->prepare("SELECT barkodas, kiekis FROM Prekes WHERE barkodas = ?");
            $stmt->bind_param("s", $barcode);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows < 1) {
                return $this->render('productRefund/getRefund.html.twig', [
                    'errors' => ['No such product exists.']
                ]);
            }

            $result = $result->fetch_assoc();
            $productId = $result['barkodas'];
            $newCount = $result['kiekis'] + $count;

            $stmt = $this->connection->prepare("UPDATE prekes SET kiekis = ? WHERE prekes.barkodas = ?");
            $stmt->bind_param("ii", $newCount, $productId);
            $result = $stmt->execute();

            if (!$result) {
                return $this->render('productRefund/getRefund.html.twig', [
                    'errors' => ['Could not update product count.']
                ]);
            }

            return $this->render('productRefund/getRefunded.html.twig', []);
        }
    }

?>