<?php

namespace App\Controller;

use mysqli;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WarehouseController extends AbstractController
{
    private mysqli $conn;

    public function __construct()
    {
        $hostname = "localhost";
        $username = "root";
        $password = "";
        $database = "pirketa";

        $this->conn = new mysqli($hostname, $username, $password, $database);

        if ($this->conn->connect_error)
        {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    /**
     * @Route("/warehouse", name="warehouse_main")
     */
    public function warehouseMain(): Response
    {
        return $this->render('warehouse/warehouse_main.html.twig');
    }
}
