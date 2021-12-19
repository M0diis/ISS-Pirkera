<?php

namespace App\Controller;

use mysqli;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CouponController extends AbstractController {

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
         * @Route("/coupon/create", methods = {"GET"})
         */
        public function getCreationView() {
            return $this->render('coupon/getCreate.html.twig', [
                'errors' => null
            ]);
        }

        /**
         * @Route("/coupon/create", methods = {"POST"})
         */
        public function postCreationView(Request $request) {
            $email = $request->request->get('email');
            $cost = $request->request->get('cost');

            $sellerId = $request->request->get('clerk_id');

            $stmt = $this->connection->prepare("SELECT id_Naudotojas AS id, el_pastas FROM Klientai WHERE el_pastas = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows < 1) {
                return $this->render('coupon/getCreate.html.twig', [
                    'errors' => ['No user with such email exists.']
                ]);
            }

            $clientId = $result->fetch_assoc()['id'];
            $validUntil = date('Y-m-d', strtotime('+1 years'));
            $code = hash("sha256", $email).uniqid();
            $stmt = $this->connection->prepare("INSERT INTO Dovanu_cekiai (id_Dovanu_cekis, verte, galiojimo_data, kodas, fk_Pardavejasid_Naudotojas, fk_Klientasid_Naudotojas) VALUES (null, ?, ?, ?, ?, ?)");
            $stmt->bind_param("dssii", $cost, $validUntil, $code, $sellerId, $clientId);
            $result = $stmt->execute();

            if (!$result) {
                return $this->render('coupon/getCreate.html.twig', [
                    'errors' => ['Could not create coupon for client.']
                ]);
            }

            return $this->render('coupon/getCreated.html.twig', [
                'code' => $code
            ]);
        }
    }

?>