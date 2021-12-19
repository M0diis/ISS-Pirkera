<?php

namespace App\Controller;

use EasyPost\EasyPost;
use JetBrains\PhpStorm\NoReturn;
use mysqli;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class DocumentationGenerationController extends AbstractController
{
    private string $api_key = "TEST_E9zoBMUuLdR8Ss3KRIdjJDMnuzmhWJH9o/pefNZ1nB8";
    private string $api = "https://api.shipengine.com/v1/labels";

    private RequestStack $requestStack;
    private mysqli $conn;

    private HttpClientInterface $client;

    public function __construct(RequestStack $requestStack, HttpClientInterface $client)
    {
        EasyPost::setApiKey($this->api_key);

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

        $this->client = $client;
    }

    private function getWarehouses(): array
    {
        $sql = "SELECT * FROM sandeliai";
        $result = $this->conn->query($sql);

        $warehouses = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $warehouses[] = $row;
            }
        }

        return $warehouses;
    }



    private function getAddress($id) : array
    {
        $sql = "SELECT * FROM adresai WHERE fk_Sandelisid_Sandelis='$id'";

        $result = $this->conn->query($sql)->fetch_assoc();

        $sql = "SELECT * FROM sandeliai WHERE id_Sandelis='$id'";

        $phone = $this->conn->query($sql)->fetch_assoc()['kontaktinis_telefonas'];

        return [
            'from_zipcode' => $result['pasto_kodas'],
            'from_street' => $result['gatve'],
            'from_city' => $result['miestas'],
            'from_country' => $result['salis'],
            'from_building_nr' => $result['pastato_nr'],
            'from_phone' => $phone
        ];
    }

    private function generate(array $values) : Response
    {
        $curl = curl_init();

        $from_address = $this->getAddress($values['warehouse']);

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.shipengine.com/v1/labels',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'
            {
                  "shipment": 
                  {
                    "service_code": "ups_ground",
                    "ship_to": 
                    {
                      "name": "'.$values['to_name'].'",
                      "company": "'.$values['to_company'].'",
                      "city_locality": "'."San Jose"/*$values['to_city']*/.'",
                      "address_line1": "'."525 S Winchester Blvd"/*$values['to_street']*/.'",
                      "phone": "'.$values['to_phone'].'",
                      "state_province": "CA",
                      "postal_code": "'."95128"/*$values['to_zipcode']*/.'",
                      "country_code": "US",
                      "address_residential_indicator": "yes"
                    },
                    "ship_from": {
                      "name": "Pirkera",
                      "company_name": "Pirkera",
                      "phone": "'.$from_address['from_phone'].'",
                      "address_line1": "'."4009 Marathon Blvd"/*$values['from_street']*/.'",
                      "city_locality": "'."Austin"/*$values['from_city']*/.'",
                      "state_province": "TX",
                      "postal_code": "'."78756"/*$values['from_zipcode']*/.'",
                      "country_code": "US",
                      "address_residential_indicator": "no"
                    },
                    "packages": [
                      {
                        "weight": {
                          "value": '.$values['parcel_weight'].',
                          "unit": "ounce"
                        },
                        "dimensions": {
                          "height": '.$values['parcel_height'].',
                          "width": '.$values['parcel_width'].',
                          "length": '.$values['parcel_length'].',
                          "unit": "inch"
                        }
                      }
                    ]
                  }
                }',
            CURLOPT_HTTPHEADER => array(
                'Host: api.shipengine.com',
                'API-Key: TEST_E9zoBMUuLdR8Ss3KRIdjJDMnuzmhWJH9o/pefNZ1nB8',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response = json_decode($response, true);

        $errors = array();

        if(isset($response['errors']))
        {
            foreach($response['errors'] as $error)
            {
                $errors[] = $error['message'];
            }
        }

        $label_url = null;

        if(isset($response['label_download']))
        {
            $label_url = $response['label_download']['pdf'];
        }

        return $this->render('warehouse/documentation_gen.html.twig', [
            'errors' => $errors,
            'warehouses' => $this->getWarehouses(),
            'generated' => $label_url
        ]);
    }

    /**
     * @Route("/warehouse/documentation_gen", name="documentation_gen", methods={"GET"})
     */
    public function documentationGeneration(): Response
    {
        return $this->render('warehouse/documentation_gen.html.twig', [
            'errors' => array(),
            'warehouses' => $this->getWarehouses(),
            'generated' => null
        ]);
    }

    /**
     * @Route("/warehouse/documentation_gen", methods={"POST"})
     */
    public function documentationGen(Request $request)
    {
        $to_name = $request->request->get('to_name');
        $to_street = $request->request->get('to_street');
        $to_company = $request->request->get('to_company');
        $to_city = $request->request->get('to_city');
        $to_zipcode = $request->request->get('to_zipcode');
        $to_phone = $request->request->get('to_phone');

        $length = $request->request->get('parcel_length');
        $width = $request->request->get('parcel_width');
        $height = $request->request->get('parcel_height');
        $distance_unit = $request->request->get('parcel_distance_unit');

        $weight = $request->request->get('parcel_weight');
        $weight_unit = $request->request->get('parcel_weight_unit');

        $warehouse = $request->request->get('warehouse');

        $values = array(
            'to_name' => $to_name,
            'to_street' => $to_street,
            'to_company' => $to_company,
            'to_city' => $to_city,
            'to_zipcode' => $to_zipcode,
            'to_phone' => $to_phone,
            'parcel_length' => $length,
            'parcel_width' => $width,
            'parcel_height' => $height,
            'parcel_distance_unit' => $distance_unit,
            'parcel_weight' => $weight,
            'parcel_weight_unit' => $weight_unit,
            'warehouse' => $warehouse
        );

        return $this->generate($values);
    }
}
