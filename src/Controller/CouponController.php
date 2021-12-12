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
            $password = "Shinjitai99";
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
            $sellerId = $request->request->get('sellerId');

            $stmt = $this->connection->prepare("SELECT id, el_pastas FROM klientai WHERE el_pastas = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows < 1) {
                return $this->render('coupon/getCreate.html.twig', [
                    'errors' => ['No user with such email exists.']
                ]);
            }

            $clientId = $result->fetch_assoc()['id'];
            $validUntil = date('Y-m-d', strtotime('+5 years'));
            $code = hash("sha256", $email) + uniqid();
            $stmt = $this->connection->prepare("INSERT INTO dovanu_cekiai (id, verte, galiojimo_data, kodas, pardavejas, klientas) VALUES (null, ?, ?, ?, ?, ?)");
            $stmt->bind_param("dssi", $cost, $validUntil, $code, $sellerId, $clientId);
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