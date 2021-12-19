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

            $stmt = $this->connection->prepare("SELECT numeris FROM sandelio_uzsakymai WHERE numeris = ?");
            $stmt->bind_param("i", $num);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows < 1) {
                return $this->render('warehouseOrder/getAccept.html.twig', [
                    'errors' => ['No such order exists.'],
                    'states' => $this->getOrderStates()
                ]);
            }

            $result = $result->fetch_assoc();
            $orderId = $result['numeris'];

            $stmt = $this->connection->prepare("SELECT id_Uzsakymo_busena, name FROM uzsakymo_busena WHERE id_Uzsakymo_busena = ?");
            $stmt->bind_param("i", $newState);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows < 1) {
                return $this->render('warehouseOrder/getAccept.html.twig', [
                    'errors' => ['No such order state exists.'],
                    'states' => $this->getOrderStates()
                ]);
            }

            $result = $result->fetch_assoc();
            $newStateId = $result['id_Uzsakymo_busena'];
            $stateName = $result['name'];

            $stmt = $this->connection->prepare("UPDATE Sandelio_uzsakymai SET busena = ? WHERE sandelio_uzsakymai.numeris = ?");
            $stmt->bind_param("ii", $newStateId, $orderId);
            $result = $stmt->execute();

            if (!$result) {
                return $this->render('warehouseOrder/getAccept.html.twig', [
                    'errors' => ['Could not update order status.'],
                    'states' => $this->getOrderStates()
                ]);
            }

            return $this->render('warehouseOrder/getAccepted.html.twig', [
                'orderNum' => $num,
                'newState' => $stateName
            ]);
        }

        private function getOrderStates() {
            $q = "SELECT id_Uzsakymo_busena AS state, name FROM uzsakymo_busena";
            $result = $this->connection->query($q);
            $states = [];

            while ($row = $result->fetch_assoc()) {
                $states[] = $row;
            }

            return $states;
        }
    }

?>