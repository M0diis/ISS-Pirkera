<?php

namespace App\Controller;

use mysqli;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class WarehouseOrderAcceptanceController extends AbstractController {

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
         * @Route("/warehouseOrder/accept", methods = {"GET"})
         */
        public function getAcceptView() {
            /*$q = "SELECT id_Uzsakymo_busena AS state, name FROM Uzsakymo_busena";
            $result = $this->connection->query($q);
            $states = [];

            while ($row = $result->fetch_assoc()) {
                $states[] = $row;
            }*/

            return $this->render('warehouseOrder/getAccept.html.twig', [
                'errors' => null,
                'states' => $this->getOrderStates()
            ]);
        }

        /**
         * @Route("/warehouseOrder/accept", methods = {"POST"})
         */
        public function postAcceptView(Request $request) {
            $num = $request->request->get('code');
            $newState = $request->request->get('state');
            settype($num, 'integer');

            $stmt = $this->connection->prepare("SELECT id_Sandelio_uzsakymas, numeris FROM Sandelio_uzsakymai WHERE numeris = ?");
            $stmt->bind_param("s", $num);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows < 1) {
                return $this->render('warehouseOrder/getAccept.html.twig', [
                    'errors' => ['No such order exists.'],
                    'states' => $this->getOrderStates()
                ]);
            }

            $result = $result->fetch_assoc();
            $orderId = $result['id_Sandelio_uzsakymas'];

            $stmt = $this->connection->prepare("UPDATE Sandelio_uzsakymai SET busena = ? WHERE Prekes.id_Preke = ?");
            $stmt->bind_param("ii", $newCount, $productId);
            $result = $stmt->execute();

            if (!$result) {
                return $this->render('productRefund/getRefund.html.twig', [
                    'errors' => ['Could not update product count.']
                ]);
            }

            return $this->render('productRefund/getRefunded.html.twig', []);
        }

        private function getOrderStates() {
            $q = "SELECT id_Uzsakymo_busena AS state, name FROM Uzsakymo_busena";
            $result = $this->connection->query($q);
            $states = [];

            while ($row = $result->fetch_assoc()) {
                $states[] = $row;
            }

            return $states;
        }
    }

?>