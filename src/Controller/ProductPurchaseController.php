<?php

namespace App\Controller;

use mysqli;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ProductPurchaseController extends AbstractController {

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
         * @Route("/product/createOrder", methods = {"GET"})
         */
        public function getProductOrder() {
            return $this->render('productPurchase/createOrder.html.twig', [
                'errors' => null
            ]);
        }

        /**
         * @Route("/product/createOrder", methods = {"POST"})
         */
        public function postProductOrder(Request $request) {
            $firstName = $request->request->get("first_name");
            $lastName = $request->request->get("last_name");
            $email = $request->request->get("email");

            if (!$firstName ) {
                return $this->render('productPurchase/createOrder.html.twig', [
                    'errors' => ['No client first name given']
                ]);
            }
            if (!$lastName ) {
                return $this->render('productPurchase/createOrder.html.twig', [
                    'errors' => ['No client last name given']
                ]);
            }
            if (!$email ) {
                return $this->render('productPurchase/createOrder.html.twig', [
                    'errors' => ['No client email given']
                ]);
            }

            $stmt = $this->connection->prepare("SELECT id_Naudotojas, vardas, pavarde, el_pastas FROM Klientai WHERE el_pastas LIKE ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            $clientId = "";

            if ($result->num_rows == 0) {
                $stmt = $this->connection->prepare("INSERT INTO Klientai (id_Naudotojas, vardas, pavarde, el_pastas) VALUES (0, ?, ?, ?);");
                $stmt->bind_param("sss", $firstName, $lastName, $email);
                $stmt->execute();
                $clientId = $stmt->insert_id;
            } else {
                $clientId = $result->fetch_assoc()['id_Naudotojas'];
            }

            $productList = array();
            $i = 0;
            
            while ($request->request->get("order-$i") != null) {
                array_push($productList, $request->request->get("order-$i"));
                $i = $i + 1;
            }

            if ($i == 0) {
                return $this->render('productPurchase/createOrder.html.twig', [
                    'errors' => ['No product numbers given']
                ]);
            }

            $placeholders = array_fill(0, $i, '?');
            $stmt = $this->connection->prepare("SELECT barkodas, kaina, kiekis FROM Prekes WHERE barkodas IN (".implode(',', $placeholders).") AND kiekis > 0;");
            $stmt->bind_param(str_repeat('i', $i), ...$productList);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows != $i) {
                return $this->render('productPurchase/createOrder.html.twig', [
                    'errors' => ['Not all products found in database']
                ]);
            }

            $sum = 0;

            while ($row = $result->fetch_assoc()) {
                $sum = $sum + $row['kaina'];
            }

            $session = $request->getSession();
            $clerkId = $request->request->get('clerk_id');

            $insertQuery = "INSERT INTO uzsakymai (uzsakymo_numeris, suma, ivykdymo_data, mokejimo_budas, busena, fk_Pardavejasid_Naudotojas, fk_Klientasid_Naudotojas, fk_Saskaita_fakturanumeris) VALUES (0, ?, NULL, NULL, 2, ?, ?, NULL)";
            $stmt = $this->connection->prepare($insertQuery);
            $stmt->bind_param("dii", $sum, $clerkId, $clientId);
            $result = $stmt->execute();

            if (!$result) {
                return $this->render('productPurchase/createOrder.html.twig', [
                    'errors' => [$stmt->error, $this->connection->error]
                ]);
            }

            $orderId = $stmt->insert_id;

            foreach ($productList as $product) {
                $stmt = $this->connection->prepare("INSERT INTO Uzsakymo_prekes (fk_Prekebarkodas, fk_Uzsakymasuzsakymo_numeris) VALUES (?, ?);");
                $stmt->bind_param("ii", $product, $orderId);
                $result = $stmt->execute();

                if (!$result) {
                    return $this->render('productPurchase/createOrder.html.twig', [
                        'errors' => [$orderId, $product, $stmt->error]
                    ]);
                }
            }

            $session->set('data_order_id', $orderId);

            return $this->redirect('paymentMethod');
        }

        /**
         * @Route("/product/paymentMethod", methods = {"GET"})
         */
        public function getPaymentMethod(Request $request) {
            $session = $request->getSession();
            $orderId = $session->get('data_order_id');

            if (!$orderId) {
                return $this->redirect('createOrder');
            }

            $stmt = $this->connection->prepare("SELECT id_Mokejimo_budas AS id, name FROM Mokejimo_budas;");
            $stmt->execute();
            $result = $stmt->get_result();

            $methods = array();

            while ($row = $result->fetch_assoc()) {
                $methods[] = $row;
            }

            return $this->render('productPurchase/paymentMethods.html.twig', [
                'orderId' => $orderId,
                'methods' => $methods
            ]);
        }

        /**
         * @Route("/product/paymentMethod", methods = {"POST"})
         */
        public function postPaymentMethod(Request $request) {
            $session = $request->getSession();
            $orderId = $session->get('data_order_id');

            $methodId = $request->request->get('method');
            settype($methodId, 'int');

            if (!$orderId) {
                return $this->redirect('createOrder');
            }

            $stmt = $this->connection->prepare("SELECT id_Mokejimo_budas AS id, name FROM Mokejimo_budas WHERE id_Mokejimo_budas = ?;");
            $stmt->bind_param("i", $methodId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows != 1) {
                return $this->redirect('paymentMethod');
            }

            $stmt = $this->connection->prepare("UPDATE Uzsakymai SET mokejimo_budas = ? WHERE uzsakymo_numeris = ?;");
            $stmt->bind_param("ii", $methodId, $orderId);
            $stmt->execute();

            $method = $result->fetch_assoc()['name'];
            $session->set('data_method', $method);
            return $this->render('productPurchase/payment.html.twig', [
                'method' => $method
            ]);
        }

        /**
         * @Route("/product/payment", methods = {"POST"})
         */
        public function postPayment(Request $request) {
            $session = $request->getSession();
            $orderId = $session->get('data_order_id');
            $method = $session->get('data_method');

            if (!$method || !$orderId) {
                return $this->redirect('createOrder');
            }

            //----------------------------------------------------------------------------------------------------------------------
            if ($method == 'Grynais') {
                $money = $request->request->get('money');

                if (!$money) {
                    $session->remove('data_order_id');
                    $session->remove('data_method');

                    return $this->render('productPurchase/paymentResult.html.twig', [
                        'errors' => ['No payment money provided'],
                        'success' => false,
                        'return' => null
                    ]);
                }

                if ($money < 0) {
                    $session->remove('data_order_id');
                    $session->remove('data_method');

                    return $this->render('productPurchase/paymentResult.html.twig', [
                        'errors' => ['Negative payment provided'],
                        'success' => false,
                        'return' => null
                    ]);
                }

                $stmt = $this->connection->prepare("SELECT uzsakymo_numeris, suma FROM Uzsakymai WHERE uzsakymo_numeris = ?");
                $stmt->bind_param("i", $orderId);
                $stmt->execute();
                $result = $stmt->get_result();

                $order = $result->fetch_assoc();

                if ($order['suma'] <= $money) {
                    $currentDate = date("Y-m-d H:i:s");
                    $stmt = $this->connection->prepare("UPDATE Uzsakymai SET busena = 1, ivykdymo_data = ? WHERE uzsakymo_numeris = ?");
                    $stmt->bind_param("si", $currentDate, $orderId);
                    $stmt->execute();

                    $session->remove('data_order_id');
                    $session->remove('data_method');

                    $this->reduceProductCounts($orderId);

                    return $this->render('productPurchase/paymentResult.html.twig', [
                        'errors' => null,
                        'success' => true,
                        'return' => $money - $order['suma']
                    ]);
                } else {
                    $session->remove('data_order_id');
                    $session->remove('data_method');

                    return $this->render('productPurchase/paymentResult.html.twig', [
                        'errors' => ['Not enough cash was provided'],
                        'success' => false,
                        'return' => null
                    ]);
                }
            //----------------------------------------------------------------------------------------------------------------------
            } else if ($method == 'Kortele') {
                $creditCardNumber = $request->request->get('card_number');

                if (!$creditCardNumber) {
                    $session->remove('data_order_id');
                    $session->remove('data_method');

                    return $this->render('productPurchase/paymentResult.html.twig', [
                        'errors' => ['No credit card number provided'],
                        'success' => false,
                        'return' => null
                    ]);
                }

                $stmt = $this->connection->prepare("SELECT uzsakymo_numeris, suma FROM Uzsakymai WHERE uzsakymo_numeris = ?");
                $stmt->bind_param("i", $orderId);
                $stmt->execute();
                $result = $stmt->get_result();

                $order = $result->fetch_assoc();

                $success = $this->makeCreditCardPayment($creditCardNumber, $order['suma']);

                if ($success) {
                    $currentDate = date("Y-m-d H:i:s");
                    $stmt = $this->connection->prepare("UPDATE Uzsakymai SET busena = 1, ivykdymo_data = ? WHERE uzsakymo_numeris = ?");
                    $stmt->bind_param("si", $currentDate, $orderId);
                    $stmt->execute();

                    $session->remove('data_order_id');
                    $session->remove('data_method');

                    $this->reduceProductCounts($orderId);

                    return $this->render('productPurchase/paymentResult.html.twig', [
                        'errors' => null,
                        'success' => true,
                        'return' => null
                    ]);
                } else {
                    $session->remove('data_order_id');
                    $session->remove('data_method');

                    return $this->render('productPurchase/paymentResult.html.twig', [
                        'errors' => ['Credit card payment failed'],
                        'success' => false,
                        'return' => null
                    ]);
                }
            //----------------------------------------------------------------------------------------------------------------------
            } else {
                $money = $request->request->get('money');
                $code = $request->request->get('code');

                if (!$money) {
                    $session->remove('data_order_id');
                    $session->remove('data_method');

                    return $this->render('productPurchase/paymentResult.html.twig', [
                        'errors' => ['No payment money provided'],
                        'success' => false,
                        'return' => null
                    ]);
                }

                if (!$code) {
                    $session->remove('data_order_id');
                    $session->remove('data_method');

                    return $this->render('productPurchase/paymentResult.html.twig', [
                        'errors' => ['No gift code provided'],
                        'success' => false,
                        'return' => null
                    ]);
                }

                if ($money < 0) {
                    $session->remove('data_order_id');
                    $session->remove('data_method');

                    return $this->render('productPurchase/paymentResult.html.twig', [
                        'errors' => ['Negative payment provided'],
                        'success' => false,
                        'return' => null
                    ]);
                }

                $stmt = $this->connection->prepare("SELECT id_Dovanu_cekis, kodas, galiojimo_data, verte, fk_Uzsakymasid_Uzsakymas FROM Dovanu_cekiai WHERE kodas = ?");
                $stmt->bind_param("s", $code);
                $stmt->execute();
                $result = $stmt->get_result();

                if (!$result) {
                    $session->remove('data_order_id');
                    $session->remove('data_method');

                    return $this->render('productPurchase/payment', [
                        'errors' => ['Provided gift code does not exist'],
                        'success' => false,
                        'return' => null
                    ]);
                }

                $giftCode = $result->fetch_assoc();

                if ($giftCode['fk_Uzsakymasid_Uzsakymas'] != null) {
                    $session->remove('data_order_id');
                    $session->remove('data_method');

                    return $this->render('productPurchase/paymentResult.html.twig', [
                        'errors' => ['Gift code already used'],
                        'success' => false,
                        'return' => null
                    ]);
                }

                $now = date("Y-m-d H:i:s");

                if ($giftCode['galiojimo_data'] < $now) {
                    $session->remove('data_order_id');
                    $session->remove('data_method');

                    return $this->render('productPurchase/paymentResult.html.twig', [
                        'errors' => ['Expired gift code'],
                        'success' => false,
                        'return' => null
                    ]);
                }

                $stmt = $this->connection->prepare("SELECT uzsakymo_numeris, suma FROM Uzsakymai WHERE uzsakymo_numeris = ?");
                $stmt->bind_param("i", $orderId);
                $stmt->execute();
                $result = $stmt->get_result();

                $order = $result->fetch_assoc();

                if ($giftCode['verte'] + $money < $order['suma']) {
                    $session->remove('data_order_id');
                    $session->remove('data_method');

                    return $this->render('productPurchase/paymentResult.html.twig', [
                        'errors' => ['Not enough money'],
                        'success' => false,
                        'return' => null
                    ]);
                } else {
                    $stmt = $this->connection->prepare("UPDATE Dovanu_cekiai SET fk_Uzsakymasid_Uzsakymas = ? WHERE id_Dovanu_cekis = ?");
                    $stmt->bind_param("ii", $orderId, $giftCode['id_Dovanu_cekis']);
                    $stmt->execute();
                    $currentDate = date("Y-m-d H:i:s");
                    $stmt = $this->connection->prepare("UPDATE Uzsakymai SET busena = 1, ivykdymo_data = ? WHERE uzsakymo_numeris = ?");
                    $stmt->bind_param("si", $currentDate, $orderId);
                    $stmt->execute();

                    $session->remove('data_order_id');
                    $session->remove('data_method');

                    $this->reduceProductCounts($orderId);

                    return $this->render('productPurchase/paymentResult.html.twig', [
                        'errors' => null,
                        'success' => true,
                        'return' => ($giftCode['verte'] + $money) - $order['suma']
                    ]);
                }
            }
        }

        private function makeCreditCardPayment(string $card_num, float $money) : bool {
            return true;
        }

        private function reduceProductCounts($orderId) {
            $stmt = $this->connection->prepare("SELECT fk_Prekebarkodas, fk_Uzsakymasuzsakymo_numeris FROM Uzsakymo_prekes WHERE fk_Uzsakymasuzsakymo_numeris = ?;");
            $stmt->bind_param("i", $orderId);
            $stmt->execute();
            $result = $stmt->get_result();

            $productIds = [];

            while ($row = $result->fetch_assoc()) {
                $productIds[] = $row['fk_Prekebarkodas'];
            }

            $placeholders = array_fill(0, count($productIds), '?');
            $stmt = $this->connection->prepare("UPDATE Prekes SET kiekis = kiekis - 1 WHERE barkodas IN (".implode(',', $placeholders).")");
            $stmt->bind_param(str_repeat('i', count($productIds)), ...$productIds);
            $stmt->execute();
        }
    }

?>